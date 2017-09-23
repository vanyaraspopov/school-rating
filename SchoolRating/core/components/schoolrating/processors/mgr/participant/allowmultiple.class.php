<?php

class srActivityParticipantAllowMultipleProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'srActivityParticipant';
    public $classKey = 'srActivityParticipant';
    public $languageTopics = array('schoolrating');
    /** @var string $afterSaveEvent The name of the event to fire after saving */
    public $afterSaveEvent = 'srOnParticipationAllow';
    //public $permission = 'remove';

    /**
     * Can be used to provide custom methods prior to processing. Return true to tell MODX that the Processor
     * initialized successfully. If you return anything else, MODX will output that return value as an error message.
     *
     * @return boolean
     */
    public function initialize() { return true; }

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = explode(',', $this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('schoolrating_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var srActivityParticipant $this->object */
            if (!$this->object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('schoolrating_item_err_nf'));
            }

            $this->object->set('allowed', 1);
            if ($this->object->save()) {
                $this->fireAfterSaveEvent();
            }
        }

        return $this->success();
    }

}

return 'srActivityParticipantAllowMultipleProcessor';