<?php
$xpdo_meta_map['srUserRatingReport']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_userextra_rating_report',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'date_start' => NULL,
    'date_end' => NULL,
    'date' => NULL,
    'count' => 0,
    'comment' => '',
  ),
  'fieldMeta' => 
  array (
    'date_start' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => false,
    ),
    'date_end' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => false,
    ),
    'date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => false,
    ),
    'count' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'comment' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
  'composites' => 
  array (
    'Users' => 
    array (
      'class' => 'srUserRatingReportUsers',
      'local' => 'id',
      'foreign' => 'report_id',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
  ),
);
