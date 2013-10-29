<?php
/**
 * MarkdownExtra plugin for MarkdownExtra extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 27-07-2013
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

// Plugin events
$events = array(
	'OnBeforeDocFormSave',
	'OnDocFormRender',
	'OnDocFormSave',
	'OnResourceDuplicate',
	'OnLoadWebDocument',
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
 * OnDocFormSave
 *
 * FIXME: Expect this to be unreliable
 */
if($modx->event->name == 'OnDocFormSave' AND $resource->contentType == $mime_in AND $mode == 'new')
{
	$md = $modx->getObject('modMarkdownextra', array('document' => 0));
	$md->set('document', $id);
	$md->save();
}

/**
 * OnResourceDuplicate
 */
if($modx->event->name == 'OnResourceDuplicate')
{
	$id = $oldResource->get('id');
	$md_old = $modx->getObject('modMarkdownextra', array('document' => $id));

	$md_new = $modx->newObject('modMarkdownextra', array(
		'document' => $newResource->get('id'), // New resource ID
		'content'  => $md_old->get('content'),
	));

	$md_new->save();
}

/**
 * OnDocFormRender
 *
 * Display Markdown as resource content
 */
if($modx->event->name == 'OnDocFormRender' AND $resource->contentType == $mime_in)
{
	$md = $modx->getObject('modMarkdownextra', array('document' => $id));

	if($md) {
		$resource->content = $md->get('content');
	}
}

/**
 * OnLoadWebDocument- Change content type
 *
 * FIXME: A better approach
 */
if($modx->event->name == 'OnLoadWebDocument' AND $mime_in !== $mime_out)
{
	$modx->resource->ContentType->set('mime_type', $mime_out);
}
