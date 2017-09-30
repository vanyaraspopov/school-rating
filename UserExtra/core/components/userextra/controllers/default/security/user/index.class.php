<?php
/**
 * Loads the user list
 *
 * @package modx
 * @subpackage manager.controllers
 */
class UserExtraSecurityUserManagerController extends modManagerController {
    /**
     * Check for any permissions or requirements to load page
     * @return bool
     */
    public function checkPermissions() {
        return $this->modx->hasPermission('view_user');
    }

    /**
     *
     */
    public function initialize()
    {
        $corePath = $this->modx->getOption('userextra_core_path', null,
            $this->modx->getOption('core_path') . 'components/userextra/'
        );
        $assetsUrl = $this->modx->getOption('userextra_assets_url', null,
            $this->modx->getOption('assets_url') . 'components/userextra/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

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
        ), $this->config);
        parent::initialize();
    }

    /**
     * Register custom CSS/JS for the page
     * @return void
     */
    public function loadCustomCssJs() {
        $cssUrl = $this->config['cssUrl'];
        $jsUrl = $this->config['jsUrl'];
        $this->addCss($cssUrl . 'mgr/main.css');
        $this->addCss($cssUrl . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($jsUrl . 'mgr/userextra.js');
        $this->addJavascript($jsUrl . 'mgr/misc/utils.js');
        $this->addJavascript($jsUrl . 'mgr/misc/combo.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/items.grid.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/locking.grid.js');
        //$this->addJavascript($jsUrl . 'mgr/widgets/items.windows.js');
        $this->addJavascript($jsUrl . 'mgr/widgets/home.panel.js');
        $this->addJavascript($jsUrl . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
            UserExtra.config = ' . json_encode($this->config) . ';
            UserExtra.config.connector_url = "' . $this->config['connectorUrl'] . '";
            Ext.onReady(function() {
                MODx.load({ xtype: "userextra-page-home"});
            });
        </script>
        ');
    }

    /**
     * Custom logic code here for setting placeholders, etc
     * @param array $scriptProperties
     * @return mixed
     */
    public function process(array $scriptProperties = array()) {}

    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('userextra');
    }

    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->config['templatesPath'] . 'home.tpl';
    }

    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('userextra:default');
    }

    /**
     * Get the Help URL
     * @return string
     */
    public function getHelpUrl() {
        return 'Users';
    }
}