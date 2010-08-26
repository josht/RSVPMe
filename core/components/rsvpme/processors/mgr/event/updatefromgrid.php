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
 * Update an event from the grid
 *
 * @package rsvpme
 * @subpackage processors
 */
/* parse the JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');

/* get obj*/
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('rsvpme.event_err_ns'));
$event = $modx->getObject('RSVPMeEvent',$_DATA['id']);
if(empty($event)) return $modx->error->failure($modx->lexicon('rsvpme.event_err_nf'));

$event->fromArray($_DATA);

/* save */
if ($event->save() == false) {
    return $modx->error->failure($modx->lexicon('rsvpme.event_err_save'));
}

return $modx->error->success('',$event);