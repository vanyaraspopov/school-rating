<?php

class srUserRatingReportCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'srUserRatingReport';
    public $classKey = 'srUserRatingReport';
    public $languageTopics = array('schoolrating');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $dateStart = trim($this->getProperty('date_start'));
        if (empty($dateStart)) {
            $this->modx->error->addField('date_start', 'date_start not set');
        }
        $dateEnd = trim($this->getProperty('date_end'));
        if (empty($dateEnd)) {
            $this->modx->error->addField('date_end', 'date_end not set');
        }

        $mySqlDateFormat = 'Y-m-d H:i:s';
        $date = date($mySqlDateFormat);
        $this->setProperty('date', $date);

        return parent::beforeSet();
    }

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
        $this->createTopList(
            $this->object->get('id'),
            $this->object->get('date_start'),
            $this->object->get('date_end'),
            $this->object->get('count')
        );
    }

    /**
     * creates list of top rated users
     * @param integer $reportId ID отчёта
     * @param string $dateStart Дата начала периода
     * @param string $dateEnd Дата конца периода
     * @param integer $limit Размер выборки
     */
    public function createTopList($reportId, $dateStart, $dateEnd, $limit = 0)
    {
        //  Getting data
        $c = $this->modx->newQuery('srUserRating');
        $c->select('srUserRating.user_id, SUM(srUserRating.rating) as rating_total');
        $c->where([
            'date:>=' => $dateStart,
            'AND:date:<=' => $dateEnd
        ]);
        $c->groupby('srUserRating.user_id');
        $c->sortby('rating_total', 'DESC');
        $c->limit($limit);
        $c->prepare();
        $sql = $c->toSQL();
        $statement = $this->modx->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        //  Creating list
        $ratingPosition = 1;
        foreach ($rows as $row) {
            $userRatingReportUser = $this->modx->newObject('srUserRatingReportUsers', [
                'report_id' => $reportId,
                'user_id' => $row['user_id'],
                'rating' => $row['rating_total'],
                'rating_position' => $ratingPosition
            ]);
            $userRatingReportUser->save();
            $ratingPosition++;
        }
    }
}

return 'srUserRatingReportCreateProcessor';