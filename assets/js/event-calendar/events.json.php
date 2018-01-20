<?php
//  Подключаем MODx
define('MODX_API_MODE', true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php');
$modx = new modX();
$modx->initialize('web');

//  Определяем ID контейнеров, содержащих все мероприятия
$eventsParent = $modx->getOption('schoolrating_events_resource_id');
$eventsFuture = $modx->getOption('schoolrating_events_future');
$eventsPast = $modx->getOption('schoolrating_events_past');
if (empty ($eventsParent) or empty($eventsFuture) or empty($eventsPast)) {
    if (empty ($eventsParent)) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'Не указан общий контейнер, содержащий мероприятия', '', __FILE__);
    }
    if (empty ($eventsFuture)) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'Не указан контейнер, содержащий предстоящие мероприятия', '', __FILE__);
    }
    if (empty ($eventsPast)) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'Не указан контейнер, содержащий прошедшие мероприятия', '', __FILE__);
    }
    return;
}
$eventsAlias = $modx->makeUrl($eventsParent);

//  Делаем выборку ресурсов, используя сниппет pdoResources
$eventDateStart = 'event-date-start';
$eventDateEnd = 'event-date-end';
$result = $modx->runSnippet('pdoResources', [
    'parents' => "$eventsFuture, $eventsPast",
    'includeTVs' => "$eventDateStart,$eventDateEnd",
    'return' => 'json'
]);
if (empty($result)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Не найдены мероприятия', '', __FILE__);
    return;
}
$events = json_decode($result, true);

try {
    $tvEventDateStart = "tv.$eventDateStart";
    $tvEventDateEnd = "tv.$eventDateEnd";
    $dateFormat = 'Y-m-d';

    //  Формируем список дат мероприятий
    $dates = [];
    foreach ($events as $event) {
        if (empty($event[$tvEventDateStart]) or empty($event[$tvEventDateEnd])) {
            continue;
        }

        $dateStart = new DateTime($event[$tvEventDateStart]);
        $dateEnd = new DateTime($event[$tvEventDateEnd]);
        $dateInterval = $dateEnd->diff($dateStart);

        $tempDate = new DateTime($event[$tvEventDateStart]);
        for ($d = 0; $d <= $dateInterval->days; $d++) {
            $tempDateStr = $tempDate->format($dateFormat);
            if (!is_array($dates[$tempDateStr])) {
                $dates[$tempDateStr] = [];
            }
            $dates[$tempDateStr][] = $event;
            $tempDate->modify("+1 day");
        }
    }
    unset($event);

    //  Формируем выходные данные
    $output = [];
    foreach ($dates as $date => $dateEvents) {
        $cnt = count($dateEvents);
        if ($cnt === 0) continue;
        $item = [
            'date' => "$date 00:00:00",
            'title' => $dateEvents[0]['pagetitle'],
            'description' => $dateEvents[0]['description'],
        ];
        if ($cnt === 1) {
            $item['url'] = MODX_SITE_URL . $dateEvents[0]['uri'];
        } else {
            $filter = (new DateTime($date))->format('d.m.Y');
            $item['url'] = MODX_SITE_URL . $eventsAlias . "filter/date-$filter";
        }
        $output[] = $item;
    }
    unset($event);

    //  Отправляем ответ
    echo json_encode($output);
} catch (Exception $e) {
    $modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage(), '', __FILE__);
    return;
}