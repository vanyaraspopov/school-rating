<?php
/**
 * Gets a list of users
 *
 * @param string $username (optional) Will filter the grid by searching for this
 * username
 * @param integer $start (optional) The record to start at. Defaults to 0.
 * @param integer $limit (optional) The number of records to limit to. Defaults
 * to 10.
 * @param string $sort (optional) The column to sort by. Defaults to name.
 * @param string $dir (optional) The direction of the sort. Defaults to ASC.
 *
 * @package modx
 * @subpackage processors.security.user
 */
class UserExtraGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modUser';
    public $languageTopics = array('user');
    public $permission = 'view_user';
    public $defaultSortField = 'username';

    public function initialize() {
        $initialized = parent::initialize();
        $this->setDefaultProperties(array(
            'usergroup' => false,
            'query' => '',
        ));
        if ($this->getProperty('sort') == 'username_link') $this->setProperty('sort','username');
        if ($this->getProperty('sort') == 'id') $this->setProperty('sort','modUser.id');
        return $initialized;
    }

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('modUserProfile','Profile');

        $query = $this->getProperty('query','');
        if (!empty($query)) {
            $c->where(array(
                'modUser.username:LIKE' => '%'.$query.'%',
                'OR:Profile.fullname:LIKE' => '%'.$query.'%',
                'OR:Profile.email:LIKE' => '%'.$query.'%',
            ));
        }

        $userGroup = $this->modx->getOption('schoolrating_usergroup_users');
        if (!empty($userGroup)) {
            if ($userGroup === 'anonymous') {
                $c->join('modUserGroupMember','UserGroupMembers', 'LEFT OUTER JOIN');
                $c->where(array(
                    'UserGroupMembers.user_group' => NULL,
                ));
            } else {
                $c->distinct();
                $c->innerJoin('modUserGroupMember','UserGroupMembers');
                $c->where(array(
                    'UserGroupMembers.user_group' => $userGroup,
                ));
            }
        }
        return $c;
    }

    public function prepareQueryAfterCount(xPDOQuery $c) {
        $c->select($this->modx->getSelectColumns('modUser','modUser', '', ['id', 'username', 'active']));
        $c->select($this->modx->getSelectColumns('modUserProfile','Profile', '', ['internalKey', 'fullname', 'email', 'blocked', 'extended']));
        return $c;
    }

    /**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $objectArray = $object->toArray();
        $objectArray['blocked'] = $object->get('blocked') ? true : false;
        $objectArray['cls'] = 'pupdate premove pcopy';
        unset($objectArray['password'],$objectArray['cachepwd'],$objectArray['salt']);

        //  Кнопка заблокировать / разблокировать
        if ($objectArray['blocked']) {
            $objectArray['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('userextra_locking_unlock'),
                'multiple' => $this->modx->lexicon('userextra_locking_unlock'),
                'action' => 'unlockUser',
                'button' => true,
                'menu' => true,
            );

            //  Отправить уведомление о блокировке
            $objectArray['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-send',
                'title' => $this->modx->lexicon('userextra_locking_notify_locked'),
                'multiple' => $this->modx->lexicon('userextra_locking_notify_locked'),
                'action' => 'notifyUserLocked',
                'button' => true,
                'menu' => true,
            );
        } else {
            $objectArray['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('userextra_locking_lock'),
                'multiple' => $this->modx->lexicon('userextra_locking_lock'),
                'action' => 'lockUser',
                'button' => true,
                'menu' => true,
            );
        }

        return $objectArray;
    }

    /**
     * Can be used to insert a row after iteration
     * @param array $list
     * @return array
     */
    public function afterIteration(array $list) {
        foreach ($list as &$item) {
            $item['extended'] = json_decode($item['extended'], true);
            if ($item['extended'] == null) continue;
            foreach ($item['extended'] as $k => $v) {
                $item[$k] = $v;
            }
        }
        return $list;
    }
}
return 'UserExtraGetListProcessor';