<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'srOnParticipantCreate':

        $modx->log(modX::LOG_LEVEL_ERROR, 'Подана заявка на участие в мероприятии');

        break;
}