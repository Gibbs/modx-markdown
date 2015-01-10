Markdown for MODX Revolution
============================

Write MODX documents in Markdown. 

## Installation

Install via the MODX package manager at ```Extras > Installer``` by searching
for ```markdown```.

## Documentation

Full detailed documentation on using Markdown in MODX with this extension is 
available at: <URL>

...

## How it works

When a MODX document is saved with the 'Markdown' content type this extension will:

- Save your markdown in a separate database table
- Save the document as parsed HTML

This allows MODX documents to work as normal even if the extension is disabled or uninstalled.

## MODX Chunks and Snippets

To use chunks and snippets wrap them with a HTML element.

~~~
<span>[[$chunk]]</span>
~~~

~~~
<div>[[!MySnippet? &something=`something`]]</div>
~~~

## Using HTML

The parser will ignore anything inside HTML tags. For example:

~~~language-html
**some** markdown

<div id="something">
	<ol>
		<li>Item</li>
	</ol>
</div>

**continued** markdown
~~~

## Mixing HTML and Markdown

Markdown can be used inside HTML with the special ```markdown="1"``` attribute. Example:

~~~language-html
**some** markdown

<div id="something">
    <span>## Heading 2</span>

    <span markdown="1">## Heading 2</span>
</div>

**continued** markdown
~~~

## Credits

This extension uses the 
'[PHP Markdown](http://michelf.ca/projects/php-markdown/)' parser by 
Michel Fortin.
