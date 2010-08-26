<?php
/**
 * @package rsvpme
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/rsvpmeregtype.class.php');
class RSVPMeRegType_mysql extends RSVPMeRegType {}
?>