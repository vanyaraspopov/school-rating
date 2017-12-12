<?php
/** @var modX $modx */

$events = array();
$tmp = array(
    //  srActivityParticipant
    'srOnParticipantCreate',
    'srOnParticipantRemove',
    'srOnParticipationAllow',
    'srOnParticipationDisallow',

    //  srActivityWinner
    'srOnWinnerCreate',
    'srOnWinnerUpdate',
    'srOnWinnerRemove',

    //  srUserRating
    'srOnUserRatingCreate',
    'srOnUserRatingUpdate',
    'srOnUserRatingRemove',

    //  srUserRatingReport
    'srOnReportCreate',
    'srOnReportRemove',

    //  srActivityCoefficient
    'srOnActivityCoefficientCreate',
    'srOnActivityCoefficientUpdate',
    'srOnActivityCoefficientRemove',

    //  srActivitySection
    'srOnActivitySectionCreate',
    'srOnActivitySectionUpdate',
    'srOnActivitySectionRemove',

    //  srActivitiesSnapshot
    'srOnActivitiesSnapshotCreate',
    'srOnActivitiesSnapshotApply',
    'srOnActivitiesSnapshotUpload',
    'srOnActivitiesSnapshotRemove',

    //  OnHybridAuthServiceCreated
    'OnHybridAuthServiceCreated',
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