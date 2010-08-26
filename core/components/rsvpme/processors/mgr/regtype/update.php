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
 * Update a Registration Type
 *
 * @package rsvpme
 * @subpackage processors
 */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicion('rsvpme.regtype_err_ns'));
$regtype = $modx->getObject('RSVPMeRegType',$scriptProperties['id']);
if (!$regtype) return $modx->error->failure($modx->lexicion('rsvpme.regtype_err_nf'));

$regtype->fromArray($scriptProperties);

if ($regtype->save() == false) {
    return $modx->error->failure($modx->lexicon('rsvpme.regtype_err_save'));
}

/* output */
$regtypeArray = $regtype->toArray('',true);
return $modx->error->success('',$regtypeArray);
