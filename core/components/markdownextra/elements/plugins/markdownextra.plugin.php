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

require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/Markdown.php';

if($modx->context->key !== 'mgr' AND $modx->event->name == 'OnParseDocument')
{
	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/Markdown.php';
	$enabled  = $modx->getOption('markdownextra.enabled');
	$mime_in  = $modx->getOption('markdownextra.mime_markdown');
	$mime_out = $modx->getOption('markdownextra.mime_out');

	if($modx->resource->get('contentType') !== $mime_in OR !$enabled) return NULL;

	$output = NULL;
	$id = $modx->resource->id;
	$cacheable = $modx->resource->get('cacheable');

	if($cacheable) {
		$cache_opts = array(xPDO::OPT_CACHE_KEY => 'includes/elements/markdown');
		$output = $modx->cacheManager->get($id, $cache);
	}
	
	if( empty($output) ) {
		$markdown = new Markdown();
		$output = $markdown::defaultTransform($modx->resource->getContent());

		if($cacheable)
			$modx->cacheManager->set($id, $output, 0, $cache_opts);
	}

	$modx->resource->setContent($output);
	$modx->response->contentType->_fields['mime_type'] = $mime_out;
}
