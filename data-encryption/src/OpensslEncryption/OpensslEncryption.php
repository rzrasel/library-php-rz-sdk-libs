<?php
namespace RzSDK\Encryption;

class OpensslEncryption {
    public static function encryptData($data, $key, $iv, $cipherMethod = "AES-256-CBC") {
        return base64_encode(openssl_encrypt($data, $cipherMethod, $key, OPENSSL_RAW_DATA, $iv));
    }

    public static function decryptData($data, $key, $iv, $cipherMethod = "AES-256-CBC") {
        return openssl_decrypt(base64_decode($data), $cipherMethod, $key, OPENSSL_RAW_DATA, $iv);
    }
}
