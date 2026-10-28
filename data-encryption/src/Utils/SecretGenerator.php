<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

use InvalidArgumentException;
use RuntimeException;

class SecretGenerator {

    /**
     * Create secure secret (HMAC) - 32+ bytes
     * 64 bytes = 512 bits = enough for HS512
     */
    public static function createSecret(int $bytes = 64): string {
        if ($bytes < 32) {
            throw new InvalidArgumentException('JWT secret must be >= 32 bytes');
        }
        // base64url safe, no padding
        return rtrim(strtr(base64_encode(random_bytes($bytes)), '+/', '-_'), '=');
    }
    /**
     * Create raw JWT secret (binary) - for storage as binary
     */
    public static function createSecretRaw(int $bytes = 64): string {
        if ($bytes < 32) {
            throw new InvalidArgumentException('JWT secret must be >= 32 bytes');
        }
        return random_bytes($bytes);
    }

    /**
     * Create encryption key with exact length from CipherType
     */
    public static function createEncryptionKey(CipherType $type): string {
        if (!extension_loaded('openssl')) {
            throw new RuntimeException('OpenSSL extension not available');
        }
        if (!$type->isAvailable()) {
            throw new InvalidArgumentException('Cipher not available: ' . $type->value);
        }
        return random_bytes($type->getKeyLength());
    }

    /**
     * Create encryption key as base64 for .env storage
     */
    public static function createEncryptionKeyBase64(CipherType $type): string {
        return base64_encode(self::createEncryptionKey($type));
    }

    /**
     * Create encryption key as hex for debugging
     */
    public static function createEncryptionKeyHex(CipherType $type): string {
        return bin2hex(self::createEncryptionKey($type));
    }

    /**
     * Validate secret strength
     */
    public static function isValidJwtSecret(string $secret, int $minBytes = 32): bool {
        return strlen($secret) >= $minBytes;
    }
}