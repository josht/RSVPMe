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
 * Build the setup options form.
 *
 * @package rsvpme
 * @subpackage build
 */
/* setup default values */
$values = array(
    'emailFrom' => 'rsvp@domain.com',
    'emailCC'   => 'rsvp@domain.com',
    'emailBCC'  => 'rsvp@domain.com',
);
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $setting = $modx->getObject('modSystemSetting',array('key' => 'rsvpme.emailFrom'));
        if ($setting != nul) { $values['emailFrom'] = $setting->get('value'); }
        unset($setting);

        $setting = $modx->getObject('modSystemSetting',array('key' => 'rsvpme.emailCC'));
        if ($setting != null) { $values['emailCC'] = $setting->get('value'); }
        unset($setting);

        $setting = $modx->getObject('modSystemSetting',array('key' => 'rsvpme.emailBCC'));
        if ($setting != null) { $values['emailBCC'] = $setting->get('value'); }
        unset($setting);
    break;
    case xPDOTransport::ACTION_UNINSTALL: break;
}

$output = '<label for="rsvpme-emailFrom">Emails From:</label>
<input type="text" name="emailFrom" id="rsvpme-emailFrom" width="300" value="'.$values['emailFrom'].'" />
<br /><br />

<label for="rsvpme-emailCC">Email CC:</label>
<input type="text" name="emailCC" id="rsvpme-emailCC" width="300" value="'.$values['emailCC'].'" />
<br /><br />

<label for="rsvpme-emailBCC">Email BCC:</label>
<input type="text" name="emailBCC" id="rsvpme-emailBCC" width="300" value="'.$values['emailBCC'].'" />';

return $output;