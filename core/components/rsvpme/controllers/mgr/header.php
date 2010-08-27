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
 * Loads the header for mgr pages.
 *
 * @package rsvpme
 * @subpackage controllers
 */
$modx->regClientCSS($RSVPMe->config['cssUrl'].'mgr.css');
$modx->regClientStartupScript($RSVPMe->config['jsUrl'].'mgr/rsvpme.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    RSVPMe.config = '.$modx->toJSON($RSVPMe->config).';
    RSVPMe.config.connector_url = "'.$RSVPMe->config['connectorUrl'].'";
    RSVPMe.action = "'.(!empty($_REQUEST['a']) ? $_REQUEST['a'] : 0).'";
    RSVPMe.request = '.$modx->toJSON($_GET).';
});
</script>');

return '';