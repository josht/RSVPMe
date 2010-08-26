<?php
/**
 * RSVPMe
 *
 * Copyright 2010 by Josh Tambunga <josh+rsvpme@joshsmind.com>
 *
 * RSVPMe is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * RSVPMe is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * RSVPMe; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package rsvpme
 */
/**
 * Properties for the RSVPMe snippet.
 *
 * @package rsvpme
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'prop_rsvpme.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'Item',
        'lexicon' => 'rsvpme:properties',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'prop_rsvpme.sortby_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'name',
        'lexicon' => 'rsvpme:properties',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'prop_rsvpme.sortdir_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'ASC',
        'lexicon' => 'rsvpme:properties',
    ),
    array(
        'name' => 'limit',
        'desc' => 'prop_rsvpme.limit_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 5,
        'lexicon' => 'rsvpme:properties',
    ),
    array(
        'name' => 'outputSeparator',
        'desc' => 'prop_rsvpme.outputseparator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'rsvpme:properties',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'prop_rsvpme.toplaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => true,
        'lexicon' => 'rsvpme:properties',
    ),
/*
    array(
        'name' => '',
        'desc' => 'prop_rsvpme.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'rsvpme:properties',
    ),
    */
);

return $properties;