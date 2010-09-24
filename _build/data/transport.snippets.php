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
 * Add snippets to build
 * 
 * @package rsvpme
 * @subpackage build
 */
$snippets = array();
/*
$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'RSVPMe',
    'description' => 'Displays Items.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.rsvpme.php'),
),'',true,true);
$properties = include $sources['build'].'properties/properties.rsvpme.php';
$snippets[0]->setProperties($properties);
unset($properties);
*/
$snippets[0] = $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id'            => 0,
    'name'          => 'RSVPMe',
    'description'   => 'Allows guests to RSVP for events you have created in the manager.',
    'snippet'       => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.rsvpme.php'),
),'',true,true);
$properties = include $sources['build'].'properties/properties.rsvpme.php';
$snippets[0]->setProperties($properties);
unset($properties);

return $snippets;