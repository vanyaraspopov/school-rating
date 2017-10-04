<?php

class srActivitySectionCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srActivitySection';
    public $classKey = 'srActivitySection';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';
    public $afterSaveEvent = 'srOnActivitySectionCreate';


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

return 'srActivitySectionCreateProcessor';