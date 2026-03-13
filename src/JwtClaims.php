<?php

namespace DigiTickets\Jwt;

/**
 * This defines constants for the keys of some of the 'claims' a JWT can contain.
 * As defined in RFC 7519.
 * https://datatracker.ietf.org/doc/html/rfc7519#section-4.1
 */
class JwtClaims
{
    const ISSUER = 'iss';

    const SUBJECT = 'sub';

    const AUDIENCE = 'aud';

    const EXPIRATION_TIME = 'exp';

    const NOT_BEFORE = 'nbf';

    const ISSUED_AT = 'iat';
}
