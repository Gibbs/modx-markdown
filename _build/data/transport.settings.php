<?php
/**
 * systemSettings transport file for MarkdownExtra extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 07-27-2013
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
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'markdownextra.enabled',
  'name' => 'Enabled',
  'description' => 'Enable Markdown',
  'namespace' => 'markdownextra',
  'xtype' => 'combo-boolean',
  'value' => 1,
  'area' => 'Plugin',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'markdownextra.mimemarkdown',
  'name' => 'Markdown MIME Type',
  'description' => 'The Markdown MIME type set for the MODX Content Type',
  'namespace' => 'markdownextra',
  'xtype' => 'textfield',
  'value' => 'text/markdown',
  'area' => 'System and Server',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'markdownextra.mimeout',
  'name' => 'Output MIME Type',
  'description' => 'The MIME type to output for Markdown related documents.',
  'namespace' => 'markdownextra',
  'xtype' => 'textfield',
  'value' => 'text/html',
  'area' => 'System and Server',
), '', true, true);
return $systemSettings;
