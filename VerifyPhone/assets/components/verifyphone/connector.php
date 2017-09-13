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
/** @var VerifyPhone $VerifyPhone */
$VerifyPhone = $modx->getService('verifyphone', 'VerifyPhone', $modx->getOption('verifyphone_core_path', null,
        $modx->getOption('core_path') . 'components/verifyphone/') . 'model/verifyphone/'
);
$modx->lexicon->load('verifyphone:default');

// handle request
$corePath = $modx->getOption('verifyphone_core_path', null, $modx->getOption('core_path') . 'components/verifyphone/');
$path = $modx->getOption('processorsPath', $VerifyPhone->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));