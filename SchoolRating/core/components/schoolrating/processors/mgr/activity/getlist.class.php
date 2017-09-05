<?php

class srActivityGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'modResource';
    public $classKey = 'modResource';
    public $defaultSortField = 'id';
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
        $eventsFuture = $this->modx->getOption('schoolrating_events_future');
        $eventsPast = $this->modx->getOption('schoolrating_events_past');
        $parents = [];
        if ($eventsFuture && $eventsPast) {
            $c->where([
                'parent:IN' => [$eventsFuture, $eventsPast]
            ]);
        }

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'pagetitle:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
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

        // Edit
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('schoolrating_activity_update'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => 'updateActivity',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }

}

return 'srActivityGetListProcessor';