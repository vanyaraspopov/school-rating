<?php
$xpdo_meta_map['vpPhone']= array (
  'package' => 'verifyphone',
  'version' => '1.1',
  'table' => 'vp_phones',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'phone' => NULL,
    'code' => NULL,
    'verified' => 0,
  ),
  'fieldMeta' => 
  array (
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
    ),
    'code' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => false,
    ),
    'verified' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'phone' => 
    array (
      'alias' => 'phone',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'phone' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
