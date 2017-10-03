<?php
//  Список обрабатываемых событий
$events = array(
    //  srActivityParticipant
    'srOnParticipantCreate',
    'srOnParticipantRemove',
    'srOnParticipationAllow',
    'srOnParticipationDisallow'
);

/** @var modX $modx */
if (in_array($modx->event->name, $events)) {
    //  Подгрузка компонента SchoolRating
    if (!$sr = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
            $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/')
    ) {
        return 'Could not load SchoolRating class!';
    }

    //  Формирование текста записи лога
    $action = $modx->event->name;
    switch ($modx->event->name) {
        case 'srOnParticipationAllow':
        case 'srOnParticipationDisallow':
            $phrases = [
                'srOnParticipationAllow' => 'Одобрена заявка на участие в мероприятии. ',
                'srOnParticipationDisallow' => 'Отклонена заявка на участие в мероприятии. ',
            ];
            $c = $modx->newQuery('srActivityParticipant');
            $c->leftJoin('modResource', 'Activity');
            $c->leftJoin('modUser', 'User');
            $c->select($modx->getSelectColumns('modResource', 'Activity', '', ['pagetitle']));
            $c->select($modx->getSelectColumns('modUser', 'User', '', ['username']));
            $c->where([
                'id' => $modx->event->params['object']->get('id')
            ]);
            $obj = $modx->getObject('srActivityParticipant', $c);
            $eventName = $obj->get('pagetitle');
            $userName = $obj->get('username');
            $action = $phrases[$modx->event->name] .
                "Мероприятие: $eventName. " .
                "Пользователь: $userName.";
            break;
        default:
            break;
    }

    //  Запуск процессора, создающего записи лога
    $mySqlDateFormat = 'Y-m-d H:i:s';
    /** @var modProcessorResponse $response */
    $response = $modx->runProcessor(
        'mgr/logs/create',
        [
            'username' => $modx->user->get('id') ? $modx->user->get('username') : 'anonymous',
            'action' => $action,
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
}