<?php

namespace SP\KohanaDriver\Test;

use SP\KohanaDriver\Crawler;
use PHPUnit_Framework_TestCase;
use DOMDocument;

/**
 * @coversDefaultClass SP\KohanaDriver\Crawler
 */
class CrawlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $document = new DOMDocument();

        $crawler = new Crawler($document);

        $this->assertInstanceOf('SP\KohanaDriver\Loader', $crawler->getLoader());
        $this->assertSame($document, $crawler->getDocument());

        $crawler = new Crawler();

        $this->assertInstanceOf('SP\KohanaDriver\Loader', $crawler->getLoader());
        $this->assertInstanceOf('DOMDocument', $crawler->getDocument());
    }
}
