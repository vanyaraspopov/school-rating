<?php

class srActivityParticipantCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srActivityParticipant';
    public $classKey = 'srActivityParticipant';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $user_id = trim($this->getProperty('user_id'));
        if (empty($user_id)) {
            $this->modx->error->addField('user_id', $this->modx->lexicon('schoolrating_activity_participant_err_user_ns'));
        }

        $resource_id = trim($this->getProperty('resource_id'));
        if (empty($resource_id)) {
            $this->modx->error->addField('resource_id', $this->modx->lexicon('schoolrating_activity_participant_err_resource_ns'));
        }

        if ($this->modx->getCount($this->classKey, [
            'user_id' => $user_id,
            'resource_id' => $resource_id
        ])) {
            $this->modx->error->addError($this->modx->lexicon('schoolrating_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'srActivityParticipantCreateProcessor';