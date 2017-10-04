<?php

class srActivitiesSnapshotApplyProcessor extends modObjectProcessor
{
    public $objectType = 'srActivitiesSnapshot';
    public $classKey = 'srActivitiesSnapshot';
    public $languageTopics = array('schoolrating');
    //public $permission = 'remove';
    /** @var boolean $checkViewPermission If set to true, will check the view permission on modAccessibleObjects */
    public $checkViewPermission = true;
    public $afterApplyEvent = 'srOnActivitiesSnapshotApply';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize()
    {
        $primaryKey = $this->getProperty($this->primaryKeyField, false);
        if (empty($primaryKey)) return $this->modx->lexicon($this->objectType . '_err_ns');
        $this->object = $this->modx->getObject($this->classKey, $primaryKey);
        if (empty($this->object)) return $this->modx->lexicon($this->objectType . '_err_nfs', array($this->primaryKeyField => $primaryKey));

        if ($this->checkViewPermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('view')) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $importData = $this->parseDocument(MODX_BASE_PATH . $this->object->get('filepath'));
        if (!$this->validateData($importData)) {
            return $this->failure('Данные, спарсенные из файла excel, не прошли валидацию');
        }


        if ($this->applyDataToActivities($importData)) {
            $this->fireAfterApplyEvent();
            return $this->success();
        } else {
            return $this->failure('В результате применения снимка произошли ошибки.');
        }
    }

    private function applyDataToActivities($data)
    {
        $isError = false;
        $fields = srActivitiesSnapshot::fields();
        $TVs = srActivitiesSnapshot::TVs();

        $dataLength = count($data);
        for ($i = 1; $i < $dataLength; $i++) {  //  i - итератор по строкам, первую строку с заголовками пропускаем
            $k = 0;     //  Итератор по столбцам

            $id = $data[$i][0];
            $parentDefault = $data[$i][1] ? $data[$i][1] : $this->modx->getOption('schoolrating_events_future');

            /* @var modResource $activity */
            $activity = $this->modx->getObject('modResource', $id);
            if (!$activity) {
                $activity = $this->modx->newObject('modResource');
            }

            foreach ($fields as $f => $v) {
                if ($f === 'id') {
                    $k++;
                    continue;
                }
                if ($f === 'parent') {
                    $activity->set('parent', $data[$i][$k] ? $data[$i][$k] : $parentDefault);
                    $k++;
                    continue;
                }
                $activity->set($f, $data[$i][$k] ? $data[$i][$k] : '');
                $k++;
            }

            $activity->set('hidemenu', 1);
            if (!$activity->save()) {
                $isError = true;
                $this->addFieldError($activity->get('id'), 'Ошибка сохранения');
            } else {
                if ($activity->get('template')){
                    foreach ($TVs as $tv => $v) {
                        $activity->setTVValue($tv, $data[$i][$k] ? $data[$i][$k] : '');
                        $k++;
                    }
                }
            }
        }

        return !$isError;
    }

    /**
     * @param string $filepath Путь к файлу .xlsx
     * @return array Спарсенный документ в виде массива
     */
    private function parseDocument($filepath)
    {
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($filepath);

        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();

        //этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
        $array = array();
        //получим итератор строки и пройдемся по нему циклом
        foreach ($aSheet->getRowIterator() as $row) {
            //получим итератор ячеек текущей строки
            $cellIterator = $row->getCellIterator();
            //пройдемся циклом по ячейкам строки
            //этот массив будет содержать значения каждой отдельной строки
            $item = array();
            foreach ($cellIterator as $cell) {
                //заносим значения ячеек одной строки в отдельный массив
                array_push($item, $cell->getCalculatedValue());
            }
            //заносим массив со значениями ячеек отдельной строки в "общий массв строк"
            array_push($array, $item);
        }

        return $array;
    }

    private function validateData($data)
    {
        $isError = false;

        if (!is_array($data)) {
            $this->addFieldError('data_parsed', 'Не является массивом');
            $isError = true;
        }

        if (count($data) === 0) {
            $this->addFieldError('data_parsed', 'Массив пуст');
            $isError = true;
        } else {
            $fields = srActivitiesSnapshot::fields();
            $TVs = srActivitiesSnapshot::TVs();
            if (count($data[0]) !== count($fields) + count($TVs)) {
                $this->addFieldError('data_parsed', 'Количество столбцов в спарсенном документе не соответствует количеству, описанному в классе srActivitiesSnapshot');
                $isError = true;
            }
        }

        return !$isError;
    }

    /**
     * If specified, fire the after remove event
     * @return void
     */
    public function fireAfterApplyEvent() {
        if (!empty($this->afterApplyEvent)) {
            $this->modx->invokeEvent($this->afterApplyEvent,array(
                $this->primaryKeyField => $this->object->get($this->primaryKeyField),
                $this->objectType => &$this->object,
                'object' => &$this->object,
            ));
        }
    }

}

return 'srActivitiesSnapshotApplyProcessor';