# Markdown To HTML

Markdown To HTML is a PHP class written to make converting markdown syntax to HTML simple and fast.

## Installation

Clone or download the files and add to your project. From within your HTML form, input {{ markdown }} where you will be inputting markdown text. Input {{ html }} where you will be outputting the markdown into HTML. 
 
```bash
<textarea 
   type="text" 
   name="markdown" 
   id="markdown" 
   class="md-textarea icon"
>
{{ markdown }}</textarea>

<div id="markdown-output">
    <div id="copy-html">{{ html }}</div>
</div>

```

## Usage

```PHP
$parseMarkdown = new ParseMarkdown();

# returns '<h1>Hello World</h1>'
$parseMarkdown::parseMarkdown('#Hello World')

# returns '<h2>Hello World</h2>'
$parseMarkdown::parseMarkdown('##Hello World')

# returns '<h3>Hello World</h3>'
$parseMarkdown::parseMarkdown('###Hello World')

# returns '<h4>Hello World</h4>'
$parseMarkdown::parseMarkdown('####Hello World')

# returns '<h5>Hello World</h5>'
$parseMarkdown::parseMarkdown('#####Hello World')

# returns '<h6>Hello World</h6>'
$parseMarkdown::parseMarkdown('######Hello World')

# returns '<p>Hello World</p>'
$parseMarkdown::parseMarkdown('Hello World')

# returns '<a href="https://www.example.com)Link Text</a>">'
$parseMarkdown::parseMarkdown('[Link text](https://www.example.com)')

# returns ' '
$parseMarkdown::parseMarkdown('Blank Line')

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
