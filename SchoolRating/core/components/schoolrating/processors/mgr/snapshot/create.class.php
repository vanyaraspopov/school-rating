<?php

class srActivitiesSnapshotCreateProcessor extends modObjectCreateProcessor
{
    const DOCUMENTS_DIR = 'userdata/snapshots/';

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
        $filename = MODX_BASE_PATH . self::DOCUMENTS_DIR . $time . '.xlsx';
        $filepath = MODX_BASE_URL . self::DOCUMENTS_DIR . $time . '.xlsx';

        $this->setProperty('date', $date);
        $this->setProperty('filepath', $filepath);

        $activitiesData = $this->getActivitiesData();
        $this->createExcelDocument($filename, $activitiesData);

        return parent::beforeSet();
    }

    private function createExcelDocument($filename, $documentData)
    {
        $excel = new PHPExcel();
        $excelWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');

        foreach ($documentData as $rowNum => $data) {
            $i = 0;
            foreach ($data as $name => $value) {
                $excel->getActiveSheet()->setCellValueByColumnAndRow($i, $rowNum + 1, '' . $value);
                ++$i;
            }
        }
        $excelWriter->save($filename);
    }

    private function getActivitiesData()
    {
        $sr = $this->modx->getService('schoolrating', 'SchoolRating');
        $c = $this->modx->newQuery('modResource');
        $eventsFuture = $sr->config['eventsFuture'];
        $eventsPast = $sr->config['eventsPast'];
        if ($eventsFuture && $eventsPast) {
            $c->where([
                'parent:IN' => [$eventsFuture, $eventsPast]
            ]);
        }
        /* @var modResource[] $activities */
        $activities = $this->modx->getCollection('modResource', $c);
        $exportData = [
            //  Заголовки колонок
            array_merge(
                srActivitiesSnapshot::fields(),
                srActivitiesSnapshot::TVs()
            )
        ];
        foreach ($activities as $activity) {
            //  Поля ресурса
            $fieldLabels = srActivitiesSnapshot::fields();
            $fields = [];
            foreach ($fieldLabels as $field => $label) {
                $fields[] = $activity->get($field);
            }
            //  Значения TV
            $tvLabels = srActivitiesSnapshot::TVs();
            $TVs = [];
            foreach ($tvLabels as $tv => $label) {
                $TVs[] = $activity->getTVValue($tv);
            }
            $exportData[] = array_merge($fields, $TVs);
        }
        return $exportData;
    }
}

return 'srActivitiesSnapshotCreateProcessor';