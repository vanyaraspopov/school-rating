<?php
/**
 * Outputs last ratings of user
 *
 * @package schoolrating
 * @subpackage controllers
 */
class srLastRatingController extends SchoolRatingController  {
    public $isAuthenticated = false;

    public function initialize() {
        $this->setDefaultProperties(array(
            'username' => null,
            'tpl' => 'sr-last-rating-tpl'
        ));

        $this->isAuthenticated = $this->modx->user->isAuthenticated('web');
    }

    /**
     * Process the controller
     * @return string
     */
    public function process() {
        $content = $this->render();
        return $this->output($content);
    }

    /**
     * Render output
     * @return string
     */
    public function render() {
        $tpl = $this->getProperty('tpl');

        $phs = $this->getProperties();
        
        /* Escape placeholder values */
        foreach ($phs as $k => $v) {
            $phs[$k] = htmlspecialchars(str_replace(array('[',']'),array('&#91;','&#93;'),$v));
        }

        return $this->modx->getChunk($tpl,$phs);
    }

    /**
     * Either output the content or set it as a placeholder
     * @param string $content
     * @return string
     */
    public function output($content = '') {
        $toPlaceholder = $this->getProperty('toPlaceholder','');
        if (!empty($toPlaceholder)) {
            $this->modx->setPlaceholder($toPlaceholder,$content);
            return '';
        }
        return $content;
    }
}
return 'srLastRatingController';
