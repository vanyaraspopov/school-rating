<?php

class srActivitiesSnapshotGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srActivitiesSnapshot';
    public $classKey = 'srActivitiesSnapshot';
    public $languageTopics = array('schoolrating:default');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'view';

    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = array();

        // Confirm
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-check',
            'title' => $this->modx->lexicon('schoolrating_snapshot_confirm'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => '',
            'button' => true,
            'menu' => true,
        );

        //  Download
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-download',
            'title' => $this->modx->lexicon('schoolrating_snapshot_download'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => '',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }
}

return 'srActivitiesSnapshotGetListProcessor';