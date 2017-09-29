<?php

class SchoolRating
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

        $corePath = $this->modx->getOption('schoolrating_core_path', $config,
            $this->modx->getOption('core_path') . 'components/schoolrating/'
        );
        $assetsUrl = $this->modx->getOption('schoolrating_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/schoolrating/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $usergroupUsers = $this->modx->getOption('schoolrating_usergroup_users');
        $eventsFuture = $this->modx->getOption('schoolrating_events_future');
        $eventsPast = $this->modx->getOption('schoolrating_events_past');

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
            'eventsFuture' => $eventsFuture,
            'eventsPast' => $eventsPast,
        ), $config);

        $this->perm = array(
            'snapshots' => $this->modx->hasPermission('snapshots'),
            'edit_sections' => $this->modx->hasPermission('edit_sections'),
            'edit_coefficients' => $this->modx->hasPermission('edit_coefficients')
        );

        $this->modx->addPackage('schoolrating', $this->config['modelPath']);
        $this->modx->lexicon->load('schoolrating:default');
    }

}