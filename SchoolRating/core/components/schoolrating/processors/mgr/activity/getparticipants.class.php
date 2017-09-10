<?php

class srActivityParticipantGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srActivityParticipant';
    public $classKey = 'srActivityParticipant';
    public $languageTopics = array('schoolrating:default');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'view';

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        return $c;
    }

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

}

return 'srActivityParticipantGetListProcessor';