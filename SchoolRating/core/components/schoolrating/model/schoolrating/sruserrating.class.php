<?php
class srUserRating extends xPDOSimpleObject {

    public function recalculateUserRating() {
        if ($user = $this->getOne('User')) {
            if ($profile = $user->getOne('Profile')) {
                $extended = $profile->get('extended');
                /* @var srUserRating[] $srUserRatingRecords */
                $srUserRatingRecords = $this->xpdo->getCollection('srUserRating', [
                    'user_id' => $this->get('user_id')
                ]);
                $rating = 0;
                foreach ($srUserRatingRecords as $record) {
                    $rating += $record->get('rating');
                }
                $extended['rating'] = $rating;
                $profile->set('extended', $extended);
                if (!$profile->save()) {
                    $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Ошибка сохранения рейтинга.', null, __METHOD__);
                }
            }
        }
    }

}