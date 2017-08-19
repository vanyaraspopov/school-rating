<?php

/**
 * The home manager controller for UserExtra.
 *
 */
class UserExtraHomeManagerController extends modExtraManagerController
{
    /** @var UserExtra $UserExtra */
    public $UserExtra;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('userextra_core_path', null,
                $this->modx->getOption('core_path') . 'components/userextra/') . 'model/userextra/';
        $this->UserExtra = $this->modx->getService('userextra', 'UserExtra', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('userextra:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('userextra');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->UserExtra->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->UserExtra->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/userextra.js');
        $this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/misc/combo.js');
        //$this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        //$this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->UserExtra->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        UserExtra.config = ' . json_encode($this->UserExtra->config) . ';
        UserExtra.config.connector_url = "' . $this->UserExtra->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "userextra-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->UserExtra->config['templatesPath'] . 'home.tpl';
    }
}