<?php
namespace RzSDK\Encryption;

class EncryptionTypeExtension {

    public static function getEncryptionTypeByName($name) {
        foreach (EncryptionType::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null;
    }

    public static function getEncryptionTypeByValue($value) {
        foreach (EncryptionType::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }

    public static function getEncryptionTypeList() {
        return EncryptionType::cases();
    }

    public static function getEncryptionTypeNameList() {
        $retVal = array();
        foreach (EncryptionType::cases() as $case) {
            $retVal[] = $case->name;
        }
        return $retVal;
    }

    public static function getEncryptionTypeValueList() {
        $retVal = array();
        foreach (EncryptionType::cases() as $case) {
            $retVal[] = $case->value;
        }
        return $retVal;
    }
}
