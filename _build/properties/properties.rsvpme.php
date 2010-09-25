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
        'name'      => 'outterTpl',
        'desc'      => 'prop_rsvpme.outtertpl_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'outertpl',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'codeTpl',
        'desc'      => 'prop_rsvpme.codetpl_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'codetpl',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'listTpl',
        'desc'      => 'prop_rsvpme.listtple_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'listtpl',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'regTpl',
        'desc'      => 'prop_rsvpme.regtpl_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'regtpl',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'regFormTpl',
        'desc'      => 'prop_rsvpme.regformtpl_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'regform',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'feeFormTpl',
        'desc'      => 'prop_rsvpme.regformtpl_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'freeform',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'regSuccessTpl',
        'desc'      => 'prop_rsvpme.regformtpl_desc',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'regsuccess',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'showCode',
        'desc'      => 'prop_rsvpme.showcode_desc',
        'type'      => 'combo-boolean',
        'options'   => '',
        'value'     => '1',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'showList',
        'desc'      => 'prop_rsvpme.showlist_desc',
        'type'      => 'combo-boolean',
        'options'   => '',
        'value'     => '0',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'regWithoutFee',
        'desc'      => 'prop_rsvpme.regwithoutfee_desc',
        'type'      => 'combo-boolean',
        'options'   => '',
        'value'     => '0',
        'lexicon'   => 'rsvpme:properties',
    ),
    array(
        'name'      => 'confirmEmailTpl',
        'desc'      => 'prop_rsvpme.confirmemailtpl',
        'type'      => 'textfield',
        'options'   => '',
        'value'     => 'confirmemailtpl',
        'lexicon'   => 'rsvpme:properties',
    )
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