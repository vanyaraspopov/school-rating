<?php
/** @var modX $modx */
/** @var array $sources */

$plugins = array();

$tmp = array(
    'srOnParticipantCreate' => array(
        'file' => 'srOnParticipantCreate',
        'description' => 'Срабатывает при создании новой заявки на участие в мероприятии',
        'events' => array(
            'srOnParticipantCreate' => array()
        )
    ),
    'srLog' => array(
        'file' => 'srlog',
        'description' => 'Пишет логи по событиям',
        'events' => array(
            //  srActivityParticipant
            'srOnParticipantCreate' => array(),
            'srOnParticipantRemove' => array(),
            'srOnParticipationAllow' => array(),
            'srOnParticipationDisallow' => array(),

            //  srActivityWinner
            'srOnWinnerCreate' => array(),
            'srOnWinnerUpdate' => array(),
            'srOnWinnerRemove' => array(),

            //  srUserRating
            'srOnUserRatingCreate' => array(),
            'srOnUserRatingUpdate' => array(),
            'srOnUserRatingRemove' => array(),

            //  srUserRatingReport
            'srOnReportCreate' => array(),
            'srOnReportRemove' => array(),

            //  srActivityCoefficient
            'srOnActivityCoefficientCreate' => array(),
            'srOnActivityCoefficientUpdate' => array(),
            'srOnActivityCoefficientRemove' => array(),
        )
    )
);

foreach ($tmp as $k => $v) {
    /** @var modplugin $plugin */
    $plugin = $modx->newObject('modPlugin');
    $plugin->fromArray(array(
        'name' => $k,
        'category' => 0,
        'description' => @$v['description'],
        'plugincode' => getSnippetContent($sources['source_core'] . '/elements/plugins/plugin.' . $v['file'] . '.php'),
        'static' => BUILD_PLUGIN_STATIC,
        'source' => 1,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/plugin.' . $v['file'] . '.php',
    ), '', true, true);

    $events = array();
    if (!empty($v['events'])) {
        foreach ($v['events'] as $k2 => $v2) {
            /** @var modPluginEvent $event */
            $event = $modx->newObject('modPluginEvent');
            $event->fromArray(array_merge(
                array(
                    'event' => $k2,
                    'priority' => 0,
                    'propertyset' => 0,
                ), $v2
            ), '', true, true);
            $events[] = $event;
        }
        unset($v['events']);
    }

    if (!empty($events)) {
        $plugin->addMany($events);
    }
    $plugins[] = $plugin;
}
unset($tmp, $properties);

return $plugins;