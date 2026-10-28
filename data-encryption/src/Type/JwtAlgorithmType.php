<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

enum JwtAlgorithmType: string {
    case HS256 = 'HS256';
    case HS384 = 'HS384';
    case HS512 = 'HS512';

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
        return self::getByValue($value) ?? throw new \ValueError("Invalid TokenType: $value");
    }

    public static function tryFromValue(string $value): ?self {
        return self::getByValue($value);
    }

    public function getHashAlgorithm(): string {
        return match($this) {
            self::HS256 => 'sha256',
            self::HS384 => 'sha384',
            self::HS512 => 'sha512',
        };
    }

    public function getJwtName(): string {
        // HS256, HS384, HS512 for JWT header
        return $this->value;
    }
}