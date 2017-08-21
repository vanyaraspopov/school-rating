<?php
$xpdo_meta_map['srActivity']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_activities',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'description' => NULL,
    'auditory_age' => NULL,
    'auditory_sex' => NULL,
    'competencies' => NULL,
    'address' => NULL,
    'date' => NULL,
    'in_charge' => NULL,
    'published' => 0,
    'seats_limit' => 0,
    'section_id' => NULL,
    'coefficient_id' => NULL,
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
    'description' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1000',
      'phptype' => 'string',
      'null' => true,
    ),
    'auditory_age' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'auditory_sex' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => true,
    ),
    'competencies' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'address' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'in_charge' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => true,
    ),
    'published' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
    'seats_limit' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'section_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
    'coefficient_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
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
  'composites' => 
  array (
    'Users' => 
    array (
      'class' => 'modUser',
      'local' => 'id',
      'foreign' => 'activity_id',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
  ),
  'aggregates' => 
  array (
    'Section' => 
    array (
      'class' => 'srActivitySection',
      'local' => 'section_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
    'Coefficient' => 
    array (
      'class' => 'srActivityCoefficient',
      'local' => 'coefficient_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
  ),
);
