# Bitpay-PHP-Invoice
PHP platform has been used to help beginners to generate invoice using Bitpay php implementation.

## About this tutorial
These scripts allow you to do the following:
1) Create keys to communicate with BitPay's API
2) Pair your keys to your BitPay merchant account
3) Create BitPay invoices


## Getting started
 To begin please visit https://test.bitpay.com/dashboard/signup and register for a BitPay merchant test account. Please fill in all      questions, so you get a fully working test account.

 If you are looking for a testnet bitcoin wallet to test with, please visit https://bitpay.com/wallet and
  create a new wallet.

 If you need testnet bitcoin please visit a testnet faucet, e.g. https://testnet.coinfaucet.eu/en/ or http://tpfaucet.appspot.com/

 For more information about testing, please see https://bitpay.com/docs/testing

 Please make sure to use BitPay's latest PHP library (bitpay/php-client)


## Script 1 & 2: configure your local installation
The following two scripts need to be executed once. These scripts will generate your private/public keys and pair them to your BitPay merchant account:
1. 001_generateKeys.php : generates the private/public keys to sign the communication with BitPay. The private/public keys are stored in your filesystem for later usage.
2. 002_pair.php : pairs your private/public keys to your BitPay merchant account. Please make sure to first create a pairing code in your BitPay merchant account (Payment Tools -> Manage API tokens) and put this pairing code in the script. The script returns an API token that should be put put in index.php, to create invoices permanently.

These first two scripts need to be executed only once.

## Script index: create a BitPay invoice
3. index.php : creates a BitPay invoice. Please make sure to update the script with the API token received from 002_pair.php
   This script returns a BitPay invoice object. You can display the invoice by loading the invoice-URL in a web browser. You can pay the invoice with your bitcoin wallet.


## Procedure
   First go to => Bitpay-PHP-Invoice\index1\tmp
  Then give full file permissions to api.key & api.pub  [RightClick on file, Properties, Security, File permissions]

  Script 001_generateKeys & 002_pair need to be executed once, to properly configure your local installation.
  1. In this script Bitpay-PHP-Invoice\index1\index2\001_generateKeys you just need to write your bitpay password in the this line =>
     $storageEngine = new \Bitpay\Storage\EncryptedFilesystemStorage('Your Bitpay password');
  2. Also in this Bitpay-PHP-Invoice\index1\index2\002_pair script you just need to write password and pairingCode.

  Then just execute this Bitpay-PHP-Invoice\index1\index2\001_generateKeys script.

  Now execute Bitpay-PHP-Invoice\index1\index2\002_pair.It will give you a token number.

  Script Bitpay-PHP-Invoice\index1\index2\index.php creates BitPay invoices.
  1. In this script first you just need to write your bitpay password =>
     $storageEngine = new \Bitpay\Storage\EncryptedFilesystemStorage('Your Bitpay password');
  2. Then, at this line =>
     $token->setToken('paste the token number which is generated from running 002_pair.php file');
  3. You can set your invoice detail in this script like  owner email[Invoice generator], buyer email, fiat currency name, price, description.


![image](https://user-images.githubusercontent.com/30657768/30214948-ade7e526-94c7-11e7-8932-dbe97711cf42.png)
![q](https://user-images.githubusercontent.com/30657768/30215349-2c55367e-94c9-11e7-9524-a1a90d029e30.png)
