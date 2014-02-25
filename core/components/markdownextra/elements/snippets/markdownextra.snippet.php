<?php
/**
 * MarkdownExtra snippet for MarkdownExtra extra
 *
 * Copyright (C) Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 07-31-2013
 *
 * MarkdownExtra is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * MarkdownExtra is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MarkdownExtra; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package  markdownextra
 * @author   Dan Gibbs  
 */

$output  = NULL;
$content = NULL;

array_change_key_case($scriptProperties, CASE_LOWER);

// Output Modifier
if( isset($input) )
	$content = $input;

// Snippet
if( isset($scriptProperties['content'])) {
	$content = $scriptProperties['content'];
}

if( $content !== NULL) {
	require_once $modx->getOption('core_path') . 
		'components/markdownextra/vendor/MarkdownExtra/Markdown.php';
	require_once $modx->getOption('core_path') . 
		'components/markdownextra/vendor/MarkdownExtra/MarkdownExtra.php';
	
	$markdown = new MarkdownExtra();
	$output = $markdown::defaultTransform($content);
}

return $output;
