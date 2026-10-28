- scan, rescan and check the code of: https://github.com/rzrasel/library-php-rz-sdk-libs

/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\JwtManager\JwtManager.php **/

<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

use InvalidArgumentException;
use RuntimeException;

class JwtManager {

    private const ALG_MAP = [
        'HS256' => 'sha256',
        'HS384' => 'sha384',
        'HS512' => 'sha512',
    ];
    private $secretKey;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    public function createToken($payload) {
        $header = [
            "alg" => "HS512",
            "typ" => "JWT"
        ];
        $base64UrlHeader = $this->base64UrlEncode(json_encode(["alg" => "HS256", "typ" => "JWT"]));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));
        $base64UrlSignature = hash_hmac("sha256", $base64UrlHeader . "." . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($base64UrlSignature);
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function validateToken($token) {
        // Implementation for validating JWT
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode(".", $token);

        $signature = $this->base64UrlDecode($base64UrlSignature);
        $expectedSignature = hash_hmac("sha256", $base64UrlHeader . "." . $base64UrlPayload, $this->secretKey, true);

        return hash_equals($signature, $expectedSignature);
    }

    public function decodeToken($token) {
        // Implementation for decoding JWT
        list(, $base64UrlPayload, ) = explode(".", $token);
        $payload = $this->base64UrlDecode($base64UrlPayload);
        return json_decode($payload, true);
    }

    // Helper functions for base64 URL encoding/decoding
    private function base64UrlEncode($data) {
        $base64 = base64_encode($data);
        $base64Url = strtr($base64, "+/", "-_");
        return rtrim($base64Url, "=");
    }

    private function base64UrlDecode($data) {
        $base64 = strtr($data, "-_", "+/");
        $base64Padded = str_pad($base64, strlen($base64) % 4, "=", STR_PAD_RIGHT);
        return base64_decode($base64Padded);
    }
}


/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\JwtManager\TokenPayload.php **/

<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

class TokenPayload {
    public ?array $token_payload;
    public TokenType $token_type;
    public ?string $scope;
    public int $generate_time;
    public ?int $expiry_time;

    public function __construct(
        ?array $token_payload = null,
        string $token_type = TokenType->ACCESS_TOKEN,
        ?string $scope = null,
        ?int $generate_time = null,
        ?int $expiry_time = null
    ) {
        $this->token_payload = $token_payload;
        $this->token_type = $token_type;
        $this->scope = $scope;
        $this->generate_time = $generate_time ?? time();
        $this->expiry_time = $expiry_time;
    }
}

/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\Type\CipherType.php **/

<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

enum CipherType: string {
    case AES_128_CTR = 'AES-128-CTR';
    case AES_128_CBC = 'AES-128-CBC';
    case AES_256_CBC = 'AES-256-CBC';
    case AES_256_GCM = 'AES-256-GCM';
    case AES_256_CTR = 'AES-256-CTR';
    case CHACHA20_POLY1305 = 'chacha20-poly1305';

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

    public static function fromValue(string $value): self {
        return self::getByValue($value) ?? throw new \ValueError("Invalid CipherType: $value");
    }

    public static function tryFromValue(string $value): ?self {
        return self::getByValue($value);
    }

    public function getKeyLength(): int {
        //CipherType::AES_256_GCM->getKeyLength();
        return match ($this) {
            self::AES_128_CTR,
            self::AES_128_CBC => 16,
            self::AES_256_CBC,
            self::AES_256_GCM,
            self::AES_256_CTR,
            self::CHACHA20_POLY1305 => 32,
        };
    }

    public function getIvLength(): int {
        $len = openssl_cipher_iv_length($this->value);
        if ($len !== false) return $len;

        return match ($this) {
            self::AES_128_CTR,
            self::AES_128_CBC,
            self::AES_256_CBC,
            self::AES_256_CTR => 16,
            self::AES_256_GCM,
            self::CHACHA20_POLY1305 => 12,
        };
    }

    public function isAuthenticated(): bool {
        return match ($this) {
            self::AES_256_GCM, self::CHACHA20_POLY1305 => true,
            default => false,
        };
    }

    public function getTagLength(): int {
        return $this->isAuthenticated() ? 16 : 0;
    }

    public function isAvailable(): bool {
        if (!extension_loaded('openssl')) return false;
        return in_array(strtolower($this->value), self::getAvailableMethods(), true);
    }

    public static function availableCases(): array {
        return array_values(array_filter(self::cases(), fn(self $c) => $c->isAvailable()));
    }

    /**
     * Cache via static local variable, not enum property
     */
    private static function getAvailableMethods(): array {
        static $cache = null;
        if ($cache === null) {
            $cache = array_map('strtolower', openssl_get_cipher_methods());
        }
        return $cache;
    }
}


/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\Type\EncryptionType.php **/

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


/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\Type\EncryptionTypeExtension.php **/

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


/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\Type\JwtAlgorithmType.php **/

<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

enum JwtAlgorithmType: string {
    case HS256 = 'HS256';
    case HS384 = 'HS384';
    case HS512 = 'HS512';

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

    public static function fromValue(string $value): self {
        return self::getByValue($value) ?? throw new \ValueError("Invalid TokenType: $value");
    }

    public static function tryFromValue(string $value): ?self {
        return self::getByValue($value);
    }

    public function getHashAlgorithm(): string {
        return match($this) {
            self::HS256 => 'sha256',
            self::HS384 => 'sha384',
            self::HS512 => 'sha512',
        };
    }

    public function getJwtName(): string {
        // HS256, HS384, HS512 for JWT header
        return $this->value;
    }
}

/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\Type\TokenType.php **/

<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

enum TokenType: string {
    case ACCESS_TOKEN = 'access_token';
    case REFRESH_TOKEN = 'refresh_token';
    case ID_TOKEN = 'id_token';
    case RESET_TOKEN = 'reset_token';
    case VERIFICATION_TOKEN = 'verification_token';

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

    public static function fromValue(string $value): self {
        return self::getByValue($value) ?? throw new \ValueError("Invalid TokenType: $value");
    }

    public static function tryFromValue(string $value): ?self {
        return self::getByValue($value);
    }
}

/ File: C:\xampp-portable-windows-x64-8.2.12-0-VS16\htdocs\php-rzsdk-codeigniter\php-library-maker-not-for-use\rzsdklibs\data-encryption\src\Utils\McryptCipherIvGenerator.php **/

<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

use InvalidArgumentException;
use RuntimeException;

class McryptCipherIvGenerator {

    public static function opensslRandomIv(
        CipherType $cipherMethod = CipherType::AES_256_CBC
    ): string {
        if (!extension_loaded('openssl')) {
            throw new RuntimeException('OpenSSL PHP extension is not available.');
        }
        if (!$cipherMethod->isAvailable()) {
            throw new InvalidArgumentException(
                'Cipher is not supported by OpenSSL: ' . $cipherMethod->value
            );
        }
        $ivLength = openssl_cipher_iv_length($cipherMethod->value);
        if ($ivLength === false || $ivLength <= 0) {
            $ivLength = $cipherMethod->getIvLength();
        }
        return random_bytes($ivLength);
    }

    public static function opensslRandomNonce(
        CipherType $cipherType
    ): string {
        if (!$cipherType->isAuthenticated()) {
            throw new InvalidArgumentException(
                'Nonce generation requires an authenticated cipher: ' . $cipherType->value
            );
        }
        return self::opensslRandomIv($cipherType);
    }

    public static function opensslDigestIv(
        string $secretKey,
        CipherType $cipherType = CipherType::AES_256_CBC,
        bool $isBinary = true
    ): string {
        // Derive binary digest, then truncate to exact IV length for the cipher
        $digest = openssl_digest($secretKey, 'SHA256', true);
        if ($digest === false) {
            throw new RuntimeException('OpenSSL digest failed');
        }
        $digest = substr($digest, 0, $cipherType->getIvLength());
        return $isBinary ? $digest : bin2hex($digest);
    }

    public static function hashIv(
        string $secretKey,
        CipherType $cipherType = CipherType::AES_256_CBC,
        int $length = -1
    ): string {
        // Binary hash, not hex - then truncate to cipher's IV length
        $hash = hash('sha256', $secretKey, true);
        $ivLength = $length > 0 ? $length : $cipherType->getIvLength();
        return substr($hash, 0, $ivLength);
    }
}

- JwtManager, JwtAlgorithmType, TokenPayload, TokenType, SecretGenerator
- any modification or update fixing, adjusting, scaling? it's library, and want to use through McryptCipherIvGenerator, CipherType
- don't use deprecated code
- don't change class name
- keep codebase consistency