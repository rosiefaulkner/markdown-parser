<?php

require('./src/inc/Parser.php');

class ParserTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider htmlToMarkdownProvider
     */
    public function testConverToHtml($markdown, $html)
    {
        $this->assertEquals($html, Parser::converToHtml($markdown));
    }

    public function htmlToMarkdownProvider()
    {
        return [
            ['# Hello', '<h1>Hello</h1>'],
            ['## Hello', '<h2>Hello</h2>'],
            ['### Hello', '<h3>Hello</h3>'],
            ['#### Hello', '<h4>Hello</h4>'],
            ['##### Hello', '<h5>Hello</h5>'],
            ['###### Hello', '<h6>Hello</h6>'],
            ['Hello', '<p>Hello</p>'],
            // ['[Duck Duck Go](https://duckduckgo.com)', '<a href="https://duckduckgo.com">Duck Duck Go</a>'],
        ];
    }
}
