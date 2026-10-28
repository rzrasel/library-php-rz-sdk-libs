<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

use InvalidArgumentException;
use RuntimeException;

class JwtManager {

    /*private const ALG_MAP = [
        'HS256' => 'sha256',
        'HS384' => 'sha384',
        'HS512' => 'sha512',
    ];*/
    //private $secretKey;

    public function __construct(
        private readonly string $secretKey,
        private readonly JwtAlgorithmType $defaultAlg = JwtAlgorithmType::HS256,
        private readonly int $defaultTtl = 3600,
        private readonly int $leeway = 60
    ) {
        if (strlen($secretKey) < 32) {
            throw new InvalidArgumentException('Secret key must be >= 32 chars');
        }
    }

    public function createToken(
        array|TokenPayload $payload,
        ?int $ttl = null,
        ?JwtAlgorithmType $alg = null
    ): string {
        $alg = $alg ?? $this->defaultAlg;
        if ($payload instanceof TokenPayload) {
            $payloadArr = $payload->toArray();
            // merge inner token_payload into top-level for JWT
            $jwtPayload = array_merge($payloadArr['token_payload'] ?? [], [
                'token_type' => $payloadArr['token_type'],
                'scope' => $payloadArr['scope'],
            ]);
            $ttl = $ttl ?? ($payload->expiry_time ? $payload->expiry_time - $payload->generate_time : null);
        } else {
            $jwtPayload = $payload;
        }
        $now = time();
        $jwtPayload = array_merge([
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + ($ttl ?? $this->defaultTtl),
            'jti' => bin2hex(random_bytes(8)),
        ], $jwtPayload);
        $header = ['alg' => $alg->getJwtName(), 'typ' => 'JWT'];
        $b64Header = $this->base64UrlEncode(json_encode($header));
        $b64Payload = $this->base64UrlEncode(json_encode($jwtPayload));
        $sig = hash_hmac($alg->getHashAlgorithm(), "$b64Header.$b64Payload", $this->secretKey, true);
        return "$b64Header.$b64Payload." . $this->base64UrlEncode($sig);
    }

    public function validateToken(string $token): bool {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;
        [$h,$p,$s] = $parts;
        $header = json_decode($this->base64UrlDecode($h), true);
        $alg = JwtAlgorithmType::getByValue($header['alg'] ?? null);
        if ($alg === null) return false;
        $expected = hash_hmac($alg->getHashAlgorithm(), "$h.$p", $this->secretKey, true);
        if (!hash_equals($expected, $this->base64UrlDecode($s))) return false;
        $payload = json_decode($this->base64UrlDecode($p), true);
        if (!is_array($payload)) return false;
        $now = time();
        if (isset($payload['exp']) && $payload['exp'] + $this->leeway < $now) return false;
        if (isset($payload['nbf']) && $payload['nbf'] - $this->leeway > $now) return false;
        return true;
    }

    public function decodeToken(string $token, bool $verify = true): array {
        if ($verify && !$this->validateToken($token)) throw new RuntimeException('Invalid token');
        return json_decode($this->base64UrlDecode(explode('.', $token)[1]), true);
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
