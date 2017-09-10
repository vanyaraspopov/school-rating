<?php

class VerifyPhone
{
    /** @var modX $modx */
    public $modx;


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

}