<?php
namespace RzSDK\Encryption\Tests;

use PHPUnit\Framework\TestCase;
use RzSDK\Encryption\OpensslEncryption;
use RzSDK\Encryption\McryptCipherIvGenerator;

class OpensslEncryptionTest extends TestCase
{
    public function testEncryptDecrypt(): void
    {
        $data = 'Hello RzSDK!';
        $key = random_bytes(32);
        $iv = McryptCipherIvGenerator::opensslRandomIv('AES-256-CBC');

        $enc = OpensslEncryption::encryptData($data, $key, $iv, 'AES-256-CBC');
        $dec = OpensslEncryption::decryptData($enc, $key, $iv, 'AES-256-CBC');

        $this->assertNotEquals($data, $enc);
        $this->assertEquals($data, $dec);
    }

    public function testIvGenerator(): void
    {
        $iv = McryptCipherIvGenerator::opensslRandomIv('AES-256-CBC');
        $this->assertEquals(16, strlen($iv)); // AES-256-CBC IV length is 16

        $digest = McryptCipherIvGenerator::opensslDigestIv('my-secret', true);
        $this->assertEquals(32, strlen($digest));

        $hash = McryptCipherIvGenerator::hashIv('my-secret');
        $this->assertEquals(64, strlen($hash)); // SHA256 hex length

        $hash16 = McryptCipherIvGenerator::hashIv('my-secret', 16);
        $this->assertEquals(16, strlen($hash16));
    }

    public function testCipherLengths(): void
    {
        $iv128 = McryptCipherIvGenerator::opensslRandomIv('AES-128-CTR');
        $this->assertEquals(16, strlen($iv128));
    }
}
