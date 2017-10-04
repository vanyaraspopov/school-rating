<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

/* подгрузка MODx */
require_once __DIR__ . '/../config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');

try {
    //  Срок хранения записей лога
    $expireDays = $modx->getOption('schoolrating_logs_expire_days');
    if (empty($expireDays)) {
        throw new Exception('Option schoolrating_logs_expire_days not set.');
    }

    //  Подгружаем компонент SchoolRating
    if (!$sr = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
            $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/')
    ) {
        return 'Could not load SchoolRating class!';
    }

    //  Формируем запрос в БД
    $mySqlDateFormat = 'Y-m-d H:i:s';
    $c = $modx->newQuery('srLog');
    $c->where([
        'date:<' => date($mySqlDateFormat, time() - $expireDays * 24 * 60 * 60)
    ]);

    //  Получаем устаревшие записи лога из БД
    /** @var srLog[] $logs */
    $logs = $modx->getCollection('srLog', $c);
    if (empty($logs)) {
        print 'There are no logs expired.';
    } else {
        //  Удаляем записи
        $errors = [];
        foreach ($logs as $log) {
            if (!$log->remove()) {
                $errors[$log->get('id')] = $log->toArray();
            }
        }

        //  Прверяем массив ошибок
        if (!empty($errors)) {
            print 'Removing failed on next logs: ';
            print_r($errors, true);
        } else {
            print 'Expired logs have been removed successfully.';
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    return;
}