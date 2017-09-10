<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'core_path' => array(
        'xtype' => 'textfield',
        'value' => '{base_path}' . PKG_NAME . '/core/components/' . PKG_NAME_LOWER . '/',
        'area' => PKG_NAME_LOWER . '_main',
    ),
    'assets_path' => array(
        'xtype' => 'textfield',
        'value' => '{base_path}' . PKG_NAME . '/assets/components/' . PKG_NAME_LOWER . '/',
        'area' => PKG_NAME_LOWER . '_main',
    ),
    'assets_url' => array(
        'xtype' => 'textfield',
        'value' => '{base_url}' . PKG_NAME . '/assets/components/' . PKG_NAME_LOWER . '/',
        'area' => PKG_NAME_LOWER . '_main',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'verifyphone_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
