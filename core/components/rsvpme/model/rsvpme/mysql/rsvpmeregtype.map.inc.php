<?php
/**
 * @package rsvpme
 */
$xpdo_meta_map['RSVPMeRegType']= array (
  'package' => 'rsvpme',
  'table' => 'rsvpme_registration_types',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
    'start' => NULL,
    'end' => NULL,
    'code' => '',
    'fee' => 0,
    'event' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'start' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'end' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'code' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'fee' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '6,2',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'event' => 
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'aggregates' => 
  array (
    'Event' => 
    array (
      'class' => 'RSVPMeEvent',
      'local' => 'event',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
