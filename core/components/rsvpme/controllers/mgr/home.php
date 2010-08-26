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
 * Loads the home page.
 *
 * @package rsvpme
 * @subpackage controllers
 */
//$modx->regClientStartupScript($RSVPMe->config['jsUrl'].'mgr/widgets/items.grid.js');
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/modext/util/datetime.js');
$modx->regClientStartupScript($RSVPMe->config['jsUrl'].'mgr/widgets/events.grid.js');
$modx->regClientStartupScript($RSVPMe->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($RSVPMe->config['jsUrl'].'mgr/sections/home.js');
$output = '<div id="rsvpme-panel-home-div"></div>';

return $output;