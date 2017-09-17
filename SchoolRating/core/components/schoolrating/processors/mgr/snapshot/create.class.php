<?php

class srActivitiesSnapshotCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srActivitiesSnapshot';
    public $classKey = 'srActivitiesSnapshot';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $mySqlDateFormat = 'Y-m-d H:i:s';
        $this->setProperty('date', date($mySqlDateFormat));

        return parent::beforeSet();
    }

}

return 'srActivitiesSnapshotCreateProcessor';