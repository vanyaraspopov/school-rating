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
        $c->select($this->modx->getSelectColumns('modResource', 'modResource'));

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

        //  Добавляем TV направления
        $eventsTvSection = $this->modx->getOption('schoolrating_events_tv_section');
        $c->leftJoin('modTemplateVarResource', 'tvSection', 'modResource.id = tvSection.contentid');
        $c->where([
            'tvSection.tmplvarid' => $eventsTvSection
        ]);

        //  Фильтруем по группе польователей
        $groups = $this->modx->user->getUserGroups();
        $c->leftJoin('srActivitySection', 'srActivitySection', 'srActivitySection.name = tvSection.value');
        $c->select($this->modx->getSelectColumns('srActivitySection', 'srActivitySection', null, ['name', 'usergroup_id']));
        $c->where([
            'srActivitySection.usergroup_id:IN' => $groups,
            'OR:srActivitySection.usergroup_id:IS' => null      //  Добавляем мероприятие без направления
        ]);

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

        //  Participants
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-users',
            'title' => $this->modx->lexicon('schoolrating_activities_participants'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => 'updateActivityParticipant',
            'button' => true,
            'menu' => true,
        );

        //  Winners
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-user action-yellow',
            'title' => $this->modx->lexicon('schoolrating_winners'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => 'updateWinners',
            'button' => true,
            'menu' => true,
        );

        /* @var modResource $object */

        $eventsTvSection = $this->modx->getOption('schoolrating_events_tv_section');
        if ($eventsTvSection) {
            $array['section'] = $object->getTVValue($eventsTvSection);
        }

        $eventsTvLevel = $this->modx->getOption('schoolrating_events_tv_level');
        if ($eventsTvLevel) {
            $array['level'] = $object->getTVValue($eventsTvLevel);
        }

        return $array;
    }

}

return 'srActivityGetListProcessor';