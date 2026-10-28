<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RzSDK\Encryption\CipherType;
use RzSDK\Encryption\EncryptionType;
use RzSDK\Encryption\EncryptionTypeExtension;
use RzSDK\Encryption\JwtManager;
use RzSDK\Encryption\McryptCipherIvGenerator;
use RzSDK\Encryption\OpensslEncryption;
use RzSDK\Encryption\PasswordEncryption;

final class EncryptionLibraryTest extends TestCase
{
    public function testJwtCanBeCreatedValidatedAndDecoded(): void
    {
        $manager = new JwtManager('test-secret-key-that-is-long-enough');
        $payload = ['user_id' => 123, 'username' => 'tester', 'exp' => time() + 3600];

        $token = $manager->createToken($payload);

        self::assertIsString($token);
        self::assertCount(3, explode('.', $token));
        self::assertTrue($manager->validateToken($token));
        self::assertSame($payload, $manager->decodeToken($token));
    }

    public function testJwtSignatureFailsWithDifferentSecret(): void
    {
        $creator = new JwtManager('secret-one');
        $validator = new JwtManager('secret-two');
        $token = $creator->createToken(['user_id' => 1]);

        self::assertFalse($validator->validateToken($token));
    }

    public function testOpenSslEncryptsAndDecryptsText(): void
    {
        $plaintext = 'Test message: RzSDK';
        $key = random_bytes(32);
        $cipher = CipherType::AES_256_CBC->value;
        $iv = McryptCipherIvGenerator::opensslRandomIv($cipher);

        self::assertSame(16, strlen($iv));
        $encrypted = OpensslEncryption::encryptData($plaintext, $key, $iv, $cipher);

        self::assertIsString($encrypted);
        self::assertNotSame($plaintext, $encrypted);
        self::assertSame($plaintext, OpensslEncryption::decryptData($encrypted, $key, $iv, $cipher));
    }

    public function testIvHelpersReturnExpectedLengths(): void
    {
        $iv = McryptCipherIvGenerator::opensslRandomIv('AES-256-CBC');
        self::assertSame(16, strlen($iv));

        $binaryDigest = McryptCipherIvGenerator::opensslDigestIv('sample-secret', true);
        self::assertSame(32, strlen($binaryDigest));

        $hexDigest = McryptCipherIvGenerator::opensslDigestIv('sample-secret', false);
        self::assertSame(64, strlen($hexDigest));

        self::assertSame(12, strlen(McryptCipherIvGenerator::hashIv('sample-secret', 12)));
        self::assertSame(64, strlen(McryptCipherIvGenerator::hashIv('sample-secret')));
    }

    public function testPasswordHashCanBeVerifiedAndWrongPasswordRejected(): void
    {
        $passwords = new PasswordEncryption(4);
        $hash = $passwords->getPassword('correct-password');

        self::assertNotSame('correct-password', $hash);
        self::assertTrue($passwords->isPasswordVerified('correct-password', $hash));
        self::assertFalse($passwords->isPasswordVerified('wrong-password', $hash));
    }

    public function testPasswordRehashReturnsNullWhenHashDoesNotNeedRehash(): void
    {
        $passwords = new PasswordEncryption(4);
        $hash = $passwords->getPassword('correct-password');

        self::assertNull($passwords->getRehashedPassword('correct-password', $hash));
        self::assertNull($passwords->getRehashedPassword('wrong-password', $hash));
    }

    public function testEncryptionTypeHelpers(): void
    {
        self::assertSame(EncryptionType::JWT_TOKEN, EncryptionTypeExtension::getEncryptionTypeByName('JWT_TOKEN'));
        self::assertSame(EncryptionType::JWT_TOKEN, EncryptionTypeExtension::getEncryptionTypeByValue('jwt_token'));
        self::assertNull(EncryptionTypeExtension::getEncryptionTypeByName('unknown'));
        self::assertNull(EncryptionTypeExtension::getEncryptionTypeByValue('unknown'));

        self::assertSame(
            ['JWT_TOKEN', 'OPENSSL_ENCRYPTION'],
            EncryptionTypeExtension::getEncryptionTypeNameList()
        );
        self::assertSame(
            ['jwt_token', 'openssl_encryption'],
            EncryptionTypeExtension::getEncryptionTypeValueList()
        );
        self::assertCount(2, EncryptionTypeExtension::getEncryptionTypeList());
    }
}
