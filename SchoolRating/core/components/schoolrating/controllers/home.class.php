<?php

/**
 * The home manager controller for SchoolRating.
 *
 */
class SchoolRatingHomeManagerController extends modExtraManagerController
{
    /** @var SchoolRating $SchoolRating */
    public $SchoolRating;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('schoolrating_core_path', null,
                $this->modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/';
        $this->SchoolRating = $this->modx->getService('schoolrating', 'SchoolRating', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('schoolrating:default');
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
        return $this->modx->lexicon('schoolrating');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        /* CSS */
        $this->addCss($this->SchoolRating->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->SchoolRating->config['cssUrl'] . 'mgr/bootstrap.buttons.css');

        /* JS */
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/schoolrating.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/misc/combo.js');

        //  Combo boxes
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/misc/schoolrating.combo.js');

        //  Grids
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/coefficients.grid.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/sections.grid.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/rating.grid.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/activities.grid.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/activities-participants.grid.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/snapshots.grid.js');

        //  Windows
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/windows/coefficients.windows.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/windows/sections.windows.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/windows/rating.windows.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/windows/activities.windows.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/windows/snapshots.windows.js');

        //  Panels
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        SchoolRating.config = ' . json_encode($this->SchoolRating->config) . ';
        SchoolRating.config.connector_url = "' . $this->SchoolRating->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "schoolrating-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->SchoolRating->config['templatesPath'] . 'home.tpl';
    }
}