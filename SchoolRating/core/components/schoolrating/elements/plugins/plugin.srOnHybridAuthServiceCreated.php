<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'OnHybridAuthServiceCreated':

        if (!$modx->user->get('id')) {
            return false;
        }
        $username = $modx->user->get('username');
        $params = $modx->event->params['object']->toArray();
        $comment = "$username привязал социальную сеть " . $params['provider'];
        $modx->log(modX::LOG_LEVEL_INFO, $comment);

        $profile = $modx->user->getOne('Profile');
        $extended = $profile->get('extended');
        $alreadyAttachedKey = 'social_net_already_attached';
        if ($extended[$alreadyAttachedKey]) {
            return;
        }

        $rating = $modx->getOption('schoolrating_rating_for_social');
        $mySqlDateFormat = 'Y-m-d H:i:s';
        $ratingData = [
            'user_id' => $modx->user->get('id'),
            'comment' => $comment,
            'date' => date($mySqlDateFormat),
            'rating' => $rating
        ];

        //  Подключение компонента ScoolRating
        if (!$sr = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
                $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/')
        ) {
            return 'Could not load SchoolRating class!';
        }
        /** @var srUserRating $ratingObj */
        $ratingObj = $modx->newObject('srUserRating', $ratingData);
        if ($ratingObj->save()) {
            $extended[$alreadyAttachedKey] = 1;
            $profile->set('extended', $extended);
            $profile->save();
            $ratingObj->recalculateUserRating();
        }

        break;
}