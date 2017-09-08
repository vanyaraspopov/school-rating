<?php
$xpdo_meta_map['srUserRating']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_userextra_rating',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'user_id' => NULL,
    'section_id' => NULL,
    'comment' => '',
    'date' => NULL,
    'rating' => 0,
  ),
  'fieldMeta' => 
  array (
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
    'section_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'comment' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => false,
    ),
    'rating' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'true' => 'false',
      'default' => 0,
    ),
  ),
  'aggregates' => 
  array (
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'user_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
    'Section' => 
    array (
      'class' => 'srActivitySection',
      'local' => 'section_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
  ),
);
