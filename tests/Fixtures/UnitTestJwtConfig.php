<?php

namespace DigiTickets\JwtTests\Fixtures;

use DigiTickets\Jwt\Config\JwtConfigInterface;
use Firebase\JWT\Key;

/**
 * A JwtConfigInterface implementation with a hard-coded key for use in unit tests only.
 */
class UnitTestJwtConfig implements JwtConfigInterface
{
    /**
     * @var Key
     */
    private $key;

    public function __construct()
    {
        $this->key = new Key('abcd', 'HS256');
    }

    /**
     * @return Key
     */
    public function getKey(): Key
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getDefaultExpiresInMinutes(): int
    {
        return 1;
    }
}
