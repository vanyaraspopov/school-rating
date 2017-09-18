<?php

class srActivitiesSnapshotCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srActivitiesSnapshot';
    public $classKey = 'srActivitiesSnapshot';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $mySqlDateFormat = 'Y-m-d H:i:s';
        $time = time();
        $date = date($mySqlDateFormat, $time);

        $filepath = $this->uploadFile();

        $this->setProperty('date', $date);
        $this->setProperty('filepath', $filepath);

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

return 'srActivitiesSnapshotCreateProcessor';