<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

/* подгрузка MODx */
require_once __DIR__ . '/../config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');

try {
    $usersGroupId = $modx->getOption('schoolrating_usergroup_users');
    if (empty($usersGroupId)) {
        throw new Exception('Option schoolrating_usergroup_users not set.');
    }

    $c = $modx->newQuery('modUserProfile');
    $c->leftJoin('modUser', 'User');
    $c->leftJoin('modUserGroupMember', 'UserGroupMembers', 'User.id = UserGroupMembers.member');

    $c->where([
        'UserGroupMembers.user_group' => $usersGroupId
    ]);

    /* @var modUserProfile[] $userProfiles */
    $userProfiles = $modx->getCollection('modUserProfile', $c);
    $time = time();
    foreach ($userProfiles as $profile) {
        $extended = $profile->get('extended');
        $blockingExpirationDate = $extended['locking_expire'];
        if (empty($blockingExpirationDate)) {
            continue;
        }
        $expire = strtotime($blockingExpirationDate);
        if ($time > $expire) {
            unset($extended['locking_expire']);
            $profile->set('extended', $extended);
            $profile->set('blocked', 0);
            $profile->save();
        }
    }

} catch (Exception $e) {
    echo $e->getMessage();
    return;
}