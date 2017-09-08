<?php

class srUserRatingCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srUserRating';
    public $classKey = 'srUserRating';
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

return 'srUserRatingCreateProcessor';