<?php

namespace DigiTickets\Jwt;

use DateTime;
use DateTimeZone;

/**
 * Represents the claims stored within a JWT.
 */
class JwtData
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Returns all claims as a plain array.
     *
     * @return array
     */
    public function getAllData(): array
    {
        return $this->data;
    }

    /**
     * Sets a claim value.
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Returns the value of a claim by key, or null if not present.
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Returns the 'iat' (issued at) claim as a UTC DateTime, or null if not present.
     *
     * @return DateTime|null
     */
    public function getIssuedAt(): ?DateTime
    {
        return $this->getDateForTimestamp(JwtClaims::ISSUED_AT);
    }

    /**
     * Returns the 'exp' (expiration time) claim as a UTC DateTime, or null if not present.
     *
     * @return DateTime|null
     */
    public function getExpirationTime(): ?DateTime
    {
        return $this->getDateForTimestamp(JwtClaims::EXPIRATION_TIME);
    }

    /**
     * Converts a Unix timestamp claim to a UTC DateTime.
     *
     * @param string $key
     *
     * @return DateTime|null
     */
    private function getDateForTimestamp(string $key): ?DateTime
    {
        if ($value = $this->get($key)) {
            return DateTime::createFromFormat('U', $value, new DateTimeZone('UTC'));
        }

        return null;
    }
}
