<?php

class srUserRatingRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'srUserRating';
    public $classKey = 'srUserRating';
    public $languageTopics = array('schoolrating');
    //public $permission = 'remove';


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
            return $this->failure($this->modx->lexicon('schoolrating_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var SchoolRatingItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('schoolrating_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

    public function afterSave()
    {
        $this->object->recalculateUserRating();
    }

}

return 'srUserRatingRemoveProcessor';