<?php

namespace Rosiefaulkner\MarkdownToHtml;

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
            [
                '# Hello',
                '<h1>Hello</h1>'
            ],
            [
                '## Hello',
                '<h2>Hello</h2>'
            ],
            [
                '### Hello',
                '<h3>Hello</h3>'
            ],
            [
                '#### Hello',
                '<h4>Hello</h4>'
            ],
            [
                '##### Hello',
                '<h5>Hello</h5>'
            ],
            [
                '###### Hello',
                '<h6>Hello</h6>'
            ],
            ['Hello', '<p>Hello</p>'],
            [
                '[Duck Duck Go](https://duckduckgo.com)',
                '<p><a href="https://duckduckgo.com">Duck Duck Go</a></p>'
            ],
            [
                '![bananas](https://cdn-prod.medicalnewstoday.com/content/images/articles/271/271157/bananas-chopped-up-in-a-bowl.jpg)',
                '<p><img src="https://cdn-prod.medicalnewstoday.com/content/images/articles/271/271157/bananas-chopped-up-in-a-bowl.jpg" alt="bananas"></img></p>'
            ]
        ];
    }
}
