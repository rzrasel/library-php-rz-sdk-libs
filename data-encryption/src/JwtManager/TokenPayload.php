<?php
declare(strict_types=1);
namespace RzSDK\Encryption;

use InvalidArgumentException;

class TokenPayload {

    public function __construct(
        public ?array $token_payload = null,
        public TokenType $token_type = TokenType::ACCESS_TOKEN,
        public ?string $scope = null,
        public int $generate_time = 0,
        public ?int $expiry_time = null
    ) {
        $this->generate_time = $generate_time > 0 ? $generate_time : time();
        if ($this->expiry_time !== null && $this->expiry_time <= $this->generate_time) {
            throw new InvalidArgumentException('expiry_time must be > generate_time');
        }
    }

    public function isExpired(int $leeway = 60): bool {
        return $this->expiry_time !== null && ($this->expiry_time + $leeway) < time();
    }

    public function toArray(): array {
        return [
            'token_payload' => $this->token_payload,
            'token_type' => $this->token_type->value,
            'scope' => $this->scope,
            'generate_time' => $this->generate_time,
            'expiry_time' => $this->expiry_time,
        ];
    }
}