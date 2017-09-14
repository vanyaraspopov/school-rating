<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var SchoolRating $SchoolRating */
if (!$SchoolRating = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
        $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/', $scriptProperties)
) {
    return 'Could not load SchoolRating class!';
}

$userId = $modx->getOption('userId', $scriptProperties);
$resourceId = $modx->getOption('resourceId', $scriptProperties);

/* @var modProcessorResponse $response */
$response = $modx->runProcessor(
    'mgr/participant/create',
    [
        'user_id' => $userId,
        'resource_id' => $resourceId
    ],
    [
        'processors_path' => $SchoolRating->config['processorsPath']
    ]
);

return $response->isError();