# digitickets/jwt

A small library for creating and parsing signed JWTs.
Supports PHP 7.3 and above, and uses the `firebase/php-jwt` library under the hood.

## Installation

```bash
composer require digitickets/jwt
```

## Usage

### 1. Create a config implementing `JwtConfigInterface`

Create a config class that provides the signing key and default token lifetime:

```php
use DigiTickets\Jwt\Config\JwtConfigInterface;
use Firebase\JWT\Key;

class MyJwtConfig implements JwtConfigInterface
{
    public function getKey(): Key
    {
        return new Key($_ENV['MY_JWT_SECRET'], 'HS256');
    }

    public function getDefaultExpiresInMinutes(): int
    {
        return 1;
    }
}
```

### 2. Create a JWT

```php
use DigiTickets\Jwt\JwtClaims;
use DigiTickets\Jwt\JwtData;
use DigiTickets\Jwt\JwtFactory;

$token = JwtFactory::createJwt(
    new MyJwtConfig(), // The config created in step 1.
    new JwtData([
        JwtClaims::AUDIENCE => 'my-service',
    ])
);

var_dump($token); // string(153) "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NzM0MzU5NjEsImV4cCI6MTc3MzQzNjAyMSwiYXVkIjoibXktc2VydmljZSJ9.7Y8Sr7RL9w453TuSpC-j5u8ZicbN6QSUtInu6xc2VpA"
```

Pass an explicit expiry in minutes as the third argument, or `0` for a non-expiring token:

```php
// Expires in 30 days
$token = JwtFactory::createJwt($config, $jwtData, 1440 * 30);

// Never expires
$token = JwtFactory::createJwt($config, $jwtData, 0);
```

### 3. Parse and verify a token

```php
use DigiTickets\Jwt\JwtParser;

$data = JwtParser::parseJwt($config, $token);

$data->get('aud');           // 'my-service'
$data->getIssuedAt();        // DateTime
$data->getExpirationTime();  // DateTime

print_r($data);
// Output:
// DigiTickets\Jwt\JwtData Object
// (
//    [data:DigiTickets\Jwt\JwtData:private] => Array
//        (
//            [iat] => 1773435961
//            [exp] => 1773436021
//            [aud] => my-service
//        )
//
// )
```

Throws a `Firebase\JWT` exception if the token is invalid, expired, or has a bad signature.

## Testing
Because we are supporting an old version of PHP, it's advisable to run tests in a Docker container so we use
the correct PHP version.
```
./shell.sh
# Inside the container:
composer install
composer test
```
