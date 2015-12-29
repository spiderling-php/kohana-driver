<?php

namespace SP\KohanaDriver\Test;

use PHPUnit_Framework_TestCase;
use SP\KohanaDriver\Session;

/**
 * @coversDefaultClass SP\KohanaDriver\Session
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $browser = $this
            ->getMockBuilder('SP\KohanaDriver\Crawler')
            ->disableOriginalConstructor()
            ->getMock();

        $session = new Session($browser);

        $this->assertInstanceOf('SP\Spiderling\CrawlerInterface', $session->getCrawler());

        $this->assertSame($browser, $session->getCrawler());
    }

    /**
     * @covers ::__construct
     */
    public function testConstructDefault()
    {
        $session = new Session();

        $this->assertInstanceOf('SP\KohanaDriver\Crawler', $session->getCrawler());
    }
}
