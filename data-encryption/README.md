# RzSDK Data Encryption

PHP utility package for JWT creation/validation, OpenSSL symmetric encryption, password hashing, and enum helpers.

> **Preservation note:** The original `src/` implementations supplied for this package have been preserved. This README and the PHPUnit test suite are additions, not a security rewrite.

## Requirements

- PHP 8.2+
- `ext-openssl`
- `ext-json`
- Composer
- PHPUnit 11 to run tests

## Package structure

```text
data-encryption/
├── composer.json
├── LICENSE
├── README.md
├── phpunit.xml
├── examples/
│   ├── jwt-example.php
│   ├── openssl-example.php
│   └── password-example.php
├── src/
│   ├── JwtManager/JwtManager.php
│   ├── OpensslEncryption/McryptCipherIvGenerator.php
│   ├── OpensslEncryption/OpensslEncryption.php
│   ├── PasswordEncryption/PasswordEncryption.php
│   └── Types/
│       ├── CipherType.php
│       ├── EncryptionType.php
│       └── EncryptionTypeExtension.php
└── tests/EncryptionLibraryTest.php
```

## Install and run

### Install the package inside the workspace

From the workspace root (`rzsdklibs/`):

```bash
composer install
```

For package-level test dependencies, from `data-encryption/` run:

```bash
composer install
composer test
```

Composer creates `vendor/autoload.php`; do not write that file manually.

### Use in another Composer project

Once this package is published to a VCS repository or Packagist, configure the repository and require the package in the consuming project's `composer.json`. The exact repository URL must be your real published URL. Then run `composer update` (or `composer require` after the repository is configured).

In PHP:

```php
require __DIR__ . '/vendor/autoload.php';

use RzSDK\Encryption\JwtManager;
use RzSDK\Encryption\OpensslEncryption;
use RzSDK\Encryption\McryptCipherIvGenerator;
use RzSDK\Encryption\PasswordEncryption;
use RzSDK\Encryption\CipherType;
use RzSDK\Encryption\EncryptionType;
use RzSDK\Encryption\EncryptionTypeExtension;
```

## Detailed usage

### 1. JWT token

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use RzSDK\Encryption\JwtManager;

$secretKey = getenv('APP_JWT_SECRET'); // Set this in your environment.
if (!$secretKey) {
    throw new RuntimeException('APP_JWT_SECRET is not configured.');
}

$jwt = new JwtManager($secretKey);

$payload = [
    'user_id' => 123,
    'username' => 'rzrasel',
    'iat' => time(),
    'exp' => time() + 3600,
];

$token = $jwt->createToken($payload);
echo $token . PHP_EOL;

if ($jwt->validateToken($token)) {
    $claims = $jwt->decodeToken($token);
    print_r($claims);
}
```

Methods:
- `new JwtManager($secretKey)`: creates a manager using the supplied signing secret.
- `createToken($payload)`: returns a compact three-part token.
- `validateToken($token)`: validates the signature using the configured secret.
- `decodeToken($token)`: decodes the payload into an associative array when decoding succeeds.

**Important:** in the supplied implementation, `validateToken()` checks the signature only. It does not reject expired `exp` claims, validate issuer/audience, or robustly handle malformed tokens. `decodeToken()` does not itself validate a token. Call validation before trusting claims, and do not use this implementation as a production authentication boundary without a security review and fixes. The source is intentionally unchanged in this package output.

### 2. OpenSSL symmetric encryption

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use RzSDK\Encryption\CipherType;
use RzSDK\Encryption\McryptCipherIvGenerator;
use RzSDK\Encryption\OpensslEncryption;

$cipher = CipherType::AES_256_CBC->value;
$key = random_bytes(32); // Keep secret and store securely.
$iv = McryptCipherIvGenerator::opensslRandomIv($cipher);

$plaintext = 'Sensitive application data';
$encrypted = OpensslEncryption::encryptData($plaintext, $key, $iv, $cipher);
$decrypted = OpensslEncryption::decryptData($encrypted, $key, $iv, $cipher);

if ($decrypted === false) {
    throw new RuntimeException('Decryption failed.');
}

echo "Encrypted: {$encrypted}" . PHP_EOL;
echo "Decrypted: {$decrypted}" . PHP_EOL;
```

Methods:
- `opensslRandomIv($cipherMethod)`: generates an IV sized for the selected OpenSSL cipher.
- `opensslDigestIv($secretKey, $isBinary)`: returns a SHA-256 digest in binary or hexadecimal form.
- `hashIv($secretKey, $length)`: returns a hexadecimal SHA-256 hash, optionally truncated.
- `encryptData($data, $key, $iv, $cipherMethod)`: encrypts and Base64-encodes the ciphertext.
- `decryptData($data, $key, $iv, $cipherMethod)`: Base64-decodes and decrypts the ciphertext.

Keep the key and IV available to decrypt later. Do not reuse the same CBC IV for multiple encryptions with the same key. The current methods do not authenticate ciphertext, so tampering may not be detected. For new production designs, prefer an authenticated encryption mode such as AES-GCM and verify its authentication tag.

### 3. Password hashing and verification

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use RzSDK\Encryption\PasswordEncryption;

$passwords = new PasswordEncryption(); // Default bcrypt cost setting: 12.
$plainPassword = 'a-user-supplied-password';

$hash = $passwords->getPassword($plainPassword);
// Store $hash in the database, never the plaintext password.

if ($passwords->isPasswordVerified($plainPassword, $hash)) {
    echo 'Password is correct.' . PHP_EOL;
} else {
    echo 'Invalid password.' . PHP_EOL;
}
```

Methods:
- `getPassword($password, $algoType)`: creates a one-way password hash.
- `isPasswordVerified($password, $hash)`: verifies a submitted password against a stored hash.
- `getRehashedPassword($password, $hash, $algoType)`: returns a replacement hash if the password is correct and PHP says the existing hash needs rehashing; otherwise returns `null`.

Example rehash flow:

```php
$replacementHash = $passwords->getRehashedPassword($submittedPassword, $storedHash);
if ($replacementHash !== null) {
    // Persist $replacementHash to the user's record.
}
```

The `cost` option is relevant to bcrypt; PHP may ignore it for algorithms that do not use it. Choose costs based on performance testing in your deployment environment.

### 4. Cipher enum

```php
use RzSDK\Encryption\CipherType;

$cipher = CipherType::AES_256_CBC->value; // "AES-256-CBC"
$otherCipher = CipherType::AES_128_CTR->value; // "AES-128-CTR"
```

### 5. Encryption type enum and helper methods

```php
use RzSDK\Encryption\EncryptionType;
use RzSDK\Encryption\EncryptionTypeExtension;

$type = EncryptionType::JWT_TOKEN;
echo $type->name;  // JWT_TOKEN
echo $type->value; // jwt_token

$byName = EncryptionTypeExtension::getEncryptionTypeByName('JWT_TOKEN');
$byValue = EncryptionTypeExtension::getEncryptionTypeByValue('jwt_token');
$allCases = EncryptionTypeExtension::getEncryptionTypeList();
$names = EncryptionTypeExtension::getEncryptionTypeNameList();
$values = EncryptionTypeExtension::getEncryptionTypeValueList();
```

Unknown names/values return `null` in the supplied implementation.

## Examples

After installing dependencies, run examples from this directory:

```bash
php examples/jwt-example.php
php examples/openssl-example.php
php examples/password-example.php
```

The JWT example uses a placeholder secret for demonstration only. Replace it with a securely managed secret before use.

## Tests

The added PHPUnit suite checks:
- JWT creation, signature validation, decoding, and rejection under a different secret.
- AES-256-CBC encryption/decryption round-trip and IV length.
- SHA-256 IV helper output lengths.
- Password hash verification and wrong-password rejection.
- Enum lookup and list helper behavior.

Run:

```bash
composer test
```

These tests document current behavior; they do not establish that the implementation is safe for production. In particular, the existing JWT parser and OpenSSL CBC design have limitations documented above.
