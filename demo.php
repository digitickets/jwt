<?php

require_once "vendor/autoload.php";

use DigiTickets\Jwt\Config\JwtConfigInterface;
use DigiTickets\Jwt\JwtClaims;
use DigiTickets\Jwt\JwtData;
use DigiTickets\Jwt\JwtFactory;
use Firebase\JWT\Key;

class MyJwtConfig implements JwtConfigInterface
{
    public function getKey(): Key
    {
        return new Key('hello-world', 'HS256');
    }

    public function getDefaultExpiresInMinutes(): int
    {
        return 1;
    }
}

$token = JwtFactory::createJwt(
    new MyJwtConfig(),
    new JwtData([
        JwtClaims::AUDIENCE => 'my-service',
    ])
);

var_dump($token);

$parsedData = (new DigiTickets\Jwt\JwtParser())->parseJwt(
    new MyJwtConfig(),
    $token
);

print_r($parsedData);
