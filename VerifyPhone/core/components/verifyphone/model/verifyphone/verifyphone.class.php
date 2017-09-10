<?php

include_once (__DIR__ . '/providers/SmsProviderInterface.php');
include_once (__DIR__ . '/providers/SmscProvider.php');

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
        $config = require(__DIR__ . '/providers/smsc.config.inc.php');
        $provider = new SmscProvider();
        if ($provider instanceof SmsProviderInterface) {
            $this->provider =& $provider;
            $this->provider->initialize($config);
        } else {
            throw new Exception('SMS-провайдер должен реализовать интерфейс SmsProviderInterface');
        }
    }

    public function sendVerificationCode($phoneNumber, $messageTpl)
    {
        if (!$this->provider) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Не установлен SMS-провайдер', null, __METHOD__);
            return false;
        }
        $code = $this->generateCode();

        $vpPhone = $this->modx->newObject(
            'vpPhone',
            [
                'phone' => $this->cleanPhoneNumber($phoneNumber),
                'code_hash' => md5($code)
            ]
        );

        if ($vpPhone->save()) {
            $messageContent = $this->modx->getChunk($messageTpl, ['code' => $code]);
            $this->provider->sendSms($phoneNumber, $messageContent);
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
                'phone' => $this->cleanPhoneNumber($phoneNumber)
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

    private function cleanPhoneNumber($phoneNumber)
    {
        return $phoneNumber;
    }
}