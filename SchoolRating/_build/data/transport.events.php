<?php
/** @var modX $modx */

$events = array();
$tmp = array(
    //  srActivityParticipant
    'srOnParticipantCreate',
    'srOnParticipantRemove',
    'srOnParticipationAllow',
    'srOnParticipationDisallow'
);
foreach ($tmp as $k => $v) {
    /** @var modEvent $event */
    $event = $modx->newObject('modEvent');
    $event->fromArray(array(
        'name' => $v,
        'service' => 6,
        'groupname' => PKG_NAME,
    ), '', true, true);
    $events[] = $event;
}
return $events;