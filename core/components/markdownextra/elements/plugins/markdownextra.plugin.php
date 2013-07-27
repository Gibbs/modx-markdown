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

if($modx->context->key !== 'mgr' AND $modx->event->name == 'OnParseDocument')
{
	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/Markdown.php';
	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/MarkdownExtra.php';
	
	$enabled  = $modx->getOption('markdownextra.enabled');
	$mime_in  = $modx->getOption('markdownextra.mimemarkdown');
	$mime_out = $modx->getOption('markdownextra.mimeout');

	if($modx->resource->get('contentType') !== $mime_in OR !$enabled) return NULL;

	$output = NULL;

	$markdown = new MarkdownExtra();
	$output = $markdown::defaultTransform($modx->resource->getContent());

	$modx->resource->setContent($output);
	$modx->response->contentType->_fields['mime_type'] = $mime_out;
}

