<?php
/**
 * Copyright (c) 2014-2015 BitPay
 *
 * 003 - Creating Invoices
 *
 * Requirements:
 *   - Account on https://test.bitpay.com
 *   - Baisic PHP Knowledge
 *   - Private and Public keys from 001.php
 *   - Token value obtained from 002.php
 */
require __DIR__.'/../../vendor/autoload.php';

// See 002.php for explanation
$storageEngine = new \Bitpay\Storage\EncryptedFilesystemStorage('Your Bitpay password'); // Password may need to be updated if you changed it
$privateKey    = $storageEngine->load('../tmp/api.key');
$publicKey     = $storageEngine->load('../tmp/api.pub');
$client        = new \Bitpay\Client\Client();
$network       = new \Bitpay\Network\Testnet();
$adapter       = new \Bitpay\Client\Adapter\CurlAdapter();
$client->setPrivateKey($privateKey);
$client->setPublicKey($publicKey);
$client->setNetwork($network);
$client->setAdapter($adapter);
// ---------------------------

/**
 * The last object that must be injected is the token object.
 */
$token = new \Bitpay\Token();
$token->setToken('paste the token number which is generated from running 002_pair.php file'); // UPDATE THIS VALUE

/**
 * Token object is injected into the client
 */
$client->setToken($token);

/**
 * This is where we will start to create an Invoice object, make sure to check
 * the InvoiceInterface for methods that you can use.
 */
$invoice = new \Bitpay\Invoice();

$buyer = new \Bitpay\Buyer();
$buyer
    ->setEmail('buyeremail@test.com');  

// Add the buyers info to invoice
$invoice->setBuyer($buyer);

/**
 * Item is used to keep track of a few things
 */
$item = new \Bitpay\Item();
$item
    ->setCode('0111')  //set code for your invoice
    ->setDescription('General Description of Item')
    ->setPrice('0.20');   //price for your invoice
$invoice
      ->setItem($item)
      ->setNotificationEmail("Your Email")
      ->setNotificationUrl("https://zeroxray.com/BitPay/ipn.php")
      ->setRedirecturl("https://zeroxray.com/BitPay/")
      ->setCurrency(new \Bitpay\Currency('USD'));
      
/**
 * BitPay supports multiple different currencies. Most shopping cart applications
 * and applications in general have defined set of currencies that can be used.
 * Setting this to one of the supported currencies will create an invoice using
 * the exchange rate for that currency.
 *
 * @see https://test.bitpay.com/bitcoin-exchange-rates for supported currencies
 */


// Configure the rest of the invoice
$invoice
    ->setOrderId('OrderIdFromYourSystem')
    // You will receive IPN's at this URL, should be HTTPS for security purposes!
    ->setNotificationUrl('https://store.example.com/bitpay/callback');


/**
 * Updates invoice with new information such as the invoice id and the URL where
 * a customer can view the invoice.
 */
try {
    $client->createInvoice($invoice);
} catch (\Exception $e) {
    $request  = $client->getRequest();
    $response = $client->getResponse();
    echo (string) $request.PHP_EOL.PHP_EOL.PHP_EOL;
    echo (string) $response.PHP_EOL.PHP_EOL;
    exit(1); // We do not want to continue if something went wrong
}

?>
<html>

<head >

<style>
.tablink {
    background-color: #2b77f2;
    color: white;
    position: static;
    border: groove;
    width=100px
    padding: 30px 30px;
    font-size: 17px;
    left: 50%;
    margin-left: -240px;
    margin-right: -240px;
    margin-top: -50x;
         }
.topleft {
    position: absolute;
    top: 16px;
    left: 3px;
    font-size: 18px;
         }

</style>

<div id="miranHeader" class="tablink" >
 <h3 align='center'>Miranz Bitpay Invoice DEMO</h3>
 <p align='center'>Pakistan's First Block Chain Expert Solutions Provider</p>
 <a href="http://miranz.net/" class="topleft" >
 <img src="img/logo.jpeg" alt="Logo" style="width:90px;height:90px;">
 </a>
</div>

</head>

<body>
<img src="img/buynow.jpeg" alt="Logo" style="width:200px;height:100px;">
</body>
<?php
echo 'Invoice with number "'.$invoice->getId().'" ';
echo 'generated at: '.$invoice->getUrl().PHP_EOL;
?>
</html>