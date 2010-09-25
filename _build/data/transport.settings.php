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
 * Loads system settings into build
 *
 * @package rsvpme
 * @subpackage build
 */
$settings = array();

/*
$settings['gallery.']= $modx->newObject('modSystemSetting');
$settings['gallery.']->fromArray(array(
    'key' => 'gallery.',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'gallery',
    'area' => '',
),'',true,true);
*/
$settings['rsvpme.emailFrom'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.emailFrom']->fromArray(array(
    'key'       => 'rsvpme.emailFrom',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'email',
),'',true,true);
$settings['rsvpme.emailCC'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.emailCC']->fromArray(array(
    'key'       => 'rsvpme.emailCC',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'email',
),'',true,true);
$settings['rsvpme.emailBCC'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.emailBCC']->fromArray(array(
    'key'       => 'rsvpme.emailBCC',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'email',
),'',true,true);
$settings['rsvpme.paypal_cert_chain'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.paypal_cert_chain']->fromArray(array(
    'key'       => 'rsvpme.paypal_cert_chain',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'payment',
),'',true,true);

$settings['rsvpme.paypal_environment'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.paypal_environment']->fromArray(array(
    'key'       => 'rsvpme.paypal_environment',
    'value'     => 'sandbox',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'payment',
),'',true,true);

$settings['rsvpme.paypal_password'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.paypal_password']->fromArray(array(
    'key'       => 'rsvpme.paypal_password',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'payment',
),'',true,true);

$settings['rsvpme.paypal_cert'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.paypal_cert']->fromArray(array(
    'key'       => 'rsvpme.paypal_cert',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'payment',
),'',true,true);

$settings['rsvpme.paypal_signature'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.paypal_signature']->fromArray(array(
    'key'       => 'rsvpme.paypal_signature',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'payment',
),'',true,true);

$settings['rsvpme.paypal_username'] = $modx->newObject('modSystemSetting');
$settings['rsvpme.paypal_username']->fromArray(array(
    'key'       => 'rsvpme.paypal_username',
    'value'     => '',
    'xtype'     => 'textfield',
    'namespace' => 'rsvpme',
    'area'      => 'payment',
),'',true,true);

return $settings;