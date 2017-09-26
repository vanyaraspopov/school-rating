<?php
$xpdo_meta_map['srUserRatingReportUsers']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_userextra_rating_report_users',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'report_id' => NULL,
    'user_id' => NULL,
    'rating' => 0,
    'rating_position' => NULL,
  ),
  'fieldMeta' => 
  array (
    'report_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
    'rating' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '10,2',
      'phptype' => 'double',
      'null' => false,
      'default' => 0,
    ),
    'rating_position' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
  ),
  'aggregates' => 
  array (
    'Report' => 
    array (
      'class' => 'srActivitySection',
      'local' => 'report_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'user_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
  ),
);
