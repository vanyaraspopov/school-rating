<?php

class srActivityParticipantEmailMultipleProcessor extends modObjectProcessor
{
    public $objectType = 'srActivityParticipant';
    public $classKey = 'srActivityParticipant';
    public $languageTopics = array('schoolrating');
    /** @var string $afterSaveEvent The name of the event to fire after saving */
    public $afterSaveEvent = 'srOnParticipationAllow';
    //public $permission = 'remove';

    /** @var modResource $activity */
    public $activity;
    /** @var modUser[] $users */
    public $users;

    /**
     * Can be used to provide custom methods prior to processing. Return true to tell MODX that the Processor
     * initialized successfully. If you return anything else, MODX will output that return value as an error message.
     *
     * @return boolean
     */
    public function initialize()
    {
        return true;
    }

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $canSend = $this->beforeSend();
        if (!$canSend) {
            return $this->failure();
        }

        $this->activity = $this->modx->getObject('modResource', $this->getProperty('resource_id'));

        $q = $this->modx->newQuery('modUser');
        $q->leftJoin('modUserProfile', 'Profile');
        $q->leftJoin('srActivityParticipant', 'Participant', 'Participant.user_id = modUser.id');
        $q->select($this->modx->getSelectColumns('modUser', 'modUser', ''));
        $q->select($this->modx->getSelectColumns('modUserProfile', 'Profile', ''));
        $q->where([
            'Participant.id:IN' => explode(',', $this->getProperty('ids'))
        ]);
        $this->users = $this->modx->getCollection('modUser', $q);

        $this->emailUsers($this->getProperty('subject'), $this->getProperty('text'));

        return $this->success();
    }

    public function beforeSend()
    {
        $ids = explode(',', $this->getProperty('ids'));
        if (empty($ids)) {
            $this->addFieldError('ids', $this->modx->lexicon('schoolrating_item_err_ns'));
        }

        $resource_id = $this->getProperty('resource_id');
        if (empty($resource_id)) {
            $this->addFieldError('resource_id', $this->modx->lexicon('schoolrating_activity_err_ns'));
        }

        $subject = $this->getProperty('subject');
        if (empty($subject)) {
            $this->addFieldError('subject', 'Не указана тема письма');
        }

        $text = $this->getProperty('text');
        if (empty($text)) {
            $this->addFieldError('text', 'Не указан текст письма');
        }

        return !$this->hasErrors();
    }

    public function emailUsers($subject, $text)
    {
        $sender = $this->modx->getOption('emailsender', null);
        $siteName = $this->modx->getOption('site_name', null);
        $activityArray = $this->activity->toArray();
        try {
            foreach ($this->users as $user) {
                $mail = new PHPMailer();
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($sender, $siteName);

                //Content
                $mail->isHTML(true);    // Set email format to HTML
                $mail->Subject = $subject;
                $mail->AltBody = 'Для просмотра сообщения Вам нужен почтовый клиент, поддерживающий HTML';

                $userArray = $user->toArray();
                $extended = json_decode($userArray['extended']);
                unset($userArray['extended']);
                foreach ($extended as $k => $v) {
                    $userArray["extended.$k"] = $v;
                }

                $chunk = $this->modx->newObject('modChunk');
                $chunk->setContent($text);
                $chunk->setCacheable(false);
                $mail->Body = $chunk->process(array_merge($activityArray, $userArray));

                $mail->addAddress($userArray['email']);
                if (!$mail->send()) {
                    throw new Exception('Сообщение не отправилось. Email: ' . $userArray['email']);
                }
            }

            unset($mail);
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage());
        }
    }

}

return 'srActivityParticipantEmailMultipleProcessor';