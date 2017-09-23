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

        $coefficient = $this->getProperty('coefficient');
        if ($coefficient) {
            $rating = $this->getProperty('rating');
            $this->setProperty('rating', number_format($rating * $coefficient, 2, '.', ''));
        }

        return parent::beforeSet();
    }

    public function afterSave()
    {
        $this->object->recalculateUserRating();
    }

}

return 'srUserRatingCreateProcessor';