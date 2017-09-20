<?php
$xpdo_meta_map['srActivitiesSnapshot']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_activities_snapshots',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'date' => NULL,
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
    'filepath' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '400',
      'phptype' => 'string',
      'true' => 'false',
    ),
  ),
);
