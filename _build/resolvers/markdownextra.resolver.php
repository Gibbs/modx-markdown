<?php
/**
 * Resolver for Markdown extra
 *
 * Copyright Gold Coast Media 2013 by Dan Gibbs <dan@goldcoastmedia.co.uk>
 * Created on 07-27-2013
 *
 * Markdown is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Markdown is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Markdown; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * @package    markdown
 * @subpackage build
 */

/* @var $object xPDOObject */
/* @var $modx modX */

/* @var array $options */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        	
			// Check a MIME type exists
			$markdown_mime = $modx->getObject('modContentType', array('mime_type' => 'text/markdown'));

			if(!$markdown_mime) {
				$modx->log(xPDO::LOG_LEVEL_INFO, 'Creating Markdown Content Type');
				$content_type = $modx->newObject('modContentType', array(
					'name'            => 'Markdown',
					'description'     => 'Markdown content',
					'mime_type'       => 'text/markdown',
					'file_extensions' => NULL,
					'headers'         => NULL,
					'binary'          => '0',
				));
	
				$content_type->save();
			}

			// Model
			$modx =& $object->xpdo;
            $modx->addPackage('markdown', MODX_CORE_PATH . 'components/markdown/model/');
            $manager = $modx->getManager();
            $manager->createObjectContainer('modMarkdown');

        	break;
        case xPDOTransport::ACTION_UPGRADE:
            /* [[+code]] */
            
            
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;
