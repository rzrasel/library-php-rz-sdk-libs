<?php
namespace RzSDK\Encryption\Tests;

use PHPUnit\Framework\TestCase;
use RzSDK\Encryption\EncryptionType;
use RzSDK\Encryption\EncryptionTypeExtension;

class EncryptionTypeTest extends TestCase
{
    public function testEnumValues(): void
    {
        $this->assertEquals('jwt_token', EncryptionType::JWT_TOKEN->value);
        $this->assertEquals('openssl_encryption', EncryptionType::OPENSSL_ENCRYPTION->value);
    }

    public function testExtensionByName(): void
    {
        $type = EncryptionTypeExtension::getEncryptionTypeByName('JWT_TOKEN');
        $this->assertEquals(EncryptionType::JWT_TOKEN, $type);
        $this->assertNull(EncryptionTypeExtension::getEncryptionTypeByName('INVALID'));
    }

    public function testExtensionByValue(): void
    {
        $type = EncryptionTypeExtension::getEncryptionTypeByValue('jwt_token');
        $this->assertEquals(EncryptionType::JWT_TOKEN, $type);
    }

    public function testLists(): void
    {
        $this->assertIsArray(EncryptionTypeExtension::getEncryptionTypeList());
        $this->assertIsArray(EncryptionTypeExtension::getEncryptionTypeNameList());
        $this->assertIsArray(EncryptionTypeExtension::getEncryptionTypeValueList());
        $this->assertContains('JWT_TOKEN', EncryptionTypeExtension::getEncryptionTypeNameList());
        $this->assertContains('jwt_token', EncryptionTypeExtension::getEncryptionTypeValueList());
    }
}
