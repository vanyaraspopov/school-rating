<?php

class srUserRatingGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srUserRating';
    public $classKey = 'srUserRating';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
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
        $c->select($this->modx->getSelectColumns('srUserRating', 'srUserRating'));

        $c->leftJoin('modUserProfile', 'Profile', 'srUserRating.user_id = Profile.internalKey');
        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', null, ['fullname', 'extended']));

        $c->leftJoin('srActivitySection', 'Section', 'srUserRating.section_id = Section.id');
        $c->select($this->modx->getSelectColumns('srActivitySection', 'Section', 'section_', ['name']));

        $user_id = $this->getProperty('user_id');
        if ($user_id) {
            $c->where(array(
                'user_id' => $user_id,
            ));
        }

        //  Обработка формы поиска
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'Profile.fullname:LIKE' => "%{$query}%",
                'OR:Section.name:LIKE' => "%{$query}%",
                'OR:srUserRating.comment:LIKE' => "%{$query}%",
            ]);
        }

        //  Фильтруем по группе польователей
        $groups = $this->modx->user->getUserGroups();
        $c->where([
            'Section.usergroup_id:IN' => $groups,
            'OR:Section.usergroup_id:IS' => null      //  Добавляем записи без направления
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
            'title' => $this->modx->lexicon('schoolrating_rating_update'),
            //'multiple' => $this->modx->lexicon('schoolrating_items_update'),
            'action' => 'updateRating',
            'button' => true,
            'menu' => true,
        );

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('schoolrating_rating_remove'),
            'multiple' => $this->modx->lexicon('schoolrating_ratings_remove'),
            'action' => 'removeRating',
            'button' => true,
            'menu' => true,
        );

        $userName = $object->get('fullname');
        $array['name'] = $userName ? $userName : $object->get('user_id');

        return $array;
    }

}

return 'srUserRatingGetListProcessor';