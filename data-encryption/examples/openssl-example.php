<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use RzSDK\Encryption\CipherType;
use RzSDK\Encryption\McryptCipherIvGenerator;
use RzSDK\Encryption\OpensslEncryption;

// Original data
$data = 'Hello world!';

// Select cipher type
$cipherType = CipherType::AES_256_CBC;

// Get cipher method
$cipherMethod = $cipherType->value;

// Generate encryption key (256 bits / 32 bytes)
$key = random_bytes(32);

// Generate IV based on selected cipher
$iv = McryptCipherIvGenerator::opensslRandomIv($cipherMethod);

// Encrypt
$encrypted = OpensslEncryption::encryptData(
    $data,
    $key,
    $iv,
    $cipherMethod
);

if ($encrypted === false) {
    throw new RuntimeException('Encryption failed.');
}

// Decrypt using the same key and IV
$decrypted = OpensslEncryption::decryptData(
    $encrypted,
    $key,
    $iv,
    $cipherMethod
);

if ($decrypted === false) {
    throw new RuntimeException('Decryption failed.');
}

// Output
echo 'Cipher Type: ' . $cipherType->name . PHP_EOL;
echo 'Cipher Method: ' . $cipherMethod . PHP_EOL;
echo 'Key Length: ' . strlen($key) . ' bytes' . PHP_EOL;
echo 'IV Length: ' . strlen($iv) . ' bytes' . PHP_EOL;
echo 'Original: ' . $data . PHP_EOL;
echo 'Encrypted: ' . $encrypted . PHP_EOL;
echo 'Decrypted: ' . $decrypted . PHP_EOL;