# 🧩 RzSDK PHP Libraries — `rzrasel/library-php-rz-sdk-libs`

**A collection of reusable, modular PHP SDK libraries.**

[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-Supported-885630?logo=composer&logoColor=white)](https://getcomposer.org/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![GitHub](https://img.shields.io/badge/GitHub-rzrasel-black?logo=github)](https://github.com/rzrasel)

**RzSDK PHP Libraries — A modular, reusable PHP SDK workspace providing secure encryption components, JWT token management, and extensible libraries for modern PHP 8.2+ applications.**

**Keywords: PHP SDK, PHP Library, Encryption, JWT, OpenSSL, Security, PSR-4, Composer Package, Reusable Components**

**RzSDK PHP Libraries Workspace is an open-source, MIT-licensed modular PHP library collection for PHP 8.2+. Built on object-oriented principles and Composer package management, it provides independent, testable modules. The initial data-encryption module offers complete JWT authentication flow, HMAC algorithm support, cipher definitions, and secure secret generation using ext-openssl and ext-json. Ideal for APIs, stateless authentication, and secure application communication. Fully documented with examples, autoloading via vendor/autoload.php, and ready for Packagist distribution.**

**GitHub Repository:** https://github.com/rzrasel/library-php-rz-sdk-libs

---

## Installation composer.json

```bash
{
    "require": {
        "rzrasel/library-php-rz-sdk-libs": "dev-master"
    }
}
```

```bash
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/rzrasel/library-php-rz-sdk-libs"
        }
    ],
    "require": {
        "rzrasel/library-php-rz-sdk-libs": "dev-master"
    }
}
```

> **A collection of reusable, modular PHP SDK libraries — built for modern PHP 8.2+ applications.**
### 📝 Short Description (for GitHub / Packagist)
> **RzSDK PHP Libraries Workspace — Modular, reusable PHP SDK providing secure encryption utilities, JWT management, cipher & secret generation for PHP 8.2+ apps.**
### 📖 Long Description (SEO / Packagist Long Description)
**RzSDK PHP Libraries Workspace** is an open-source, 【entity-MIT¦canonical_name=MIT】-licensed modular PHP library collection for PHP 8.2+. Built on OOP, PSR-4 autoloading and Composer package management, it provides independent, testable modules.
The initial `data-encryption` module offers complete JWT authentication flow (`JwtManager`, `TokenPayload`), HMAC algorithm support (`JwtAlgorithmType`: HS256/HS384/HS512), cipher definitions (`CipherType`), encryption types (`EncryptionType`, `TokenType`), IV/digest utilities (`McryptCipherIvGenerator`) and secure secret generation (`SecretGenerator`) using `ext-openssl` and `ext-json`.
Ideal for APIs, stateless authentication, microservices and secure application communication. Fully documented with examples, autoloading via `vendor/autoload.php`, and ready for Packagist distribution.
### 🔑 SEO / Packagist Keywords
```
php-sdk, php-library, php8, php82, rzsdk, rzrasel, encryption, jwt, json-web-token, openssl, hmac, hs256, hs384, hs512, cipher, secret-generator, security, authentication, api-auth, psr-4, composer-package, reusable-components, modular-php
```
### 📦 Packagist / GitHub Details
| Property | Details |
| :--- | :--- |
| **Package Name** | `rzrasel/library-php-rz-sdk-libs` |
| **Repository** | `https://github.com/rzrasel/library-php-rz-sdk-libs` |
| **Clone URL** | `https://github.com/rzrasel/library-php-rz-sdk-libs.git` |
| **Owner** | [rzrasel](https://github.com/rzrasel) |
| **Branch** | `master` |
| **Visibility** | Public |
| **License** | MIT |
| **Language** | PHP 8.2+ |
| **Packagist** | `https://packagist.org/packages/rzrasel/library-php-rz-sdk-libs` |
| **Type** | Modular PHP Library Workspace |
| **Autoloading** | PSR-4 `RzSDK\Encryption` |
---
## 📚 Table of Contents
1. [Introduction](#-1-introduction)
2. [Repository Info](#-2-repository-information)
3. [Features](#-3-features)
4. [Available Libraries](#-4-available-libraries)
5. [Requirements](#-5-requirements)
6. [Installation](#-6-installation)
7. [Composer Configuration](#-7-composer-configuration)
8. [Composer Commands Cheat-Sheet](#-8-composer-commands-cheat-sheet)
9. [Autoloading](#-9-autoloading)
10. [Usage](#-10-usage)
11. [Project Structure](#-11-project-structure)
12. [Development Setup](#-12-development-setup)
13. [Running Tests](#-13-running-tests)
14. [Git Workflow](#-14-git-workflow)
15. [Publishing & Versioning](#-15-publishing-and-versioning)
16. [Security](#-16-security-considerations)
17. [Contributing](#-17-contributing)
18. [License & Author](#-18-license--author)
---
## 📘 1. Introduction
RzSDK PHP Libraries is a modular SDK workspace to provide reusable PHP components across projects without code duplication.
Each library has its own:
- ✅ `composer.json`
- ✅ `src/` with PSR-4 Namespace
- ✅ `README.md` + `examples/`
- ✅ `tests/` (PHPUnit 11)
- ✅ Independent dependencies
  **Design Principles:**
- 🧱 Modular architecture
- 🧠 Object-oriented PHP
- 📦 Composer package management
- 🔄 PSR-4 autoloading
- 🏷️ Namespace-based organization
- ♻️ Reusable & maintainable
---
## 🗂️ 2. Repository Information
```bash
git clone https://github.com/rzrasel/library-php-rz-sdk-libs.git
cd library-php-rz-sdk-libs
```
**Links:**
- 【entity-GitHub¦canonical_name=GitHub】: https://github.com/rzrasel/library-php-rz-sdk-libs
- Packagist: https://packagist.org/packages/rzrasel/library-php-rz-sdk-libs
- Author: https://github.com/rzrasel
---
## ✨ 3. Features
### Current Capabilities
- 🔐 JWT token management (`JwtManager`)
- 📄 JWT payload handling (`TokenPayload`)
- 🔑 JWT Algorithm definitions (`JwtAlgorithmType`: HS256, HS384, HS512)
- 🧬 Cipher type definitions (`CipherType`)
- 🛡️ Encryption type definitions (`EncryptionType`, `TokenType`)
- 🔢 Secret generation (`SecretGenerator`)
- 🔀 IV & Digest utilities (`McryptCipherIvGenerator`)
### Development Features
- Composer path repository for local dev
- Independent module docs
- PHPUnit 11 testing support
- Git automation scripts
---
## 📦 4. Available Libraries
### 4.1 `data-encryption`
**Namespace:** `RzSDK\Encryption`
| Component | Description |
| :--- | :--- |
| `JwtManager` | Create, verify & decode JWT tokens |
| `TokenPayload` | JWT payload representation |
| `JwtAlgorithmType` | HMAC algorithms HS256/HS384/HS512 |
| `TokenType` | Token type definitions |
| `CipherType` | OpenSSL cipher definitions |
| `EncryptionType` | Encryption mechanism types |
| `McryptCipherIvGenerator` | IV & digest helpers |
| `SecretGenerator` | Secure random secret generation |
Module Docs: `data-encryption/README.md`
---
## ⚙️ 5. Requirements
| Requirement | Version |
| :--- | :--- |
| PHP | 8.2 or higher |
| Composer | 2.x recommended |
| ext-openssl | Required |
| ext-json | Required |
| PHPUnit | 11.x for testing |
Check:
```bash
php -v
php -m | grep -E "openssl|json"
```
---
## 💾 6. Installation
### 6.1 Via Packagist (recommended)
**Stable (when tagged):**
```bash
composer require rzrasel/library-php-rz-sdk-libs
```
**Dev branch (current master):**
```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master
```
**With source preference (to inspect source):**
```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master --prefer-source
```
**With dist preference (faster):**
```bash
composer require rzrasel/library-php-rz-sdk-libs --prefer-dist
```
### 6.2 Clone from GitHub (for development)
```bash
git clone https://github.com/rzrasel/library-php-rz-sdk-libs.git
cd library-php-rz-sdk-libs
composer install
```
### 6.3 Using in composer.json directly
**Simple require:**
```json
{
  "require": {
    "rzrasel/library-php-rz-sdk-libs": "dev-master"
  }
}
```
**With VCS repository (if Packagist not updated):**
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/rzrasel/library-php-rz-sdk-libs"
    }
  ],
  "require": {
    "rzrasel/library-php-rz-sdk-libs": "dev-master"
  }
}
```
---
## 🔧 7. Composer Configuration
### 7.1 Root Workspace Configuration
The root `composer.json` uses path repository:
```json
{
  "repositories": [
    {
      "type": "path",
      "url": "data-encryption",
      "options": { "symlink": true }
    }
  ]
}
```
### 7.2 Individual Module Configuration
Each module `data-encryption/composer.json` defines its own:
- name, description, PHP requirement
- PSR-4 autoload: `"RzSDK\\Encryption\\": "src/"`
- dev dependencies & test scripts
---
## 🚀 8. Composer Commands Cheat-Sheet
#### Install package:
```bash
composer require rzrasel/library-php-rz-sdk-libs
composer require rzrasel/library-php-rz-sdk-libs:dev-master
composer require rzrasel/library-php-rz-sdk-libs:dev-master --prefer-source
```
#### Show package info (verbose):
```bash
composer show rzrasel/library-php-rz-sdk-libs -v
composer show rzrasel/library-php-rz-sdk-libs --all
```
#### Clear cache & clean vendor:
```bash
composer clear-cache
composer clearcache
rm -rf vendor
# Windows PowerShell:
# Remove-Item -Recurse -Force vendor
```
#### Update & dump autoload:
```bash
composer update --no-cache --prefer-source
composer update --no-cache
composer update rzrasel/library-php-rz-sdk-libs --prefer-source
composer update rzrasel/library-php-rz-sdk-libs --prefer-dist
composer dump-autoload
composer dump-autoload -o
```
#### Install all dependencies:
```bash
composer install
composer install --prefer-source
```
#### Remove package:
```bash
composer remove rzrasel/library-php-rz-sdk-libs
```
---
## 🔌 9. Autoloading
Composer generates `vendor/autoload.php`:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use RzSDK\Encryption\JwtManager;
use RzSDK\Encryption\TokenPayload;
use RzSDK\Encryption\JwtAlgorithmType;
use RzSDK\Encryption\CipherType;
```
PSR-4: `RzSDK\Encryption\` => `src/`
---
## 💡 10. Usage
### 10.1 Basic Composer Usage
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use RzSDK\Encryption\JwtManager;
```
### 10.2 JWT Token Management
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use RzSDK\Encryption\JwtManager;
$secretKey = getenv('APP_JWT_SECRET');
if (!$secretKey) {
    throw new RuntimeException('JWT secret is not configured.');
}
$jwtManager = new JwtManager($secretKey);
$payload = [
    'user_id'  => 1001,
    'username' => 'rzrasel',
    'iat'      => time(),
    'exp'      => time() + 3600
];
// Generate token
$token = $jwtManager->createToken($payload);
echo $token . PHP_EOL;
// Verify / Decode (method name per implementation)
$decoded = $jwtManager->verifyToken($token);
// or $jwtManager->decodeToken($token);
print_r($decoded);
```
### 10.3 JWT Algorithm Types
```php
use RzSDK\Encryption\JwtAlgorithmType;
// HS256 => SHA-256
// HS384 => SHA-384
// HS512 => SHA-512
$alg = JwtAlgorithmType::HS256;
// or $alg = JwtAlgorithmType::from('HS256');
```
| Algorithm | Hash |
| :--- | :--- |
| HS256 | SHA-256 |
| HS384 | SHA-384 |
| HS512 | SHA-512 |
### 10.4 Cipher Types & Encryption Types
```php
use RzSDK\Encryption\CipherType;
use RzSDK\Encryption\EncryptionType;
use RzSDK\Encryption\TokenType;
$cipher = CipherType::AES_256_CBC; // example enum
$encType = EncryptionType::OPENSSL;
```
### 10.5 Secret Generation
```php
use RzSDK\Encryption\SecretGenerator;
$secret = SecretGenerator::generate(64); // 64 chars / bytes per impl
echo $secret;
$jwtSecret = SecretGenerator::generateJwtSecret(); // if available
```
### 10.6 IV & Digest Utilities
```php
use RzSDK\Encryption\McryptCipherIvGenerator;
$iv = McryptCipherIvGenerator::generateIv('aes-256-cbc');
$digest = McryptCipherIvGenerator::createDigest('sha256', 'my-data');
```
### 10.7 Using TokenPayload Object
```php
use RzSDK\Encryption\TokenPayload;
$payloadObj = new TokenPayload([
    'sub' => '1234567890',
    'name' => 'Rasel',
    'admin' => true
]);
$token = $jwtManager->createToken($payloadObj->toArray());
```
> **Note:** Always check current class signatures in `data-encryption/src/` and module README for exact method names.
---
## 🏗️ 11. Project Structure
### Full Repository Structure (at once)
```
library-php-rz-sdk-libs/
├── .gitignore
├── composer.json                         # Root workspace composer (path repo to data-encryption)
├── composer-v1.0.0.json                  # Historical v1.0.0 composer snapshot
├── README.md                             # Main workspace documentation
├── TEST.md
├── Git Auto Commit All - v-1.1.3.bat     # Windows git automation
├── Git Auto Commit All - v-1.1.3.command # macOS git automation
├── Git Bash - v-1.1.3.sh                 # Bash git automation
│
└── data-encryption/                      # Module: Data Encryption
    ├── composer.json                     # Module composer (package name: rzrasel/library-php-rz-sdk-libs)
    ├── README.md                         # Module-level documentation
    ├── phpunit.xml
    ├── src/
    │   ├── JwtManager/
    │   │   ├── JwtManager.php            # JWT create/verify/decode
    │   │   └── TokenPayload.php          # Payload DTO
    │   ├── Type/
    │   │   ├── CipherType.php
    │   │   ├── EncryptionType.php
    │   │   ├── JwtAlgorithmType.php
    │   │   └── TokenType.php
    │   └── Utils/
    │       ├── McryptCipherIvGenerator.php
    │       └── SecretGenerator.php
    ├── tests/                            # PHPUnit tests
    │   └── ...
    └── examples/
        └── jwt-example.php
```
### Future Expansion Design
```
library-php-rz-sdk-libs/
├── data-encryption/
├── database/         # future
├── validation/       # future
├── http-client/      # future
├── file-manager/     # future
└── ...
```
Each future module follows same standard: `composer.json`, `README.md`, `src/`, `tests/`, `examples/`.
---
## 👨‍💻 12. Development Setup
```bash
git clone https://github.com/rzrasel/library-php-rz-sdk-libs.git
cd library-php-rz-sdk-libs
# Install workspace deps
composer install
# Install module deps
cd data-encryption
composer install
# Back to root and dump autoload
cd ..
composer dump-autoload
```
---
## 🧪 13. Running Tests
```bash
cd data-encryption
composer install
composer test
# or
vendor/bin/phpunit -c phpunit.xml
# From workspace root:
vendor/bin/phpunit -c data-encryption/phpunit.xml
```
---
## 🌿 14. Git Workflow
| Script | Platform |
| :--- | :--- |
| `Git Auto Commit All - v-1.1.3.bat` | Windows |
| `Git Auto Commit All - v-1.1.3.command` | macOS |
| `Git Bash - v-1.1.3.sh` | Bash |
Basic commands:
```bash
git status
git add .
git commit -m "feat: add encryption utils"
git pull
git push
```
Automation scripts prompt for commit message + timestamp, then stage/commit/pull/push.
---
## 🏷️ 15. Publishing and Versioning
```bash
# Create annotated tag
git tag -a v1.0.0 -m "Initial stable release"
git push origin v1.0.0
# View tags
git tag
# Install tagged version in project
composer require rzrasel/library-php-rz-sdk-libs:^1.0
```
Dev version always:
```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master
```
---
## 🔒 16. Security Considerations
- Never hardcode secrets — use env `APP_JWT_SECRET`
- Use strong keys (256-bit+)
- Validate JWT signature, exp, iss, aud before trusting claims
- Use authenticated encryption (AES-GCM/CBC + HMAC)
- Keep PHP & OpenSSL updated
- This lib provides utilities; passing tests ≠ security audit. Review before production.
---
## 🤝 17. Contributing
1. Fork repo
2. Clone fork
3. Create feature branch `feat/your-feature`
4. Implement + add tests
5. Update docs
6. Commit & push
7. Submit PR
   Guidelines:
- Follow `RzSDK\Encryption` namespace
- Keep modules independent
- Use PSR-4 & Composer autoloading
- Provide usage examples
---
## 📜 18. License & Author
**License:** MIT — See [LICENSE](LICENSE) file.
**Author:** **Rz Rasel**
- GitHub: https://github.com/rzrasel
- Repo: https://github.com/rzrasel/library-php-rz-sdk-libs
- Packagist: https://packagist.org/packages/rzrasel/library-php-rz-sdk-libs
---
> **RzSDK PHP Libraries** — *Reusable PHP Components. Modular Architecture. Simplified Development.* 🚀