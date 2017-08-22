<?php
$xpdo_meta_map['srActivityCoefficient']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_activity_coefficients',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'value' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'value' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '10,2',
      'phptype' => 'double',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'name' => 
    array (
      'alias' => 'name',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'name' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Activities' => 
    array (
      'class' => 'srActivity',
      'local' => 'id',
      'foreign' => 'coefficient_id',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
  ),
);
