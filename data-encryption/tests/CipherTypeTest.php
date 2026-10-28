<?php
namespace RzSDK\Encryption\Tests;

use PHPUnit\Framework\TestCase;
use RzSDK\Encryption\CipherType;

class CipherTypeTest extends TestCase
{
    public function testCipherValues(): void
    {
        $this->assertEquals('AES-128-CTR', CipherType::AES_128_CTR->value);
        $this->assertEquals('AES-256-CBC', CipherType::AES_256_CBC->value);
    }

    public function testCasesExist(): void
    {
        $cases = CipherType::cases();
        $this->assertCount(2, $cases);
        $this->assertContainsOnlyInstancesOf(CipherType::class, $cases);
    }
}
