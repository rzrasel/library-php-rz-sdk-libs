<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

enum TokenType: string {
    case ACCESS_TOKEN = 'access_token';
    case REFRESH_TOKEN = 'refresh_token';
    case ID_TOKEN = 'id_token';
    case RESET_TOKEN = 'reset_token';
    case VERIFICATION_TOKEN = 'verification_token';

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
}