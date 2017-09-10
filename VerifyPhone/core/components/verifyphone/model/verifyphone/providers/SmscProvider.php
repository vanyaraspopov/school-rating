<?php

use \SMSCenter\SMSCenter;

/**
 * @property SMSCenter $_smsc
 * @property array $_config
 */
class SmscProvider implements SmsProviderInterface
{
    private $_smsc;
    private $_config;

    public function initialize($config)
    {
        $this->_config = $config;
        $login = $config['login'];
        $password = $config['password'];
        $this->_smsc = new SMSCenter(
            $login,
            md5($password),
            false,
            [
                'charset' => SMSCenter::CHARSET_UTF8,
                'fmt' => SMSCenter::FMT_XML
            ]
        );
    }

    public function sendSms($phoneNumber, $messageContent)
    {
        if (!$this->_smsc) {
            throw new Exception('SMS-провайдер не проинициализирован');
        }
        $sender = $this->_config['sender'];
        $this->_smsc->send($phoneNumber, $messageContent, $sender);
    }
}