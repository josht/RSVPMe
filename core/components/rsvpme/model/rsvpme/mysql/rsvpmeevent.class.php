<?php
/**
 * @package rsvpme
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/rsvpmeevent.class.php');
class RSVPMeEvent_mysql extends RSVPMeEvent {}
?>