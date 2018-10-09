# t3view
This extension will provide several system information via an endpoint. In the client-server model context it represents the server.

[![Build Status](https://travis-ci.org/visuellverstehen/t3view.svg)](https://travis-ci.org/visuellverstehen/t3view)

## Installation
1. `composer require visuellverstehen/t3view`
2. Open up the extension manager in the TYPO3 backend and active the extension.
3. Add a secret to the extension settings to protect the endpoint.
4. The endpoint is then available through `/index.php?type=5996&secret=yoursecret`

## Endpoint
The endpoint is usally `/index.php?type=5996` and secured with a hash / secret which is generated while creating a new instance in the backend. It will return a JSON object containing several system information, take a look at the example output below.
The endpoint can be rewritten via [RealURL](https://github.com/dmitryd/typo3-realurl/wiki/Configuration-reference#filenameindexkeyvalues), but it's not mandatory.

Since TYPO3 9.5 LTS it is also possible to add [Route Enhancer](https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.5/Feature-86160-PageTypeEnhancerForMappingTypeParameter.html) in your site configuration which removes the need of RealURL. Example:

```yaml
routeEnhancers:
  PageTypeSuffix:
    type: PageType
    map:
      t3view.json: 5996
```

The endpoint is then available under `/t3view.json?secret=yoursecret`

## Security
The endpoint is secured with a 60 character hash called secret. It is generated while creating a new instance in the backend using Laravel's `\Illuminate\Hashing\BcryptHasher::make()` method ([learn more about Laravel hashing](https://laravel.com/docs/5.5/hashing)) which uses the PHP [`password_hash()`](http://php.net/manual/de/function.password-hash.php) function with the `CRYPT_BLOWFISH` algorithm.

## Example output

```json
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
```

## Requirements
- TYPO3 6.2 – 9.5
- PHP >= 5.6

## Miscellaneous
- Read code comments, they will explain a lot.
- Contributing is welcomed, just open a pull request or help us with an issue.
- This was part of my graduation project.
