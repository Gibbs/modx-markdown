<?php
/**
 * snippets transport file for MarkdownExtra extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 10-19-2013
 *
 * @package markdownextra
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $snippets */


$snippets = array();

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->fromArray(array (
  'id' => 1,
  'description' => 'MarkdownExtra snippet and output filter.',
  'name' => 'MarkdownExtra',
), '', true, true);
$snippets[1]->setContent(file_get_contents($sources['source_core'] . '/elements/snippets/markdownextra.snippet.php'));

return $snippets;
