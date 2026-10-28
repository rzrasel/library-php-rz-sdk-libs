# RzSDK PHP Libraries

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



---

## Table of Contents

1. [Introduction](#introduction)
2. [Repository Information](#repository-information)
3. [Features](#features)
4. [Available Libraries](#available-libraries)
5. [Requirements](#requirements)
6. [Installation](#installation)
7. [Composer Configuration](#composer-configuration)
8. [Autoloading](#autoloading)
9. [Usage](#usage)
10. [Project Structure](#project-structure)
11. [Development Setup](#development-setup)
12. [Running Tests](#running-tests)
13. [Git Workflow](#git-workflow)
14. [Publishing and Versioning](#publishing-and-versioning)
15. [Security Considerations](#security-considerations)
16. [Contributing](#contributing)
17. [License](#license)
18. [Author](#author)

---

# 1. Introduction

RzSDK PHP Libraries is a modular PHP SDK workspace developed to provide reusable PHP components for different applications and projects.

The repository follows a modular architecture where individual libraries are maintained independently within the same workspace.

Each library can have its own:

- Composer configuration.
- Source code.
- Namespace.
- Documentation.
- Examples.
- Unit tests.
- Dependencies.

The primary objective is to develop reusable PHP libraries that can be integrated into different PHP applications without duplicating common functionality.

### Design Principles

- Modular library architecture.
- Object-oriented PHP development.
- Composer package management.
- PSR-4 autoloading.
- Namespace-based class organization.
- Reusable and maintainable components.
- Independent library development.
- Extensible SDK structure.

---

# 2. Repository Information

| Property | Details |
|---|---|
| Repository Name | library-php-rz-sdk-libs |
| Package Name | rzrasel/library-php-rz-sdk-libs |
| Organization / Owner | rzrasel |
| Repository Type | Public Git Repository |
| Main Branch | master |
| Language | PHP |
| Minimum PHP Version | 8.2+ |
| Package Manager | Composer |
| License | MIT |
| Repository Model | Modular PHP Library Workspace |

### Repository Links

- **GitHub:** https://github.com/rzrasel/library-php-rz-sdk-libs
- **Clone URL:** https://github.com/rzrasel/library-php-rz-sdk-libs.git
- **Packagist:** https://packagist.org/packages/rzrasel/library-php-rz-sdk-libs
- **Author:** https://github.com/rzrasel

### Clone Repository

```bash
git clone https://github.com/rzrasel/library-php-rz-sdk-libs.git
```

Navigate into the repository:

```bash
cd library-php-rz-sdk-libs
```

---

# 3. Features

The workspace currently includes encryption-related utilities and supports further library expansion.

### Current Capabilities

- JWT token management.
- JWT algorithm definitions.
- JWT token payload handling.
- Encryption type definitions.
- Cipher type definitions.
- OpenSSL-related utilities.
- Secret generation utilities.
- Reusable PHP components.

### Development Features

- Composer-based dependency management.
- Modular package organization.
- Independent library documentation.
- PHPUnit testing support.
- Git automation scripts.

---

# 4. Available Libraries

## 4.1 Data Encryption

**Module:** `data-encryption`

**Package:** `rzrasel/library-php-rz-sdk-libs`

**Namespace:** `RzSDK\Encryption`

The Data Encryption module provides reusable encryption and security-related components.

### Components

| Component | Description |
|---|---|
| JwtManager | JWT token management |
| TokenPayload | JWT payload representation |
| JwtAlgorithmType | JWT signing algorithm definitions |
| TokenType | Token type definitions |
| CipherType | Cipher definitions |
| EncryptionType | Encryption type definitions |
| McryptCipherIvGenerator | Initialization vector and digest utilities |
| SecretGenerator | Secret generation utilities |

Additional encryption, password and OpenSSL components are documented in the module-level documentation where implemented.

**Module documentation:**

`data-encryption/README.md`

---

# 5. Requirements

| Requirement | Version |
|---|---|
| PHP | 8.2 or higher |
| Composer | 2.x recommended |
| OpenSSL Extension | Required |
| JSON Extension | Required |
| PHPUnit | 11.x for testing |

### Required PHP Extensions

```text
ext-openssl
ext-json
```

Check PHP version:

```bash
php -v
```

Check installed extensions:

```bash
php -m
```

---

# 6. Installation

There are two primary ways to use this repository.

## 6.1 Install through Packagist

Install the library in your existing PHP application:

```bash
composer require rzrasel/library-php-rz-sdk-libs
```

Install the development branch:

```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master
```

Prefer source installation when you need to inspect the package source:

```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master --prefer-source
```

Prefer distribution installation:

```bash
composer require rzrasel/library-php-rz-sdk-libs --prefer-dist
```

## 6.2 Clone from GitHub

For development or source-code inspection:

```bash
git clone https://github.com/rzrasel/library-php-rz-sdk-libs.git
```

Then:

```bash
cd library-php-rz-sdk-libs
composer install
```

---

# 7. Composer Configuration

The repository uses Composer to manage PHP dependencies and class autoloading.

There are two Composer configuration levels:

1. Root workspace `composer.json`.
2. Individual library `composer.json`.

Each configuration has a different responsibility.

## 7.1 Root Composer Configuration

The root Composer configuration manages the workspace and its local library dependencies.

The workspace uses a local path repository to reference the `data-encryption` module during development.

A typical path repository configuration looks like this:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "data-encryption",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

The package name and version constraints must match the actual module's Composer metadata.

## 7.2 Individual Library Composer Configuration

Each library maintains its own Composer configuration.

For example:

```text
data-encryption/
    composer.json
```

This configuration defines:

- Package name.
- Package description.
- PHP requirements.
- Dependencies.
- Autoload configuration.
- Development dependencies.
- Testing scripts.

## 7.3 Install Dependencies

From the workspace root:

```bash
composer install
```

## 7.4 Clear Composer Cache

```bash
composer clear-cache
```

## 7.5 Update Package

```bash
composer update rzrasel/library-php-rz-sdk-libs
```

## 7.6 Regenerate Autoload Files

```bash
composer dump-autoload
```

## 7.7 Remove Package

From a consumer project:

```bash
composer remove rzrasel/library-php-rz-sdk-libs
```

---

# 8. Autoloading

Composer automatically generates the autoload file:

```text
vendor/autoload.php
```

This file is generated by Composer. It should not be manually created.

Include it in your application:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';
```

Import classes using their existing namespaces.

For example:

```php
use RzSDK\Encryption\JwtManager;
use RzSDK\Encryption\TokenPayload;
```

The existing namespace convention is maintained:

```php
RzSDK\Encryption
```

**Important:** The actual PSR-4 mapping must match the source directory and namespace declarations in the individual module's Composer configuration.

---

# 9. Usage

## 9.1 Basic Composer Usage

First, include the Composer autoloader:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';
```

Import the required classes:

```php
use RzSDK\Encryption\JwtManager;
use RzSDK\Encryption\TokenPayload;
```

You can now use the classes provided by the installed package.

## 9.2 JWT Token Management

JWT stands for JSON Web Token.

JWT tokens are commonly used for:

- User authentication.
- API authorization.
- Stateless authentication.
- Secure application communication.
- Access token management.

### Example

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use RzSDK\Encryption\JwtManager;

$secretKey = getenv('APP_JWT_SECRET');

if (!$secretKey) {
    throw new RuntimeException(
        'JWT secret is not configured.'
    );
}

$jwtManager = new JwtManager($secretKey);

$payload = [
    'user_id' => 1001,
    'username' => 'rzrasel',
    'iat' => time(),
    'exp' => time() + 3600
];

// Generate token
$token = $jwtManager->createToken($payload);

echo $token;
```

The example illustrates the JWT manager's array-payload usage. Check the current class signature and `TokenPayload` requirements before adapting it to another version.

### JWT Algorithm Types

Import the algorithm enum:

```php
use RzSDK\Encryption\JwtAlgorithmType;
```

The library documents the following HMAC algorithm values:

| Algorithm | Hash |
|---|---|
| HS256 | SHA-256 |
| HS384 | SHA-384 |
| HS512 | SHA-512 |

The actual signing algorithm should be explicitly selected and validated according to the JWT implementation.

## 9.3 Cipher Types

Cipher definitions provide information about supported encryption algorithms.

Example:

```php
use RzSDK\Encryption\CipherType;
```

Use the cipher enum values supported by the installed library version.

## 9.4 Encryption Types

Encryption type definitions help identify different encryption mechanisms.

```php
use RzSDK\Encryption\EncryptionType;
```

## 9.5 Secret Generation

The library also documents secret generation utilities.

```php
use RzSDK\Encryption\SecretGenerator;
```

Use the module-level documentation for the exact method signatures and supported options.

## 9.6 Initialization Vector Utilities

```php
use RzSDK\Encryption\McryptCipherIvGenerator;
```

This component provides initialization vector and digest-related helper functionality.

### Detailed Examples

For complete examples, class signatures, parameters and return values, refer to:

**[Data Encryption Documentation](data-encryption/README.md)**

---

# 10. Project Structure

The repository follows a modular workspace architecture.

Each library is organized independently inside its own directory.

## 10.1 Repository Root Structure

```text
library-php-rz-sdk-libs/
├── .gitignore
├── composer.json
├── composer-v1.0.0.json
├── README.md
├── Git Auto Commit All - v-1.1.3.bat
├── Git Auto Commit All - v-1.1.3.command
├── Git Bash - v-1.1.3.sh
└── data-encryption/
    │
    ├── composer.json
    ├── README.md
    ├── phpunit.xml
    ├── src/
    │   ├── JwtManager/
    │   │   ├── Type/
    │   │   └── Utils/
    ├── tests/
    └── examples/
        └── jwt-example.php
```

The structure above represents the workspace and source organization documented in the repository. See the module-level README for its detailed class listing.

## 10.2 Data Encryption Source Structure

The repository README documents the following source files:

```text
data-encryption/
├── composer.json
├── src/
│   │
│   ├── JwtManager/
│   │   ├── JwtManager.php
│   │   └── TokenPayload.php
│   ├── Type/
│   │   ├── CipherType.php
│   │   ├── EncryptionType.php
│   │   ├── JwtAlgorithmType.php
│   │   └── TokenType.php
│   └── Utils/
│       ├── McryptCipherIvGenerator.php
│       └── SecretGenerator.php
└── examples/
    └── jwt-example.php
```

The workspace README also contains an alternative organization using `Types/`, `OpensslEncryption/`, and `PasswordEncryption/`. Verify the current module tree before using that alternative layout as a literal directory inventory.

## 10.3 Root File Description

| File | Description |
|---|---|
| `.gitignore` | Git ignored files and directories |
| `composer.json` | Root workspace Composer configuration |
| `composer-v1.0.0.json` | Historical Composer configuration |
| `README.md` | Main workspace documentation |
| `Git Auto Commit All - v-1.1.3.bat` | Windows Git automation |
| `Git Auto Commit All - v-1.1.3.command` | macOS Git automation |
| `Git Bash - v-1.1.3.sh` | Shell-based Git automation |

## 10.4 Future Library Expansion

The workspace is designed to accommodate additional independent libraries.

For example:

```text
library-php-rz-sdk-libs/
├── data-encryption/
├── database/
├── validation/
├── http-client/
├── file-manager/
└── ...
```

These are proposed future modules, not a claim that all currently exist in the repository.

Each module should maintain its own:

```text
library-name/
├── composer.json
├── README.md
├── src/
├── tests/
└── examples/
```

---

# 11. Development Setup

## 11.1 Clone Repository

```bash
git clone https://github.com/rzrasel/library-php-rz-sdk-libs.git
```

## 11.2 Navigate to Repository

```bash
cd library-php-rz-sdk-libs
```

## 11.3 Install Workspace Dependencies

```bash
composer install
```

## 11.4 Install Module Dependencies

```bash
cd data-encryption
composer install
```

## 11.5 Regenerate Autoload

```bash
composer dump-autoload
```

---

# 12. Running Tests

The Data Encryption module documents PHPUnit 11 support.

From the module directory:

```bash
cd data-encryption
```

Install development dependencies:

```bash
composer install
```

Run tests using the configured Composer script:

```bash
composer test
```

Alternatively, from the workspace root:

```bash
vendor/bin/phpunit -c data-encryption/phpunit.xml
```

Tests verify implemented behavior. Passing tests do not constitute a cryptographic security audit.

---

# 13. Git Workflow

The repository includes Git automation scripts for different operating systems.

| Script | Platform |
|---|---|
| Git Auto Commit All - v-1.1.3.bat | Windows |
| Git Auto Commit All - v-1.1.3.command | macOS |
| Git Bash - v-1.1.3.sh | Bash-compatible environments |

### Basic Git Commands

Check repository status:

```bash
git status
```

Add changes:

```bash
git add .
```

Commit changes:

```bash
git commit -m "Update PHP libraries"
```

Pull changes:

```bash
git pull
```

Push changes:

```bash
git push
```

### Git Automation

The Windows and macOS automation scripts prompt for a commit message, append a timestamp, stage changes, commit, pull and push.

Review the scripts before execution and ensure your working tree and remote branch are in a suitable state.

---

# 14. Publishing and Versioning

The project can use Git tags to identify stable releases.

### Create a Version Tag

```bash
git tag -a v1.0.0 -m "Initial stable release"
```

Push the tag:

```bash
git push origin v1.0.0
```

### View Tags

```bash
git tag
```

### Install a Tagged Version

After publishing the corresponding Composer-compatible release:

```bash
composer require rzrasel/library-php-rz-sdk-libs:^1.0
```

### Development Version

```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master
```

For a workspace containing independently versioned modules, consider publishing each module as a separate Composer package when independent installation and versioning are required.

---

# 15. Security Considerations

Security is particularly important for encryption and authentication libraries.

Recommendations:

- Never hardcode production secrets.
- Use secure environment variables or a secret manager.
- Use strong cryptographic keys.
- Never store plaintext passwords.
- Use password hashing for password storage.
- Validate JWT signatures before trusting token claims.
- Enforce JWT expiration, issuer and audience validation.
- Use authenticated encryption for sensitive data.
- Keep PHP and OpenSSL updated.
- Review cryptographic implementations before production deployment.

**Security disclaimer:** This repository provides reusable PHP utilities. The existence of encryption methods or passing unit tests does not guarantee that an implementation is secure against all attacks.

---

# 16. Contributing

Contributions and suggestions are welcome.

### Contribution Process

1. Fork the repository.
2. Clone your fork.
3. Create a feature branch.
4. Implement your changes.
5. Add or update tests.
6. Update documentation.
7. Commit your changes.
8. Push your branch.
9. Submit a pull request.

### Development Guidelines

- Follow existing PHP namespace conventions.
- Maintain independent library modules.
- Use Composer-compatible autoloading.
- Keep source code organized.
- Provide practical usage examples.
- Include appropriate tests.
- Update module documentation when adding features.

---

# 17. License

This project is distributed under the MIT License.

See the [LICENSE](LICENSE) file for details.

---

# 18. Author

**Rz Rasel**

GitHub:

https://github.com/rzrasel

Repository:

https://github.com/rzrasel/library-php-rz-sdk-libs

Packagist:

https://packagist.org/packages/rzrasel/library-php-rz-sdk-libs

---

**RzSDK PHP Libraries**

*Reusable PHP Components. Modular Architecture. Simplified Development.*












old README instruction


# RzSDK PHP Libraries Workspace

Library PHP Rz SDK Libs - Secure encryption utilities for PHP 8.2+

## Requirements

- PHP 8.2+
- ext-openssl
- ext-json
- Composer

## Installation

```bash
composer require rzrasel/library-php-rz-sdk-libs
```

```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master
```

```bash
composer require rzrasel/library-php-rz-sdk-libs:dev-master --prefer-source
```

```text
library-php-rz-sdk-libs/
├── composer.json
└── data-encryption/
├── composer.json
├── src/
│   ├── JwtManager/
│   │   ├── JwtManager.php
│   │   └── TokenPayload.php
│   ├── Type/
│   │   ├── CipherType.php
│   │   ├── EncryptionType.php
│   │   ├── JwtAlgorithmType.php
│   │   └── TokenType.php
│   └── Utils/
│       ├── McryptCipherIvGenerator.php
│       └── SecretGenerator.php
└── examples/
└── jwt-example.php
```

# RzSDK PHP Libraries Workspace

This is a workspace containing independently structured RzSDK PHP libraries. Existing library source code is preserved as supplied; the `tests/` directory and detailed usage guide are additions.

https://packagist.org/packages/rzrasel/library-php-rz-sdk-libs

composer init -n
composer clear-cache
composer require rzrasel/library-php-rz-sdk-libs --prefer-dist
composer update rzrasel/library-php-rz-sdk-libs --prefer-source

composer dump-autoload

composer require rzrasel/library-php-rz-sdk-libs

composer remove rzrasel/library-php-rz-sdk-libs
composer clear-cache
composer require rzrasel/library-php-rz-sdk-libs:dev-master

## Structure

```text
library-php-rz-sdk-libs/
├── composer.json
└── data-encryption/
    ├── composer.json
    ├── src/
    │   ├── Types/
    │   ├── JwtManager/
    │   ├── OpensslEncryption/
    │   └── PasswordEncryption/
    ├── tests/
    └── examples/
```

## Requirements

- PHP 8.2+
- OpenSSL and JSON PHP extensions
- Composer
- PHPUnit 11 for running the tests

## Install workspace dependencies

From the `rzsdklibs/` workspace root:

```bash
composer install
```

Composer generates `vendor/autoload.php`. The local path repository links the `data-encryption` package into the workspace.

## Run tests

From `rzsdklibs/data-encryption/`:

```bash
composer install
composer test
```

Or, from the workspace root after dependencies have been installed:

```bash
vendor/bin/phpunit -c data-encryption/phpunit.xml
```

## Use the library in an application

If the package is installed through Composer, include the generated autoloader:

```php
require __DIR__ . '/vendor/autoload.php';
```

Then import the classes under the existing `RzSDK\\Encryption` namespace. See `data-encryption/README.md` for detailed examples.

## GitHub publishing

For the simplest standalone Composer package, publish `data-encryption/` as its own GitHub repository. If publishing the whole workspace as one repository, users can use the local path repository for development, or configure the package repository appropriately for deployment. A GitHub organization itself is not a Composer repository root.

## Scope note

This deliverable does not rewrite the existing encryption classes. The added tests exercise their current documented behavior. Tests are not a security audit, and passing tests do not establish production security.
