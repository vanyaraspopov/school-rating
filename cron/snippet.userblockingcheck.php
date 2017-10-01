<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

/* подгрузка MODx */
require_once __DIR__ . '/../config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');

try {
    //  ID группы пользователей "Пользователи"
    $usersGroupId = $modx->getOption('schoolrating_usergroup_users');
    if (empty($usersGroupId)) {
        throw new Exception('Option schoolrating_usergroup_users not set.');
    }

    //  Подгружаем компонент UserExtra
    if (!$userextra = $modx->getService('userextra', 'UserExtra', $modx->getOption('userextra_core_path', null,
            $modx->getOption('core_path') . 'components/userextra/') . 'model/userextra/')
    ) {
        throw new Exception('Could not load UserExtra class!');
    }

    //  Формируем запрос в БД
    $c = $modx->newQuery('modUserProfile');
    $c->leftJoin('modUser', 'User');
    $c->leftJoin('modUserGroupMember', 'UserGroupMembers', 'User.id = UserGroupMembers.member');

    $c->where([
        'UserGroupMembers.user_group' => $usersGroupId
    ]);

    //  Получаем профили пользователей из БД
    /* @var modUserProfile[] $userProfiles */
    $userProfiles = $modx->getCollection('modUserProfile', $c);
    $time = time();
    $ids = [];
    //  Перебираем профили
    foreach ($userProfiles as $profile) {
        $extended = $profile->get('extended');
        //  Получаем срок блокировки аккаунта
        $blockingExpirationDate = $extended['locking_expire'];
        if (empty($blockingExpirationDate)) {
            continue;
        }
        $expire = strtotime($blockingExpirationDate);
        //  Собираем id пользователей, у которых прошёл срок блокировки
        if ($time > $expire) {
            $ids[] = $profile->get('internalKey');
        }
    }
    //  Выполняем процессор разблокировки пользователей
    if (!empty($ids)) {
        /* @var modProcessorResponse $response */
        $response = $modx->runProcessor(
            'mgr/item/unlock',
            [
                'ids' => json_encode($ids)
            ],
            [
                'processors_path' => $userextra->config['processorsPath']
            ]
        );
        print json_encode($response->response);
    } else {
        print 'No users have to be unblocked.';
    }

} catch (Exception $e) {
    echo $e->getMessage();
    return;
}