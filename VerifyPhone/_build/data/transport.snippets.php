<?php
/** @var modX $modx */
/** @var array $sources */

$snippets = array();

$tmp = array(
    'vpSendCode' => array(
        'file' => 'vpSendCode',
        'description' => 'Отправляет код подтверждения',
    ),
    'vpCheckCode' => array(
        'file' => 'vpCheckCode',
        'description' => 'Проверяет код подтверждения',
    ),
    'vpCheckPhoneVerified' => array(
        'file' => 'vpCheckPhoneVerified',
        'description' => 'Проверяет подтверждён ли номер телефона',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSnippet $snippet */
    $snippet = $modx->newObject('modSnippet');
    $snippet->fromArray(array(
        'id' => 0,
        'name' => $k,
        'description' => @$v['description'],
        'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.' . $v['file'] . '.php'),
        'static' => BUILD_SNIPPET_STATIC,
        'source' => 1,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/snippet.' . $v['file'] . '.php',
    ), '', true, true);
    /** @noinspection PhpIncludeInspection */
    $properties = include $sources['build'] . 'properties/properties.' . $v['file'] . '.php';
    $snippet->setProperties($properties);

    $snippets[] = $snippet;
}
unset($tmp, $properties);

return $snippets;