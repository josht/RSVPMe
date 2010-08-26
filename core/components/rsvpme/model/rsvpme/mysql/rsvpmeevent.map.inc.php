<?php
/**
 * @package rsvpme
 */
$xpdo_meta_map['RSVPMeEvent']= array (
  'package' => 'rsvpme',
  'table' => 'rsvpme_events',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
    'date' => NULL,
    'link' => '',
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
    'date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'link' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'composites' => 
  array (
    'RegistrationType' => 
    array (
      'class' => 'RSVPMeRegType',
      'local' => 'id',
      'foreign' => 'event',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Registered' => 
    array (
      'class' => 'RSVPMeRegistered',
      'local' => 'id',
      'foreign' => 'event',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
