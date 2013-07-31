<?php
/**
 * MarkdownExtra snippet for MarkdownExtra extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 07-31-2013
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
 * @package markdownextra
 */

// Output filter
if( isset($input) ) {

	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/Markdown.php';
	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/MarkdownExtra.php';
	
	$output = NULL;
	$markdown = new MarkdownExtra();
	$output = $markdown::defaultTransform($input);
	
	return $output;
}

// Snippet
if( array_change_key_case($scriptProperties, CASE_LOWER) AND isset($scriptProperties['content']) ) {

	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/Markdown.php';
	require_once $modx->getOption('core_path') . 'components/markdownextra/vendor/markdown/MarkdownExtra.php';
	
	$output = NULL;
	$markdown = new MarkdownExtra();
	$output = $markdown::defaultTransform($scriptProperties['content']);
	
	return $output;
}

return NULL;
