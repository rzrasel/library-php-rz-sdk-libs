<?php
namespace RzSDK\Encryption\Tests;

use PHPUnit\Framework\TestCase;
use RzSDK\Encryption\PasswordEncryption;

class PasswordEncryptionTest extends TestCase
{
    private PasswordEncryption $enc;

    protected function setUp(): void
    {
        $this->enc = new PasswordEncryption(10); // lower cost for test speed
    }

    public function testHashAndVerify(): void
    {
        $password = 'super-secret-123';
        $hash = $this->enc->getPassword($password);
        $this->assertTrue($this->enc->isPasswordVerified($password, $hash));
        $this->assertFalse($this->enc->isPasswordVerified('wrong', $hash));
    }

    public function testRehash(): void
    {
        // create with cost 10, then check if needs rehash with cost 12
        $password = 'test-pwd';
        $hash = $this->enc->getPassword($password);

        $higherCostEnc = new PasswordEncryption(12);
        $rehash = $higherCostEnc->getRehashedPassword($password, $hash);
        $this->assertNotNull($rehash);
        $this->assertTrue($higherCostEnc->isPasswordVerified($password, $rehash));

        // wrong password should return null
        $this->assertNull($higherCostEnc->getRehashedPassword('wrong', $hash));
    }
}
