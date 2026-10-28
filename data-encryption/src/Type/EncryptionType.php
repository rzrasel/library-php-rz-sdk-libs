<?php
namespace RzSDK\Encryption;

enum EncryptionType: string {
    case JWT_TOKEN          = "jwt_token";
    case OPENSSL_ENCRYPTION = "openssl_encryption";

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
}
