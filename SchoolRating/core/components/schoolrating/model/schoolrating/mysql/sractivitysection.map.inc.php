<?php
$xpdo_meta_map['srActivitySection']= array (
  'package' => 'schoolrating',
  'version' => '1.1',
  'table' => 'schoolrating_activity_sections',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'usergroup_id' => NULL,
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
    'usergroup_id' => 
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
    'Activities' => 
    array (
      'class' => 'srActivity',
      'local' => 'id',
      'foreign' => 'section_id',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
    'UserRatings' => 
    array (
      'class' => 'srUserRating',
      'local' => 'id',
      'foreign' => 'section_id',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
  ),
  'aggregates' => 
  array (
    'ModeratorsGroup' => 
    array (
      'class' => 'modUserGroup',
      'local' => 'usergroup_id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
  ),
);
