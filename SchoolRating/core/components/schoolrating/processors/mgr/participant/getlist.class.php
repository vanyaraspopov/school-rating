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
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));

        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey=srActivityParticipant.user_id');
        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', '', ['fullname']));

        $c->leftJoin('modResource', 'Resource', 'Resource.id=srActivityParticipant.resource_id');
        $c->select($this->modx->getSelectColumns('modResource', 'Resource', '', ['pagetitle']));

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'Profile.fullname:LIKE' => "%{$query}%",
            ));
        }

        $resource_id = $this->getProperty('resource_id');
        if ($resource_id) {
            $c->where(array(
                'resource_id' => $resource_id,
            ));
        }

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