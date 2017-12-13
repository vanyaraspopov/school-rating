<?php
$xpdo_meta_map['srActivitiesSnapshot']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_activities_snapshots',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'date' => NULL,
    'comment' => NULL,
    'filepath' => NULL,
  ),
  'fieldMeta' => 
  array (
    'date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => false,
    ),
    'comment' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1000',
      'phptype' => 'string',
      'null' => false,
    ),
    'filepath' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '400',
      'phptype' => 'string',
      'null' => false,
    ),
  ),
);
