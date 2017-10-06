<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'OnUserRemove':

        $user = $modx->event->params['user'];

        /** @var modUser $user */
        if ($user instanceof modUser) {
            if (!$sr = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
                    $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/')
            ) {
                return 'Could not load SchoolRating class!';
            }
            $userId = $user->get('id');
            $this->modx->removeCollection('srActivityParticipant', ['user_id' => $userId]);
            $this->modx->removeCollection('srActivityWinner', ['user_id' => $userId]);
            $this->modx->removeCollection('srUserRating', ['user_id' => $userId]);
        }

        break;
}