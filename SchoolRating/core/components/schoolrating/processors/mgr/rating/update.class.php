<?php

class srUserRatingUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'srUserRating';
    public $classKey = 'srUserRating';
    public $languageTopics = array('schoolrating');
    //public $permission = 'save';
    public $afterSaveEvent = 'srOnUserRatingUpdate';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        if (empty($id)) {
            return $this->modx->lexicon('schoolrating_item_err_ns');
        }

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

return 'srUserRatingUpdateProcessor';
