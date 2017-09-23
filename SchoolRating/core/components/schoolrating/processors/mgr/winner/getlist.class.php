<?php

class srActivityWinnerGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srActivityWinner';
    public $classKey = 'srActivityWinner';
    public $defaultSortField = 'place';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'list';


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
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));

        $c->leftJoin('modUserProfile', 'Profile', 'Profile.internalKey=srActivityWinner.user_id');
        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', '', ['fullname']));

        $c->leftJoin('modResource', 'Resource', 'Resource.id=srActivityWinner.resource_id');
        $c->select($this->modx->getSelectColumns('modResource', 'Resource', '', ['pagetitle']));

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'Profile.fullname:LIKE' => "%{$query}%",
                'Resource.pagetitle:LIKE' => "%{$query}%",
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
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = array();

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('schoolrating_winner_remove'),
            'multiple' => $this->modx->lexicon('schoolrating_winners_remove'),
            'action' => 'removeWinner',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }

}

return 'srActivityWinnerGetListProcessor';