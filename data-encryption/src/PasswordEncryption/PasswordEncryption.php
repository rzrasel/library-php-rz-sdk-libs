<?php
namespace RzSDK\Encryption;

class PasswordEncryption {
    private int $defaultCost;

    public function __construct(int $defaultCost = 12) {
        $this->defaultCost = $defaultCost;
    }

    public function getPassword(string $password, int|string $algoType = PASSWORD_DEFAULT): string {
        return password_hash($password, $algoType, ['cost' => $this->defaultCost]);
    }

    public function getRehashedPassword(string $password, string $hash, int|string $algoType = PASSWORD_DEFAULT): ?string {
        if ($this->isPasswordVerified($password, $hash)) {
            if (password_needs_rehash($hash, $algoType, ['cost' => $this->defaultCost])) {
                return password_hash($password, $algoType, ['cost' => $this->defaultCost]);
            }
        }
        return null;
    }

    public function isPasswordVerified(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}
