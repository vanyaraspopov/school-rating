<?php

class srActivitiesSnapshotRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'srActivitiesSnapshot';
    public $classKey = 'srActivitiesSnapshot';
    public $languageTopics = array('schoolrating');
    //public $permission = 'remove';
    public $afterRemoveEvent = 'srOnActivitiesSnapshotRemove';


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
            /** @var srActivitiesSnapshot $this->object */
            if (!$this->object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('schoolrating_item_err_nf'));
            }

            if ($this->object->remove() ) {
                $this->deleteSnapshotDocument($this->object->get('filepath'));
                $this->fireAfterRemoveEvent();
            }
        }

        return $this->success();
    }

    private function deleteSnapshotDocument($filename) {
        unlink(MODX_BASE_PATH . $filename);
    }

    /**
     * If specified, fire the after remove event
     * @return void
     */
    public function fireAfterRemoveEvent() {
        if (!empty($this->afterRemoveEvent)) {
            $this->modx->invokeEvent($this->afterRemoveEvent,array(
                $this->primaryKeyField => $this->object->get($this->primaryKeyField),
                $this->objectType => &$this->object,
                'object' => &$this->object,
            ));
        }
    }

}

return 'srActivitiesSnapshotRemoveProcessor';