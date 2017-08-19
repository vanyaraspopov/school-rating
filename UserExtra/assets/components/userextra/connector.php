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
/** @var UserExtra $UserExtra */
$UserExtra = $modx->getService('userextra', 'UserExtra', $modx->getOption('userextra_core_path', null,
        $modx->getOption('core_path') . 'components/userextra/') . 'model/userextra/'
);
$modx->lexicon->load('userextra:default');

// handle request
$corePath = $modx->getOption('userextra_core_path', null, $modx->getOption('core_path') . 'components/userextra/');
$path = $modx->getOption('processorsPath', $UserExtra->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));