<?php
require_once MODX_CORE_PATH . 'model/modx/processors/security/user/getlist.class.php';

class srUserRatingRecalculateAllProcessor extends modUserGetListProcessor
{

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->leftJoin('modUserProfile', 'Profile');
        $c->leftJoin('srUserRating', 'srUserRating', 'modUser.id = srUserRating.user_id');
        $c->groupby('modUser.id');
        return $c;
    }

    public function prepareQueryAfterCount(xPDOQuery $c)
    {
        $c->select($this->modx->getSelectColumns('modUser', 'modUser'));
        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', '', array('fullname', 'email', 'blocked')));
        $c->select('SUM(srUserRating.rating) as rating_total');
        return $c;
    }

    /**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $this->recalculateRating($object);

        $objectArray = $object->toArray();
        $objectArray['blocked'] = $object->get('blocked') ? true : false;
        $objectArray['cls'] = 'pupdate premove pcopy';
        unset($objectArray['password'], $objectArray['cachepwd'], $objectArray['salt']);
        return $objectArray;
    }

    /**
     * @param xPDOObject $user
     */
    public function recalculateRating($user)
    {
        $profile = $this->modx->getObject('modUserProfile', ['internalKey' => $user->get('id')]);
        if ($profile) {
            $extended = $profile->get('extended');
            $extended['rating'] = $user->get('rating_total');
            $profile->set('extended', $extended);
            $profile->save();
        }
    }

}

return 'srUserRatingRecalculateAllProcessor';