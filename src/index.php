<?php

/**
 * ParseMarkdown is a PHP class that parses a
 * markdown input, converts it into HTML, and
 * returns HTML.
 *
 * @author     Rosie Faulkner
 * @version    1.0.0
 *
 */

class ParseMarkdown
{
    /**
     * Defines regex characters to replace markdown
     * @var array
     */
    public static $regex = [
        '/\n(#+)(.*)/' => 'self::headerLevels',                                 // Headings
        '/\[([^]]*)\] *\(([^)]*)\)/i' => 'self::hyperLinks',                    // Hyperlinks
        '/\n([^\n]+)/' => 'self::unformattedText',                              // Unformatted text
        '^(?:[\t ]*(?:\r?\n|\r))+' => '',                                       // Blank lines (ignored)                                                            // blank line
    ];

    public function __construct()
    {
        $markdown = isset($_POST['markdown']) ? $_POST['markdown'] : '';
        $html = $markdown ? self::converToHtml($markdown) : '';
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
     * hyperLinks
     * Identifies hyperlink markdown and replaces with HTML links
     * @param array
     * @return string
     */
    private static function hyperLinks(array $regs): string
    {
        list($fullString, $linkedText, $domain) = $regs;
        return sprintf('<a href="%s">%s</a>', $domain, trim($linkedText));
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
$parseMarkdown = new ParseMarkdown();