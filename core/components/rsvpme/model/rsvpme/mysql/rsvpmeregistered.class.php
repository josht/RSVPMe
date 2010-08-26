<?php
/**
 * @package rsvpme
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/rsvpmeregistered.class.php');
class RSVPMeRegistered_mysql extends RSVPMeRegistered {}
?>