<?php
/**
 * @package rsvpme
 */
class RSVPMeRegType extends xPDOSimpleObject {
    
    public function save($cacheFlag = null) {

        /* if the start datetime is empty, should default to right now */
        if (empty($this->start)) {
            $this->start = date("Y-m-d H:i:s");
        }

        /* if the end datetime is empty, shoud default to datetime of its parent event */
        if (empty($this->end)) {
            $event = $this->getOne('Event');
            $this->end = $event->date;
        }

        return parent :: save($cacheFlag);
    }
}