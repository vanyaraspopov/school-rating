<?php

class vpPhoneCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'vpPhone';
    public $classKey = 'vpPhone';
    public $languageTopics = array('verifyphone');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $phone = VerifyPhone::cleanPhoneNumber( trim($this->getProperty('phone')) );
        if (empty($phone)) {
            $this->modx->error->addField('phone', $this->modx->lexicon('verifyphone_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('phone' => $phone))) {
            $this->modx->error->addField('phone', $this->modx->lexicon('verifyphone_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'vpPhoneCreateProcessor';