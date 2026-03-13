<?php

namespace DigiTickets\Jwt\Config;

use Firebase\JWT\Key;

/**
 * Provides the signing key and default expiry for JWT creation and verification.
 */
interface JwtConfigInterface
{
    /**
     * Returns the Firebase JWT Key used to sign and verify tokens.
     *
     * @return Key
     */
    public function getKey(): Key;

    /**
     * Returns the default token lifetime in minutes, used by JwtFactory when
     * no explicit expiry is passed.
     *
     * @return int
     */
    public function getDefaultExpiresInMinutes(): int;
}
