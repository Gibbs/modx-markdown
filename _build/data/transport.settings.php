<?php
/**
 * systemSettings transport file for Markdown extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 10-19-2013
 *
 * @package markdown
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
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key'         => 'markdown.mimeout',
  'value'       => 'text/html',
  'xtype'       => 'textfield',
  'namespace'   => 'markdown',
  'area'        => 'System and Server',
  'name'        => 'Output MIME Type',
  'description' => 'The MIME type to output for Markdown documents.',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key'        => 'markdown.mimemarkdown',
  'value'       => 'text/x-markdown',
  'xtype'       => 'textfield',
  'namespace'   => 'markdown',
  'area'        => 'System and Server',
  'name'        => 'Markdown MIME Type',
  'description' => 'The Markdown MIME type set for the MODX Content Type',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key'         => 'markdown.enabled',
  'value'       => '1',
  'xtype'       => 'combo-boolean',
  'namespace'   => 'markdown',
  'area'        => 'Plugin',
  'name'        => 'Enabled',
  'description' => 'Enable Markdown',
), '', true, true);

return $systemSettings;
