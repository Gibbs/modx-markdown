<?php
/**
 * MarkdownExtra plugin for MarkdownExtra extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 07-27-2013
 *
 * MarkdownExtra is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * MarkdownExtra is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MarkdownExtra; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package    markdownextra
 * @author     Dan Gibbs  
 */

//ini_set('display_errors', 'on'); error_reporting(E_ALL);
//$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

// Plugin events
$events = array(
	'OnDocFormRender',
	'OnBeforeDocFormSave',
	'OnWebPagePrerender',
);

if( !in_array($modx->event->name, $events) )
	return NULL;

$mime_in  = $modx->getOption('markdownextra.mimemarkdown');
$mime_out = $modx->getOption('markdownextra.mimeout');

$modx->addPackage('markdownextra', MODX_CORE_PATH . 'components/markdownextra/model/');
require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/Markdown.php';
require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/MarkdownExtra.php';

/**
 * OnBeforeDocFormSave
 */
if($modx->event->name == 'OnBeforeDocFormSave' AND $resource->contentType == $mime_in)
{
	// Save the Markdown
	$md = $modx->getObject('modMarkdownextra', array('document' => $id));

	if(!$md) {
		$md = $modx->newObject('modMarkdownextra', array(
			'document' => $id,
			'content' => $resource->getContent(),
		));
	}

	$md->set('document', $id);
	$md->set('content', $resource->getContent());
	$md->save();

	// Set document output to parsed Markdown
	$markdown = new MarkdownExtra();
	$output = $markdown::defaultTransform($resource->getContent());

	$resource->content = $output;
}

/**
 * OnDocFormRender
 */
if($modx->event->name == 'OnDocFormRender' AND $resource->contentType == $mime_in)
{
	// Load document Markdown
	$md = $modx->getObject('modMarkdownextra', array('document' => $id));

	if($md) {
		$resource->content = $md->get('content');
	}
}

/**
 * OnWebPagePrerender
 *
 * FIXME: A more efficient approach
 */

if($modx->event->name == 'OnWebPagePrerender' AND $mime_in !== $mime_out)
{
	// Change content type
	$modx->resource->ContentType->set('mime_type', $mime_out);
}
