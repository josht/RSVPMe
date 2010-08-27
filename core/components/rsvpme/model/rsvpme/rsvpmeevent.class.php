<?php
/**
 * @package rsvpme
 */
class RSVPMeEvent extends xPDOSimpleObject {

    public function save() {
        
        /* when a new event is created, a new default RegType should be created
         * with it as well.
         */
        if ($this->isNew()) {
            $this->xpdo->log(MODx::LOG_LEVEL_INFO,'Creating default RegType');
            $regtype = $this->xpdo->newObject('RSVPMeRegType');
            $regtype->fromArray(array(
                'name' => 'default',
                'description' => 'default registration type',
                'code' => (isset($this->code)) ? $this->code : '',
                'fee' => (isset($this->fee)) ? $this->fee : '',
            ));

            $this->addMany($regtype);
        }

        /**
         * For now, only 1 registration type is allowed, so we will automatically
         * set the end date to the same as the date of the event. It will be set
         * independently in a future release.
         */
        if (!$this->isNew() && $this->isDirty('date')) {
            $regtypes = $this->getMany('RegistrationType');
            $regtype = array_pop($regtypes);
            $regtype->set('end',$this->get('date'));
        }

        /**
         * Since Registration Types will only be editable in a later version,
         * we need to make sure the 'secret code' stays synced
         */
        if (!$this->isNew() && (isset($this->code) || isset($this->fee))) {
            $regtypes = $this->getMany('RegistrationType');
            $regtype = array_pop($regtypes);

            if (isset($this->code)) {
                $regtype->set('code',$this->code);
            }
            if (isset($this->fee)) {
                $regtype->set('fee',$this->fee);
            }
        }

        /* now we can finish saving, this will also save related objects */
        return parent :: save();
    }
}