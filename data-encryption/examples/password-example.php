<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use RzSDK\Encryption\PasswordEncryption;

$passwordEncryption = new PasswordEncryption();
$hash = $passwordEncryption->getPassword('example-password');

echo 'Hash: ' . $hash . PHP_EOL;
echo $passwordEncryption->isPasswordVerified('example-password', $hash)
    ? 'Password verified' . PHP_EOL
    : 'Password verification failed' . PHP_EOL;
