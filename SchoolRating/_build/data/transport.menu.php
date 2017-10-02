<?php
/** @var modX $modx */
/** @var array $sources */

$menus = array();

$tmp = array(
    'schoolrating_root' => array(
        'parent' => 'topnav',
    ),
    'schoolrating' => array(
        'description' => 'schoolrating_menu_desc',
        'action' => 'home',
        'parent' => 'schoolrating_root',
        //'icon' => '<i class="icon icon-large icon-modx"></i>',
    ),
    'schoolrating_log' => array(
        'description' => 'schoolrating_logs_menu_desc',
        'action' => 'logs',
        'parent' => 'schoolrating_root',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modMenu $menu */
    $menu = $modx->newObject('modMenu');
    $menu->fromArray(array_merge(array(
        'text' => $k,
        'parent' => 'components',
        'namespace' => PKG_NAME_LOWER,
        'icon' => '',
        'menuindex' => 0,
        'params' => '',
        'handler' => '',
    ), $v), '', true, true);
    $menus[] = $menu;
}
unset($menu, $i);

return $menus;