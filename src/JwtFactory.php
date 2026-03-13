<?php

namespace DigiTickets\Jwt;

use DigiTickets\Jwt\Config\JwtConfigInterface;
use Firebase\JWT\JWT;

/**
 * Creates signed JWT strings from a JwtData payload.
 *
 * The current time is taken from JWT::$timestamp if set (useful in tests),
 * falling back to time().
 */
class JwtFactory
{
    /**
     * Creates and signs a JWT containing the given claims.
     *
     * The 'iat' (issued at) claim is set automatically.
     *
     * The 'exp' (expiration) claim is set based on $expiresInMinutes if provided,
     * if not it will use the default time from the config.
     * If either of those are 0 then the 'exp' claium will not be set (no expiration).
     *
     * @param JwtConfigInterface $jwtConfig
     * @param JwtData $jwtData
     * @param int|null $expiresInMinutes Pass 0 for no expiration. If null, uses the config default.
     *
     * @return string The signed JWT string.
     */
    public static function createJwt(
        JwtConfigInterface $jwtConfig,
        JwtData $jwtData,
        ?int $expiresInMinutes = null
    ): string {
        $now = JWT::$timestamp ?? time();

        $defaultClaims = [
            JwtClaims::ISSUED_AT => $now,
        ];

        if ($expiresInMinutes === null) {
            $expiresInMinutes = $jwtConfig->getDefaultExpiresInMinutes();
        }

        if ($expiresInMinutes !== 0) {
            $defaultClaims[JwtClaims::EXPIRATION_TIME] = $now + ($expiresInMinutes * 60);
        }

        return JWT::encode(
            array_merge($defaultClaims, $jwtData->getAllData()),
            $jwtConfig->getKey()->getKeyMaterial(),
            $jwtConfig->getKey()->getAlgorithm()
        );
    }
}
