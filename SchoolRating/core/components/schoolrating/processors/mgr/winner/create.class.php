<?php

class srActivityWinnerCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srActivityWinner';
    public $classKey = 'srActivityWinner';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $user_id = trim($this->getProperty('user_id'));
        if (empty($user_id)) {
            $this->modx->error->addField('user_id', $this->modx->lexicon('schoolrating_winner_err_user_ns'));
        }

        $resource_id = trim($this->getProperty('resource_id'));
        if (empty($resource_id)) {
            $this->modx->error->addField('resource_id', $this->modx->lexicon('schoolrating_winner_err_resource_ns'));
        }

        $place = trim($this->getProperty('place'));
        if (empty($place)) {
            $this->modx->error->addField('place', $this->modx->lexicon('schoolrating_winner_err_place_ns'));
        }

        $mySqlDateFormat = 'Y-m-d H:i:s';
        $this->setProperty('date', date($mySqlDateFormat));

        return parent::beforeSet();
    }

}

return 'srActivityWinnerCreateProcessor';