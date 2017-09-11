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

        return parent::beforeSet();
    }

}

return 'srActivityParticipant';