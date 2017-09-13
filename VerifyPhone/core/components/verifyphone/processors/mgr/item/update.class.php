<?php

class vpPhoneUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'vpPhone';
    public $classKey = 'vpPhone';
    public $languageTopics = array('verifyphone');
    //public $permission = 'save';


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
        $phone = VerifyPhone::cleanPhoneNumber( trim($this->getProperty('phone')) );
        if (empty($id)) {
            return $this->modx->lexicon('verifyphone_item_err_ns');
        }

        if (empty($phone)) {
            $this->modx->error->addField('phone', $this->modx->lexicon('verifyphone_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('phone' => $phone, 'id:!=' => $id))) {
            $this->modx->error->addField('name', $this->modx->lexicon('verifyphone_item_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'vpPhoneUpdateProcessor';
