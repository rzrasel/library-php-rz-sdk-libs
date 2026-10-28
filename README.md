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
