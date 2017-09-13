<?php

include_once(__DIR__ . '/providers/SmsProviderInterface.php');
include_once(__DIR__ . '/providers/SmscProvider.php');

class VerifyPhone
{
    /* Длина генерируемого кода */
    const VP_CODE_LENGTH = 6;

    /** @var modX $modx */
    public $modx;

    /** @var SmsProviderInterface $provider */
    public $provider;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('verifyphone_core_path', $config,
            $this->modx->getOption('core_path') . 'components/verifyphone/'
        );
        $assetsUrl = $this->modx->getOption('verifyphone_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/verifyphone/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $usergroupUsers = $this->modx->getOption('verifyphone_usergroup_users');

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',

            'usergroupUsers' => $usergroupUsers,
        ), $config);

        $this->modx->addPackage('verifyphone', $this->config['modelPath']);
        $this->modx->lexicon->load('verifyphone:default');
    }

    public function setSmscProvider()
    {
        $provider = new SmscProvider();
        if ($provider instanceof SmsProviderInterface) {
            $config = require(__DIR__ . '/providers/smsc.config.inc.php');
            $config = array_merge($config, [
                'sender' => $this->modx->getOption('site_name'),
            ]);
            $this->provider =& $provider;
            $this->provider->initialize($config);
        } else {
            throw new Exception('SMS-провайдер должен реализовывать интерфейс SmsProviderInterface');
        }
    }

    public function sendVerificationCode($phoneNumber, $messageTpl)
    {
        if (!$this->provider) {
            $message = 'Не установлен SMS-провайдер';
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message, null, __METHOD__);
            return $message;
        }

        $cleanNumber = self::cleanPhoneNumber($phoneNumber);
        if ($this->modx->getCount('vpPhone', ['phone' => $cleanNumber])) {
            $message = 'Такой номер телефона уже есть: ' . $phoneNumber;
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message, null, __METHOD__);
            return $message;
        }

        $code = $this->generateCode();

        $vpPhone = $this->modx->newObject(
            'vpPhone',
            [
                'phone' => $cleanNumber,
                'code' => ($code)
            ]
        );

        if ($vpPhone->save()) {
            $messageContent = $this->modx->getChunk($messageTpl, ['code' => $code]);
            try {
                $this->provider->sendSms($phoneNumber, $messageContent);
            } catch (Exception $e) {
                $vpPhone->delete();
                return $e->getMessage();
            }
            return;
        } else {
            return 'Ошибка записи нового телефона: ' . $phoneNumber;
        }
    }

    public function checkVerificationCode($phoneNumber, $code)
    {
        $vpPhone = $this->modx->getObject(
            'vpPhone',
            [
                'phone' => self::cleanPhoneNumber($phoneNumber)
            ]
        );
        if( $vpPhone->get('code') === ($code) ) {
            $vpPhone->set('verified', 1);
            if ( !$vpPhone->save() ) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'Ошибка сохранения объекта', null, __METHOD__);
            }
            return true;
        } else {
            return false;
        }
    }

    public function checkPhoneVerified($phoneNumber)
    {
        $vpPhone = $this->modx->getObject(
            'vpPhone',
            [
                'phone' => self::cleanPhoneNumber($phoneNumber)
            ]
        );
        if ($vpPhone) {
            return $vpPhone->get('verified');
        } else {
            return false;
        }
    }

    private function generateCode()
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < self::VP_CODE_LENGTH; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function cleanPhoneNumber($phoneNumber)
    {
        return $phoneNumber;
    }
}