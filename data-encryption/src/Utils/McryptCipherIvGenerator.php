<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

use InvalidArgumentException;
use RuntimeException;

class McryptCipherIvGenerator {

    public static function opensslRandomIv(
        CipherType $cipherMethod = CipherType::AES_256_CBC
    ): string {
        if (!extension_loaded('openssl')) {
            throw new RuntimeException('OpenSSL PHP extension is not available.');
        }
        if (!$cipherMethod->isAvailable()) {
            throw new InvalidArgumentException(
                'Cipher is not supported by OpenSSL: ' . $cipherMethod->value
            );
        }
        $ivLength = openssl_cipher_iv_length($cipherMethod->value);
        if ($ivLength === false || $ivLength <= 0) {
            $ivLength = $cipherMethod->getIvLength();
        }
        return random_bytes($ivLength);
    }

    public static function opensslRandomNonce(
        CipherType $cipherType
    ): string {
        if (!$cipherType->isAuthenticated()) {
            throw new InvalidArgumentException(
                'Nonce generation requires an authenticated cipher: ' . $cipherType->value
            );
        }
        return self::opensslRandomIv($cipherType);
    }

    public static function opensslDigestIv(
        string $secretKey,
        CipherType $cipherType = CipherType::AES_256_CBC,
        bool $isBinary = true
    ): string {
        // Derive binary digest, then truncate to exact IV length for the cipher
        $digest = openssl_digest($secretKey, 'SHA256', true);
        if ($digest === false) {
            throw new RuntimeException('OpenSSL digest failed');
        }
        $digest = substr($digest, 0, $cipherType->getIvLength());
        return $isBinary ? $digest : bin2hex($digest);
    }

    public static function hashIv(
        string $secretKey,
        CipherType $cipherType = CipherType::AES_256_CBC,
        int $length = -1
    ): string {
        // Binary hash, not hex - then truncate to cipher's IV length
        $hash = hash('sha256', $secretKey, true);
        $ivLength = $length > 0 ? $length : $cipherType->getIvLength();
        return substr($hash, 0, $ivLength);
    }
}
