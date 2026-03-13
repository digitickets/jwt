<?php

namespace DigiTickets\JwtTests;

use DigiTickets\Jwt\JwtClaims;
use DigiTickets\Jwt\JwtData;
use DateTime;
use PHPUnit\Framework\TestCase;

class JwtDataTest extends TestCase
{
    public function testConstructWithNoDataReturnsEmptyArray()
    {
        $data = new JwtData();

        $this->assertSame([], $data->getAllData());
    }

    public function testGetReturnsClaimValue()
    {
        $data = new JwtData([JwtClaims::SUBJECT => 1234]);

        $this->assertSame(1234, $data->get('sub'));
        $this->assertSame(['sub' => 1234], $data->getAllData());
    }

    public function testGetReturnsNullForMissingKey()
    {
        $data = new JwtData();

        $this->assertNull($data->get('nonexistent'));
    }

    public function testSetOverwritesClaimValue()
    {
        $data = new JwtData([JwtClaims::SUBJECT => 1234]);
        $data->set('sub', 5678);

        $this->assertSame(5678, $data->get('sub'));
    }

    public function testGetDates()
    {
        $data = new JwtData(
            [
                JwtClaims::ISSUED_AT => '1628435556',
                JwtClaims::EXPIRATION_TIME => '1628435557',
            ]
        );

        $this->assertEquals(
            new DateTime('2021-08-08T15:12:36.000000+0000'),
            $data->getIssuedAt()
        );

        $this->assertEquals(
            new DateTime('2021-08-08T15:12:37.000000+0000'),
            $data->getExpirationTime()
        );
    }

    public function testDatesAreInUtc()
    {
        $data = new JwtData(
            [
                JwtClaims::ISSUED_AT => '1628435556',
                JwtClaims::EXPIRATION_TIME => '1628435557',
            ]
        );

        $this->assertSame(0, $data->getIssuedAt()->getOffset());
        $this->assertSame(0, $data->getExpirationTime()->getOffset());
    }

    public function testGetIssuedAtReturnsNullWhenNotSet()
    {
        $data = new JwtData();

        $this->assertNull($data->getIssuedAt());
    }

    public function testGetExpirationTimeReturnsNullWhenNotSet()
    {
        $data = new JwtData();

        $this->assertNull($data->getExpirationTime());
    }
}
