<?php

class SchoolRatingItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'SchoolRatingItem';
    public $classKey = 'SchoolRatingItem';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('schoolrating_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('schoolrating_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'SchoolRatingItemCreateProcessor';