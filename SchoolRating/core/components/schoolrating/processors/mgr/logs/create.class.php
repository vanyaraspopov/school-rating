<?php

class srLogCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srLog';
    public $classKey = 'srLog';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $username = trim($this->getProperty('username'));
        if (empty($username)) {
            $this->modx->error->addField('username', $this->modx->lexicon('schoolrating_logs_err_username_ns'));
        }
        $action = trim($this->getProperty('action'));
        if (empty($action)) {
            $this->modx->error->addField('action', $this->modx->lexicon('schoolrating_logs_err_action_ns'));
        }
        $date = trim($this->getProperty('date'));
        if (empty($date)) {
            $this->modx->error->addField('date', $this->modx->lexicon('schoolrating_logs_err_datetime_ns'));
        }
        $ipaddress = trim($this->getProperty('ipaddress'));
        if (empty($ipaddress)) {
            $this->modx->error->addField('ipaddress', $this->modx->lexicon('schoolrating_logs_err_ip_ns'));
        }
        return parent::beforeSet();
    }

}

return 'srLogCreateProcessor';