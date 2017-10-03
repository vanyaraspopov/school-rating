<?php
$mySqlDateFormat = 'Y-m-d H:i:s';

/** @var modX $modx */
switch ($modx->event->name) {

    case 'srOnParticipationAllow':
    case 'srOnParticipationDisallow':
        if (!$sr = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
                $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/')
        ) {
            return 'Could not load SchoolRating class!';
        }
        /** @var modProcessorResponse $response */
        $response = $modx->runProcessor(
            'mgr/logs/create',
            [
                'username' => $modx->user->get('id') ? $modx->user->get('username') : 'anonymous',
                'action' => $modx->event->name,
                'date' => date($mySqlDateFormat),
                'ipaddress' => $_SERVER['REMOTE_ADDR'],
            ],
            [
                'processors_path' => $sr->config['processorsPath']
            ]
        );
        if ($response->isError()) {
            return 'Ошибка при создании записи в логе. ' . print_r($response->getAllErrors(), true);
        }
        break;
}