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
 * Get a list of people registered for an event.
 *
 * @package rsvpme
 * @subpackage processors
 */
if (empty($scriptProperties['event'])) return $modx->error->failure($modx->lexicon('rsvpme.event_err_ns'));

$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start',$_REQUEST,0);
$limit = $modx->getOption('limit',$_REQUEST,20);
$sort = $modx->getOption('sort',$_REQUEST,'date');
$dir = $modx->getOption('dir',$_REQUEST,'ASC');

$c = $modx->newQuery('RSVPMeRegistered');
$c->where(array('event' => $scriptProperties['event']));
$count = $modx->getCount('RSVPMeRegistered',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$registered = $modx->getCollection('RSVPMeRegistered',$c);

$list = array();
foreach ($registered as $reg) {
    $regArray = $reg->toArray();
    $list[] = $regArray;
}
return $this->outputArray($list,$count);