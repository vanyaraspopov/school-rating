<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var SchoolRating $SchoolRating */
$SchoolRating = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
        $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/'
);
$modx->lexicon->load('schoolrating:default');

// handle request
$corePath = $modx->getOption('schoolrating_core_path', null, $modx->getOption('core_path') . 'components/schoolrating/');
$path = $modx->getOption('processorsPath', $SchoolRating->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));