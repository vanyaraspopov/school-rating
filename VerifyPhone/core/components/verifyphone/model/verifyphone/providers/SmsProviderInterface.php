<?php

interface SmsProviderInterface {

    /**
     * Инициализация необходимых свойств для работы
     * @param array $config Массив параметров
     */
    public function initialize($config);

    /**
     * Отправляет SMS
     * @param integer $phoneNumber Номер телефона
     * @param string $messageContent Содержание сообщения
     */
    public function sendSms($phoneNumber, $messageContent);

}