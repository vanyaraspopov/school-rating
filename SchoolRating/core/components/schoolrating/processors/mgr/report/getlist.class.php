<?php

class srUserRatingReportGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srUserRatingReport';
    public $classKey = 'srUserRatingReport';
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

        // View users
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-users',
            'title' => $this->modx->lexicon('schoolrating_rating_report_view'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => 'viewUsers',
            'button' => true,
            'menu' => true,
        );

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('schoolrating_rating_report_remove'),
            'multiple' => $this->modx->lexicon('schoolrating_rating_reports_remove'),
            'action' => 'removeReport',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }
}

return 'srUserRatingReportGetListProcessor';