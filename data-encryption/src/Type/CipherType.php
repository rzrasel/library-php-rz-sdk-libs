<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

enum CipherType: string {
    case AES_128_CTR = 'AES-128-CTR';
    case AES_128_CBC = 'AES-128-CBC';
    case AES_256_CBC = 'AES-256-CBC';
    case AES_256_GCM = 'AES-256-GCM';
    case AES_256_CTR = 'AES-256-CTR';
    case CHACHA20_POLY1305 = 'chacha20-poly1305';

    public static function getByValue($value): ?self {
        foreach(self::cases() as $props) {
            /* if ($case->name === $enumName) {
                return $case;
            } */
            if(strtolower($props->value) === strtolower($value)) {
                return $props;
            }
        }
        return null;
    }

    public static function fromValue(string $value): self {
        return self::getByValue($value) ?? throw new \ValueError("Invalid CipherType: $value");
    }

    public static function tryFromValue(string $value): ?self {
        return self::getByValue($value);
    }

    public function getKeyLength(): int {
        //CipherType::AES_256_GCM->getKeyLength();
        return match ($this) {
            self::AES_128_CTR,
            self::AES_128_CBC => 16,
            self::AES_256_CBC,
            self::AES_256_GCM,
            self::AES_256_CTR,
            self::CHACHA20_POLY1305 => 32,
        };
    }

    public function getIvLength(): int {
        $len = openssl_cipher_iv_length($this->value);
        if ($len !== false) return $len;

        return match ($this) {
            self::AES_128_CTR,
            self::AES_128_CBC,
            self::AES_256_CBC,
            self::AES_256_CTR => 16,
            self::AES_256_GCM,
            self::CHACHA20_POLY1305 => 12,
        };
    }

    public function isAuthenticated(): bool {
        return match ($this) {
            self::AES_256_GCM, self::CHACHA20_POLY1305 => true,
            default => false,
        };
    }

    public function getTagLength(): int {
        return $this->isAuthenticated() ? 16 : 0;
    }

    public function isAvailable(): bool {
        if (!extension_loaded('openssl')) return false;
        return in_array(strtolower($this->value), self::getAvailableMethods(), true);
    }

    public static function availableCases(): array {
        return array_values(array_filter(self::cases(), fn(self $c) => $c->isAvailable()));
    }

    /**
     * Cache via static local variable, not enum property
     */
    private static function getAvailableMethods(): array {
        static $cache = null;
        if ($cache === null) {
            $cache = array_map('strtolower', openssl_get_cipher_methods());
        }
        return $cache;
    }
}
