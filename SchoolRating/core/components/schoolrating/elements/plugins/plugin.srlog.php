<?php
//  Список обрабатываемых событий
$events = array(
    //  srActivityParticipant
    'srOnParticipantCreate',
    'srOnParticipantRemove',
    'srOnParticipationAllow',
    'srOnParticipationDisallow',

    //  srActivityWinner
    'srOnWinnerCreate',
    'srOnWinnerUpdate',
    'srOnWinnerRemove',
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
    try {
        switch ($modx->event->name) {
            case 'srOnParticipantCreate':
            case 'srOnParticipationAllow':
            case 'srOnParticipationDisallow':
                $phrases = [
                    'srOnParticipantCreate' => 'Добавлена заявка на участие в мероприятии. ',
                    'srOnParticipationAllow' => 'Одобрена заявка на участие в мероприятии. ',
                    'srOnParticipationDisallow' => 'Отклонена заявка на участие в мероприятии. ',
                ];
                $c = $modx->newQuery('srActivityParticipant');
                $c->leftJoin('modResource', 'Activity');
                $c->leftJoin('modUser', 'User');
                $c->select($modx->getSelectColumns('modResource', 'Activity', '', ['pagetitle']));
                $c->select($modx->getSelectColumns('modUser', 'User', '', ['username']));
                $c->where([
                    'resource_id' => $modx->event->params['object']->_fields['resource_id'],
                    'user_id' => $modx->event->params['object']->_fields['user_id'],
                ]);
                $obj = $modx->getObject('srActivityParticipant', $c);
                $eventName = $obj->get('pagetitle');
                $userName = $obj->get('username');
                $action = $phrases[$modx->event->name] .
                    "Мероприятие: $eventName. " .
                    "Пользователь: $userName.";
                break;
            case 'srOnParticipantRemove':
            case 'srOnWinnerRemove':
                $phrases = [
                    'srOnParticipantRemove' => 'Удалена заявка на участие в мероприятии. ',
                    'srOnWinnerRemove' => 'Удален победитель мероприятия. ',
                ];
                $resourceId = $modx->event->params['resource_id'];
                $userId = $modx->event->params['user_id'];
                $resource = $modx->getObject('modResource', $resourceId);
                $user = $modx->getObject('modUser', $userId);
                $eventName = $resource->get('pagetitle');
                $userName = $user->get('username');
                $action = $phrases[$modx->event->name] .
                    "Мероприятие: $eventName. " .
                    "Пользователь: $userName.";
                break;

            case 'srOnWinnerCreate':
            case 'srOnWinnerUpdate':
                $phrases = [
                    'srOnWinnerCreate' => 'Добавлен победитель мероприятия. ',
                    'srOnWinnerUpdate' => 'Изменены данные победителя мероприятия. ',
                ];
                $c = $modx->newQuery('srActivityWinner');
                $c->leftJoin('modResource', 'Activity');
                $c->leftJoin('modUser', 'User');
                $c->select($modx->getSelectColumns('modResource', 'Activity', '', ['pagetitle']));
                $c->select($modx->getSelectColumns('modUser', 'User', '', ['username']));
                $c->select($modx->getSelectColumns('srActivityWinner', 'srActivityWinner', '', ['place']));
                $c->where([
                    'resource_id' => $modx->event->params['object']->_fields['resource_id'],
                    'user_id' => $modx->event->params['object']->_fields['user_id'],
                ]);
                $obj = $modx->getObject('srActivityWinner', $c);
                $eventName = $obj->get('pagetitle');
                $userName = $obj->get('username');
                $position = $obj->get('place');
                $action = $phrases[$modx->event->name] .
                    "Мероприятие: $eventName. " .
                    "Пользователь: $userName. " .
                    "Место: $position.";
                break;
            default:
                break;
        }
    } catch (Exception $e) {
        $action = 'Ошибка при определении действия пользователя. ' . $e->getMessage();
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