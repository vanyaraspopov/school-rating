<?php

class srUserRatingReportUsersGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'srUserRatingReportUsers';
    public $classKey = 'srUserRatingReportUsers';
    public $languageTopics = array('schoolrating:default');
    public $defaultSortField = 'rating_position';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'view';

    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->select($this->modx->getSelectColumns('srUserRatingReportUsers', 'srUserRatingReportUsers'));

        $c->leftJoin('modUserProfile', 'Profile', 'srUserRatingReportUsers.user_id = Profile.internalKey');
        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', null, ['fullname', 'extended']));

        $reportId = trim($this->getProperty('report_id'));
        $c->where([
            'report_id' => $reportId,
        ]);

        //  Обработка формы поиска
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'Profile.fullname:LIKE' => "%{$query}%",
            ]);
        }

        return $c;
    }
}

return 'srUserRatingReportUsersGetListProcessor';