<?php
$response = [
    'error' => true,
    'errorMsg' => '',
];

$nets = [
    'vk' => 'Vkontakte',
    'tw' => 'Twitter',
    'fb' => 'Facebook'
];

try {
    /** @var modX $modx */
    /** @var array $scriptProperties */
    /** @var SchoolRating $sr */
    if (!$sr = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
            $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/')
    ) {
        throw new Exception('Could not load SchoolRating class!');
    }

    $ratingForSharing = $modx->getOption('schoolrating_rating_for_sharing');
    $ratingLimit = $modx->getOption('schoolrating_rating_for_sharing_limit');
    $ratingLimitExpire = $modx->getOption('schoolrating_rating_for_sharing_limit_expire');

    $userId = $modx->user->id;
    if (!$userId) {
        throw new Exception('Пользователь не авторизован');
    }

    $mySqlDateFormat = 'Y-m-d H:i:s';
    $c = $modx->newQuery('srUserRating');
    $c->where([
        'user_id' => $userId,
        'forSharing' => 1,
        'date:>=' => date($mySqlDateFormat, time() - $ratingLimitExpire * 24 * 60 * 60)
    ]);
    $c->select('SUM(srUserRating.rating) as rating');
    $c->prepare();
    $sql = $c->toSQL();
    $result = $modx->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $rating = (float)$row['rating'];
    if ($rating < (float)$ratingLimit) {
        $resourceId = $scriptProperties['resource'];
        $resource = $modx->getObject('modResource', $resourceId);

        $comment = 'Пользователь ' . $modx->user->username . " ($userId) поделился ссылкой на ресурс " .
            $resource->get('pagetitle') . " ($resourceId) " . ' в социальной сети ' . $nets[$scriptProperties['net']];

        $ratingProps = [
            'user_id' => $userId,
            'comment' => $comment,
            'rating' => $ratingForSharing,
            'forSharing' => 1
        ];

        /** @var modProcessorResponse $processorResponse */
        $processorResponse = $modx->runProcessor(
            'mgr/rating/create',
            $ratingProps,
            [
                'processors_path' => $sr->config['processorsPath']
            ]
        );

        if ($processorResponse->isError()) {
            throw new Exception($processorResponse->getMessage());
        } else {
            $response['error'] = false;
        }
    }

} catch (Exception $e) {
    $response['error'] = true;
    $response['errorMsg'] = $e->getMessage();
}
return json_encode($response);