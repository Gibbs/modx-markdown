<?php
/**
 * Markdown plugin for Markdown
 *
 * Copyright (C) Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 07-31-2013
 *
 * Markdown is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Markdown is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Markdown; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package  markdown
 * @author   Dan Gibbs
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

$modx->addPackage(
	'markdown',
	MODX_CORE_PATH . 'components/markdown/model/'
);

$mime_in  = $modx->getOption('markdown.mimemarkdown');
$mime_out = $modx->getOption('markdown.mimeout');

/**
 * OnBeforeDocFormSave
 */
if($modx->event->name == 'OnBeforeDocFormSave' AND $resource->contentType == $mime_in)
{
	// Save the Markdown
	$md = $modx->getObject('modMarkdown', array('document' => $id));

	if(!$md) {
		$md = $modx->newObject('modMarkdown', array(
			'document' => $id,
			'content' => $resource->getContent(),
		));
	}

	$md->set('document', $id);
	$md->set('content', $resource->getContent());
	$md->save();

	// Set document output to parsed Markdown
	require_once $modx->getOption('core_path') .
		'components/markdown/vendor/autoload.php';

	$markdown = new \Michelf\MarkdownExtra\MarkdownExtra();
	$output = $markdown->transform($resource->getContent());

	$resource->content = $output;
}

/**
 * OnDocFormSave
 *
 * FIXME: Expect this to be unreliable
 */
if($modx->event->name == 'OnDocFormSave' AND $resource->contentType == $mime_in AND $mode == 'new')
{
	$md = $modx->getObject('modMarkdown', array('document' => 0));
	$md->set('document', $id);
	$md->save();
}

/**
 * OnResourceDuplicate
 */
if($modx->event->name == 'OnResourceDuplicate')
{
	$id = $oldResource->get('id');
	$md_old = $modx->getObject('modMarkdown', array('document' => $id));

	$md_new = $modx->newObject('modMarkdown', array(
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
	$md = $modx->getObject('modMarkdown', array('document' => $id));

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
