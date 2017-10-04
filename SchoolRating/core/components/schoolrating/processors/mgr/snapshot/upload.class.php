<?php

class srActivitiesSnapshotUploadProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srActivitiesSnapshot';
    public $classKey = 'srActivitiesSnapshot';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';
    public $afterSaveEvent = 'srOnActivitiesSnapshotUpload';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $comment = trim($this->getProperty('comment'));
        if (empty($comment)) {
            $this->modx->error->addField('comment', $this->modx->lexicon('schoolrating_item_err_name'));
        } else {
            $mySqlDateFormat = 'Y-m-d H:i:s';
            $time = time();
            $date = date($mySqlDateFormat, $time);

            $filepath = $this->uploadFile();

            $this->setProperty('date', $date);
            $this->setProperty('filepath', $filepath);
        }

        return parent::beforeSet();
    }

    private function uploadFile()
    {
        $handle = new upload($_FILES['file']);
        if ($handle->uploaded) {
            $fileName = time();
            $handle->file_new_name_body = $fileName;
            $handle->process(MODX_BASE_PATH . srActivitiesSnapshot::DOCUMENTS_DIR);
            if ($handle->processed) {
                $filepath = MODX_BASE_URL . srActivitiesSnapshot::DOCUMENTS_DIR . $handle->file_dst_name;
                $handle->clean();
                return $filepath;
            } else {
                $this->addFieldError('file', $handle->error);
            }
        } else {
            $this->addFieldError('file', 'file not uploaded');
        }
        return;
    }

}

return 'srActivitiesSnapshotUploadProcessor';