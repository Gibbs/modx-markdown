<?php
$xpdo_meta_map['modMarkdown']= array (
  'package' => 'markdown',
  'version' => '1.0',
  'table' => 'markdown_data',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'document' => 0,
    'content' => '',
  ),
  'fieldMeta' => 
  array (
    'document' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'content' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
);
