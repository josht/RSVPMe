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
 * Get an Event
 *
 * @package rsvpme
 * @subpackage processors
 */
/* get board */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('rsvpme.event_err_ns'));
$event = $modx->getObject('RSVPMeEvent',$scriptProperties['id']);
if (!$event) return $modx->error->failure($modx->lexicon('rsvpme.event_err_nf'));

/* output */
$eventArray = $event->toArray('', true);

/* this is only here until registration types are editable on their own */
$regtype = $event->getMany('RegistrationType');
$regtype = array_pop($regtype);
$regtypeArray = $regtype->toArray();
$eventArray = array_merge($regtypeArray,$eventArray);

return $modx->error->success('',$eventArray);