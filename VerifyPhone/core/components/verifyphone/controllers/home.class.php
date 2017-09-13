<?php

/**
 * The home manager controller for VerifyPhone.
 *
 */
class VerifyPhoneHomeManagerController extends modExtraManagerController
{
    /** @var VerifyPhone $VerifyPhone */
    public $VerifyPhone;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('verifyphone_core_path', null,
                $this->modx->getOption('core_path') . 'components/verifyphone/') . 'model/verifyphone/';
        $this->VerifyPhone = $this->modx->getService('verifyphone', 'VerifyPhone', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('verifyphone:default');
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
        return $this->modx->lexicon('verifyphone');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->VerifyPhone->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->VerifyPhone->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/verifyphone.js');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/widgets/phones.grid.js');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/widgets/phones.windows.js');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->VerifyPhone->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        VerifyPhone.config = ' . json_encode($this->VerifyPhone->config) . ';
        VerifyPhone.config.connector_url = "' . $this->VerifyPhone->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "verifyphone-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->VerifyPhone->config['templatesPath'] . 'home.tpl';
    }
}