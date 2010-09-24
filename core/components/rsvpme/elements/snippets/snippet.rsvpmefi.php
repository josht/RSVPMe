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
 * Custom hook for FormIt to integrate RSVPMe. Simply call this as a hook in your
 * FormIt call.
 *
 * @package rsvpme
 */
require_once $modx->getOption('rsvpme.core_path',null,$modx->getOption('core_path').'components/rsvpme/').'model/rsvpme/rsvpme.class.php';
$rsvpme = new RSVPMe($modx);
$rsvpme->initialize($modx->context->get('key'));
$fields = $scriptProperties['fields'];

// if an event code is supplied, we verify the code, and then can redirect
if (isset($fields['code'])) {
    $modx->log(MODx::LOG_LEVEL_INFO,'Code field found, checking if valid.');
    $regType = $modx->getObject('RSVPMeRegType',array('code' => $fields['code']));

    if (!$regType) {
        $scriptProperties['hook']->errors['code'] = 'Invalid event code specified.';
        return false;
    }

    if (strtotime($regType->end) <= time()) {
        $scriptProperties['hook']->errors['code'] = 'That event code is no longer valid.';
        return false;
    }
}
return true;