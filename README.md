# t3view_extension
This extension will provide serveral system information via an endpoint. In the client-server model context it represents the server.

## Installation
1. [Download](https://github.com/visuellverstehen/t3view_extension/releases/latest) a copy of the extension.
2. Upload the extension in `typo3conf/ext/t3view` of your desired instance. __Important: the foldername of the extension must be t3view!__
3. Open up the extension manager in the TYPO3 backend and active the extension.
4. Add the secret from the t3view backend in the extension settings.
5. Go to the t3view backend and verify the extension installation by clicking on the endpoint link.

You can also install the extension with composer. To do so add the following snippet to your `composer.json`:

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/visuellverstehen/t3view_extension"
            }
        ],
        "require": {
            "visuel/t3view": "^1.0.0"
        }
    }

## Endpoint
The endpoint is usally `/index.php?type=5996` and secured with a hash / secret which is generated while creating a new instance in the backend. It will return a JSON object containing serveral system information, take a look at the example output below.
The endpoint can be rewritten via [ReaLURL](https://github.com/dmitryd/typo3-realurl/wiki/Configuration-reference#filenameindexkeyvalues), but it's not mandatory.

## Security
The endpoint is secured with a 60 character hash called secret. It is generated while creating a new instance in the backend using Laravel's `\Illuminate\Hashing\BcryptHasher::make()` method ([learn more about Laravel hashing](https://laravel.com/docs/5.5/hashing)) which uses the PHP [`password_hash()`](http://php.net/manual/de/function.password-hash.php) function with the `CRYPT_BLOWFISH` algorithm.

## Example output
    {
        "applicationContext": "Development",
        "composer": true,
        "databaseVersion": "MySQL 5.7.19",
        "extensions": [
            {
                "key": "sourceopt",
                "version": "1.0.0"
            },
            {
                "key": "t3view",
                "version": "1.0.0"
            }
        ],
        "phpVersion": "7.1.10",
        "serverSoftware": "Apache\/2.4.25 (Unix) PHP\/7.1.10",
        "sitename": "Test setup",
        "typo3Version": "8.7.8"
    }

## Requirements
- TYPO3 6.2 - 8.7 (9-dev works but is in development, so it might not work properly)
- PHP >= 5.6

## Miscellaneous
- Read code comments, they will explain a lot.
- Contributing is welcomed, just open a pull request.
- This is my graduation project.
