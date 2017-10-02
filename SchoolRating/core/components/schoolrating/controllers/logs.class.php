<?php
require_once 'home.class.php';

/**
 * The logs manager controller for SchoolRating.
 *
 */
class SchoolRatingLogsManagerController extends SchoolRatingHomeManagerController
{
    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('schoolrating_logs');
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
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/grids/logs.grid.js');

        //  Panels
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/widgets/logs.panel.js');
        $this->addJavascript($this->SchoolRating->config['jsUrl'] . 'mgr/sections/logs.js');

        $this->addHtml('<script type="text/javascript">
        SchoolRating.config = ' . json_encode($this->SchoolRating->config) . ';
        SchoolRating.config.connector_url = "' . $this->SchoolRating->config['connectorUrl'] . '";
        SchoolRating.perm = ' . json_encode($this->SchoolRating->perm) . ';
        Ext.onReady(function() {
            MODx.load({ xtype: "schoolrating-page-logs"});
        });
        </script>
        ');
    }
}