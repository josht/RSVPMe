<?php
/*
 * @package rsvpme
 */
/**
 * Create an RSVPMe Event
 *
 * @package rsvpme
 * @subpackage processors
 */
$modx->log(MODx::LOG_LEVEL_INFO, 'Starting creation processor for RSVPMe Events.');
$alreadyExists = $modx->getObject('RSVPMeEvent',array(
    'name'  => $_POST['name'],
));
if ($alreadyExists) {
    $modx->error->addField('name',$modx->lexicon('rsvpme.event_err_ae'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$event = $modx->newObject('RSVPMeEvent');
$event->fromArray($_POST);

if ($event->save() == false) {
    return $modx->error->failure($modx->lexicon('rsvpme.event_err_save'));
}

return $modx->error->success('',$event);