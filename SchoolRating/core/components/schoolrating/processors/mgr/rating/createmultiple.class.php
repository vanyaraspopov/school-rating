<?php

class srUserRatingCreateMultipleProcessor extends modProcessor
{
    public $objectType = 'srUserRating';
    public $classKey = 'srUserRating';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';

    public function process()
    {
        $sr = $this->modx->getService('schoolrating', 'SchoolRating');

        $ids = explode(',', $this->getProperty('user_ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('schoolrating_item_err_ns'));
        }

        foreach ($ids as $id) {
            $this->modx->runProcessor(
                'mgr/rating/create',
                array_merge($this->getProperties(), ['user_id' => $id]),
                [
                    'processors_path' => $sr->config['processorsPath']
                ]
            );
        }
    }
}

return 'srUserRatingCreateMultipleProcessor';