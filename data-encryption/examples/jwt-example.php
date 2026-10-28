<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use RzSDK\Encryption\JwtManager;
use RzSDK\Encryption\JwtAlgorithmType;
use RzSDK\Encryption\TokenPayload;
use RzSDK\Encryption\TokenType;
use RzSDK\Encryption\CipherType;
use RzSDK\Encryption\McryptCipherIvGenerator;
use RzSDK\Encryption\SecretGenerator;

echo "=== RzSDK Encryption - Full Example ===\n\n";

// 1. SecretGenerator - live methods: createSecret(), createSecretRaw()
echo "[1] SecretGenerator (live)\n";
$jwtSecret = SecretGenerator::createSecret(64); // base64url, 64 bytes raw
$jwtRaw = SecretGenerator::createSecretRaw(32);
$encKeyGcm = SecretGenerator::createEncryptionKey(CipherType::AES_256_GCM);
$encKeyB64 = SecretGenerator::createEncryptionKeyBase64(CipherType::AES_256_CBC);
$encKeyHex = SecretGenerator::createEncryptionKeyHex(CipherType::AES_128_CBC);

echo "JWT Secret (createSecret 64): $jwtSecret\n";
echo "JWT Raw length: " . strlen($jwtRaw) . "\n";
echo "Enc GCM hex: " . bin2hex($encKeyGcm) . "\n";
echo "Enc CBC Base64: $encKeyB64\n";
echo "Valid? " . (SecretGenerator::isValidJwtSecret($jwtSecret) ? 'YES' : 'NO') . "\n\n";

// 2. CipherType + McryptCipherIvGenerator (only CipherType)
echo "[2] CipherType + McryptCipherIvGenerator\n";
$gcm = CipherType::AES_256_GCM;
$cbc = CipherType::AES_256_CBC;

$ivGcm = McryptCipherIvGenerator::opensslRandomIv($gcm);
$ivCbc = McryptCipherIvGenerator::opensslRandomIv($cbc);
$nonce = McryptCipherIvGenerator::opensslRandomNonce($gcm);
$digestIv = McryptCipherIvGenerator::opensslDigestIv($jwtSecret, $gcm);
$hashIv = McryptCipherIvGenerator::hashIv($jwtSecret, $gcm);

echo "GCM IV: " . bin2hex($ivGcm) . " ({$gcm->getIvLength()} bytes)\n";
echo "CBC IV: " . bin2hex($ivCbc) . " ({$cbc->getIvLength()} bytes)\n";
echo "Nonce: " . bin2hex($nonce) . "\n";
echo "Digest IV: " . bin2hex($digestIv) . "\n";
echo "Hash IV: " . bin2hex($hashIv) . "\n\n";

// 3. TokenType + TokenPayload (live fixed: TokenType $token_type = TokenType::ACCESS_TOKEN)
echo "[3] TokenType + TokenPayload\n";
$accessPayload = new TokenPayload(
    token_payload: ['user_id' => 123, 'email' => 'user@example.com'],
    token_type: TokenType::ACCESS_TOKEN,
    scope: 'user:read',
    expiry_time: time() + 3600
);
echo "Expired? " . ($accessPayload->isExpired() ? 'YES' : 'NO') . "\n";
echo "Array: " . json_encode($accessPayload->toArray()) . "\n\n";

// 4. JwtAlgorithmType + JwtManager
echo "[4] JwtManager + JwtAlgorithmType\n";
foreach (JwtAlgorithmType::cases() as $alg) {
    echo $alg->name . " => hash: " . $alg->getHashAlgorithm() . " jwt: " . $alg->getJwtName() . "\n";
}
echo "\n";

$manager = new JwtManager(
    secretKey: $jwtSecret,
    defaultAlg: JwtAlgorithmType::HS256,
    defaultTtl: 3600,
    leeway: 60
);

$token = $manager->createToken($accessPayload, alg: JwtAlgorithmType::HS256);
echo "JWT (HS256):\n$token\n\n";

// 5. Validate & Decode
echo "[5] Validate & Decode\n";
echo "Valid? " . ($manager->validateToken($token) ? 'YES' : 'NO') . "\n";
print_r($manager->decodeToken($token, true));
echo "\n";

// 6. Combined: Encrypt with CipherType then JWT
echo "[6] Combined Encryption + JWT\n";
$key = SecretGenerator::createEncryptionKey($gcm);
$iv = McryptCipherIvGenerator::opensslRandomIv($gcm);
$tag = '';
$ct = openssl_encrypt(json_encode(['sensitive'=>'data']), $gcm->value, $key, OPENSSL_RAW_DATA, $iv, $tag, '', $gcm->getTagLength());

$encPayload = new TokenPayload(
    token_payload: ['data'=>base64_encode($ct), 'iv'=>base64_encode($iv), 'tag'=>base64_encode($tag), 'cipher'=>$gcm->value],
    token_type: TokenType::ACCESS_TOKEN,
    expiry_time: time() + 600
);
$encToken = $manager->createToken($encPayload, alg: JwtAlgorithmType::HS256);
echo "Encrypted JWT:\n$encToken\n";
echo "\n=== Done ===\n";