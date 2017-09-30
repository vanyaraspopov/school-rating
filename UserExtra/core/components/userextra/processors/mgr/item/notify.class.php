<?php

class UserExtraNotifyProcessor extends modProcessor
{
    public $objectType = 'modUser';
    public $classKey = 'modUser';
    public $languageTopics = array('userextra');
    /** @var string $afterSaveEvent The name of the event to fire after saving */
    public $permission = '';

    /* @var PHPMailer $mail */
    public $mail;

    //  Свойства для отправки почты
    public $sender;
    public $siteName;
    public $subject;
    public $emailChunk;

    /**
     * Can be used to provide custom methods prior to processing. Return true to tell MODX that the Processor
     * initialized successfully. If you return anything else, MODX will output that return value as an error message.
     *
     * @return boolean
     */
    public function initialize()
    {
        $this->sender = $this->modx->getOption('emailsender', null, 'webmaster@lubactive.ru');
        $this->siteName = $this->modx->getOption('site_name', null, 'Школьный портал');

        $this->subject = $this->modx->lexicon('userextra_locking_notify_subject');
        $this->emailChunk = 'email-user-locked';

        $this->mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        $this->mail->CharSet = 'UTF-8';
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

        $ids = json_decode($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('userextra_item_err_ns'));
        }

        $success = true;
        foreach ($ids as $id) {
            /** @var modUser $this ->object */
            if (!$this->object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('userextra_item_err_nf'));
            }

            if ($profile = $this->object->getOne('Profile')) {
                $emailTo = $profile->get('email');
                $extended = $profile->get('extended');
                $emailChunkProps = [
                    'locking_expire' => $extended['locking_expire'],
                ];
                $success &= $this->sendMail($emailTo, $emailChunkProps);
            }
        }

        return $success ?
            $this->success($this->modx->lexicon('userextra_locking_notify_success')) :
            $this->failure($this->modx->lexicon('userextra_locking_notify_failed'));
    }

    private function sendMail($emailTo, $emailChunkProps)
    {
        /* @var PHPMailer $this->mail */
        try {
            $this->mail->setFrom($this->sender, $this->siteName);
            $this->mail->addAddress($emailTo);

            //Content
            $this->mail->isHTML(true);    // Set email format to HTML
            $this->mail->Subject = $this->subject;
            $this->mail->Body    = $this->modx->getChunk($this->emailChunk, $emailChunkProps);
            $this->mail->AltBody = 'Для просмотра сообщения Вам нужен почтовый клиент, поддерживающий HTML';

            if (!$this->mail->send()) {
                throw new Exception('Сообщение не отправилось.');
            }
            return true;
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage(), null, __METHOD__);
            return false;
        }
    }

}

return 'UserExtraNotifyProcessor';