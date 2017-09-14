<?php

class srActivityParticipantUpdateFromGridProcessor extends modObjectUpdateProcessor {
    public $classKey = 'srActivityParticipant';
    public $objectType = 'srActivityParticipant';
    public $languageTopics = array('schoolrating');

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

    public function initialize() {
        $data = $this->getProperty('data');
        if (empty($data)) return $this->modx->lexicon('invalid_data');
        $properties = $this->modx->fromJSON($data);
        $this->setProperties($properties);
        $this->unsetProperty('data');

        return parent::initialize();
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

        return parent::beforeSet();
    }
}
return 'srActivityParticipantUpdateFromGridProcessor';