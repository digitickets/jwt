<?php

namespace DigiTickets\Jwt;

use DigiTickets\Jwt\Config\JwtConfigInterface;
use Firebase\JWT\JWT;

class JwtParser
{
    /**
     * Verifies and decodes a signed JWT string into a JwtData instance.
     *
     * A 15-second leeway is applied to the 'iat' claim to tolerate minor clock differences between systems.
     */
    public static function parseJwt(
        JwtConfigInterface $jwtConfig,
        string $jwt
    ): JwtData {
        // Allow issued at (iat) to be up to 15 seconds in the future to allow for time differences between
        // systems (as experienced between dev and staging).
        JWT::$leeway = 15;

        $data = (array) JWT::decode($jwt, $jwtConfig->getKey());

        return new JwtData($data);
    }
}
