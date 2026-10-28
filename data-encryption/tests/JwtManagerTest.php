<?php
namespace RzSDK\Encryption\Tests;

use PHPUnit\Framework\TestCase;
use RzSDK\Encryption\JwtManager;

class JwtManagerTest extends TestCase
{
    private JwtManager $manager;
    private string $secret = 'test-secret-key-12345';

    protected function setUp(): void
    {
        $this->manager = new JwtManager($this->secret);
    }

    public function testCreateAndValidate(): void
    {
        $payload = ['user_id' => 123, 'username' => 'rzrasel', 'exp' => time() + 3600];
        $token = $this->manager->createToken($payload);
        $this->assertIsString($token);
        $this->assertCount(3, explode('.', $token));
        $this->assertTrue($this->manager->validateToken($token));
    }

    public function testDecode(): void
    {
        $payload = ['user_id' => 99, 'role' => 'admin'];
        $token = $this->manager->createToken($payload);
        $decoded = $this->manager->decodeToken($token);
        $this->assertEquals(99, $decoded['user_id']);
        $this->assertEquals('admin', $decoded['role']);
    }

    public function testInvalidSignatureFails(): void
    {
        $payload = ['user_id' => 1];
        $token = $this->manager->createToken($payload);
        $tampered = $token . 'tampered';
        // explode will still give 3 parts but signature check fails OR throws - we expect false
        $this->assertFalse($this->manager->validateToken($tampered));
    }

    public function testDifferentSecretFails(): void
    {
        $payload = ['user_id' => 1];
        $token = $this->manager->createToken($payload);
        $otherManager = new JwtManager('different-secret');
        $this->assertFalse($otherManager->validateToken($token));
    }
}
