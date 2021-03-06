<?php

class vpPhoneDisableProcessor extends modObjectProcessor
{
    public $objectType = 'vpPhone';
    public $classKey = 'vpPhone';
    public $languageTopics = array('verifyphone');
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('verifyphone_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var VerifyPhoneItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('verifyphone_item_err_nf'));
            }

            $object->set('verified', false);
            $object->save();
        }

        return $this->success();
    }

}

return 'vpPhoneDisableProcessor';
