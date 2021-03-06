<?php

namespace Rosiefaulkner\MarkdownToHtml;

class Parser
{
    /**
     * Defines regex characters to replace markdown
     * @var array
     */
    public static $regex = [
        '/\n(#+)(.*)/' => 'self::headerLevels',                                                              // Headings
        '/\n([^\n]+)/' => 'self::unformattedText',                                                           // Unformatted text
        '^(?:[\t ]*(?:\r?\n|\r))+' => '',                                                                    // Blank lines (ignored)                                                                                            // blank line
        '/(!)*\[([^\]]+)\]\(([^\)]+?)(?: &quot;([\w\s]+)&quot;)*\)/' => 'self::linkOrImages',                // Images & Links
    ];

    public function __construct()
    {
        $markdown = isset($_POST['markdown']) ? $_POST['markdown'] : '';
        $noInput = isset($_POST['submit']) && $markdown == '' ? '##Oops. You didn\'t enter any markdown...' : '';
        $html = $markdown ? self::converToHtml($markdown) : self::converToHtml($noInput);
        $output = file_get_contents('input.html');
        $output = str_replace('{{ markdown }}', $markdown, $output);
        $output = str_replace('{{ html }}', $html, $output);
        echo $output;
    }

    /**
     * headerLevels
     * Identifies how many hashtags are used for headers
     * Replaces markdown headers with HTML header tags
     * @param array
     * @return string
     */
    private static function headerLevels(array $regs): string
    {
        // Assigns arguments to list: $fullString = original string, $hashtag = heading hashtags, $headerText = heading text
        list($fullString, $hashTag, $headerText) = $regs;
        $headingType = strlen($hashTag);
        // Replaces hashtag with count of hashtags placed with $headerText in between values
        return sprintf('<h%d>%s</h%d>', $headingType, trim($headerText), $headingType);
    }

    /**
     * unformattedText
     * Identifies unformmatted text and adds <p> tags and new line
     * If unformatted text is in in an ordered/unordered list, for example, <p> tags are still applied
     * @param array
     * @return string
     */
    private static function unformattedText(array $regs): string
    {
        return sprintf("\n<p>%s</p>\n", trim($regs[1]));
    }

    /**
     * linkOrImages
     * Identifies hyperlink and image markdown and
     * replaces with HTML tags for hyperlinks or images depending
     * on the presence of '!' prior to the link in markdown input
     * @param array
     * @return string
     */
    private static function linkOrImages(array $regs)
    {
        list($fullString, $tagIdentifier, $linkedText, $domain) = $regs;
        return $tagIdentifier === '!' ? sprintf('<img src="%s" alt="%s"></img>', $domain, trim($linkedText)) : sprintf('<a href="%s">%s</a>', $domain, trim($linkedText));
    }

    /**
     * converToHtml
     * Uses markdown input from form field
     * Applies foreach loop that checks if $regexRules have a function defined for parsing
     * Replaces regex with replacement from $regexRules
     * @return string
     */
    public static function converToHtml(string $markdownText): string
    {
        $markdownText = "\n" . $markdownText . "\n";
        foreach (self::$regex as $regexPattern => $replacementHtml) {
            if (is_callable($replacementHtml)) {
                $markdownText = preg_replace_callback($regexPattern, $replacementHtml, $markdownText);
            }
        }
        return trim($markdownText);
    }
}
