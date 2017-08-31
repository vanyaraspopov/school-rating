<?php

class srUserRatingGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srUserRating';
    public $classKey = 'srUserRating';
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
            'action' => 'updateCoefficient',
            'button' => true,
            'menu' => true,
        );

        /*if (!$array['active']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('schoolrating_item_enable'),
                'multiple' => $this->modx->lexicon('schoolrating_items_enable'),
                'action' => 'enableItem',
                'button' => true,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('schoolrating_item_disable'),
                'multiple' => $this->modx->lexicon('schoolrating_items_disable'),
                'action' => 'disableItem',
                'button' => true,
                'menu' => true,
            );
        }*/

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('schoolrating_rating_remove'),
            'multiple' => $this->modx->lexicon('schoolrating_ratings_remove'),
            'action' => 'removeCoefficient',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }

}

return 'srUserRatingGetListProcessor';