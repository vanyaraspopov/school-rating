<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'core_path' => array(
        'xtype' => 'textfield',
        'value' => '{base_path}SchoolRating/core/components/schoolrating/',
        'area' => 'schoolrating_main',
    ),
    'assets_path' => array(
        'xtype' => 'textfield',
        'value' => '{base_path}SchoolRating/assets/components/schoolrating/',
        'area' => 'schoolrating_main',
    ),
    'assets_url' => array(
        'xtype' => 'textfield',
        'value' => '{base_url}SchoolRating/assets/components/schoolrating/',
        'area' => 'schoolrating_main',
    ),

    // srLogs
    'logs_expire_days' => array(
        'xtype' => 'numberfield',
        'value' => 60,
        'area' => 'schoolrating_log',
    ),

);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'schoolrating_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
