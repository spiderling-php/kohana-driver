<?php

namespace SP\KohanaDriver\Test;

use PHPUnit_Framework_TestCase;
use SP\KohanaDriver\Crawler;
use SP\Spiderling\CrawlerSession;

/**
 * @covers SP\KohanaDriver\Loader
 */
class IntegrationTest extends PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $session = new CrawlerSession(new Crawler());

        $session->open('/blog');

        $this->assertEquals('Blog Index', $session->get('h1')->getText());
        $this->assertEquals('Kohana Spiderling', $session->get('title')->getText());
        $this->assertEquals('/blog', $session->get('meta[type="description"]')->getattribute('content'));
    }

    public function testTraverse()
    {
        $session = new CrawlerSession(new Crawler());

        $session->open('/blog');
        $session->clickLink('Next Post');

        $this->assertEquals('Post', $session->get('h1')->getText());
        $this->assertEquals('Next Post', $session->get('h2')->getText());

        $this->assertCount(0, $session->get('div:text("Comments")')->getArray('ul > li'));
    }

    public function testForm()
    {
        $session = new CrawlerSession(new Crawler());

        $session->open('/blog/next-post');
        $session
            ->setField('name', 'My name')
            ->setField('message', 'My comment')
            ->setFieldFile('attachment', __DIR__.'/../../tests/module/icon1.png')
            ->clickButton('btn');

        $session->get('div:text("Comments")')->with(function ($comment) {
            $this->assertCount(1, $comment->getArray('ul > li'));
            $this->assertTrue($comment->get('img')->isVisible());
            $this->assertEquals('My name', $comment->get('span')->getText());
            $this->assertEquals('My comment', $comment->get('p')->getText());
        });
    }

    public function testRedirect()
    {
        $session = new CrawlerSession(new Crawler());
        $session->open('/old-blog');

        $this->assertEquals('Blog Index', $session->get('h1')->getText());
        $this->assertEquals('/blog', $session->get('meta[type="description"]')->getattribute('content'));
        $this->assertEquals('/blog', (string) $session->getUri());
    }

    public function testRedirectLoop()
    {
        $this->setExpectedException('LogicException', 'Maximum Number of redirects (5) for url /redirect-loop');

        $session = new CrawlerSession(new Crawler());
        $session->open('/redirect-loop');
    }
}
