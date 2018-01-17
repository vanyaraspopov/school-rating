<?php
/** @var array $scriptProperties */

$filter = json_decode($scriptProperties['filter'], true);

$parents = $scriptProperties['parents'];
if (empty($parents)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Параметр parents не должен быть пустым');
    return;
}

$tvNameLevel = 'event-level';
$tvNameSection = 'event-section';
$tvNameDateStart = 'event-date-start';
$tvNameDateEnd = 'event-date-end';

$q = $modx->newQuery('modResource');
$q->distinct();
$q->select('modResource.id');
$q->where([
    'parent:IN' => explode(',',$parents)
]);

if (isset($filter['level'])) {
    $level = $filter['level'];
    $q->leftJoin('modTemplateVarResource', 'TV' . $tvNameLevel, "`TV$tvNameLevel`.contentid = modResource.id");
    $q->where([
        "`TV$tvNameLevel`.value" => $level
    ]);
}

if (isset($filter['section'])) {
    $section = $filter['section'];
    $q->leftJoin('modTemplateVarResource', 'TV' . $tvNameSection, "`TV$tvNameSection`.contentid = modResource.id");
    $q->where([
        "`TV$tvNameSection`.value" => $section
    ]);
}

if (isset($filter['date'])) {
    $mySqlDateFormat = 'Y-m-d';

    if (preg_match('~^\d{2}\.\d{2}\.\d{4}$~', $filter['date'])) {
        try {
            $date = new DateTime($filter['date']);
            $q->leftJoin('modTemplateVarResource', 'TV' . $tvNameDateEnd, "`TV$tvNameDateEnd`.contentid = modResource.id");
            $q->where("CAST(`TV$tvNameDateEnd`.value AS DATETIME) >= '" . $date->format($mySqlDateFormat) . "'");

            $dateAddDay = (new DateTime($filter['date']))->modify('+1 day');
            $q->leftJoin('modTemplateVarResource', 'TV' . $tvNameDateStart, "`TV$tvNameDateStart`.contentid = modResource.id");
            $q->where("CAST(`TV$tvNameDateStart`.value AS DATETIME) < '" . $dateAddDay->format($mySqlDateFormat) . "'");
        } catch (Exception $e) {
            $modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage());
        }
    } else {
        $modx->log(modX::LOG_LEVEL_ERROR, 'Фильтр date должен быть в формате DD.MM.YYYY');
    }

}

$q->prepare();
$sql = $q->toSQL();

$results = $modx->query($sql);
$ids = [];
while ($r = $results->fetch(PDO::FETCH_ASSOC)) {
    $ids[] = $r['id'];
}
if (empty($ids)) {
    //  Если под фильтр ничего не подходит выводим ID несуществующего ресурса
    return '99999999999999999999999999999999999';
}
return implode(',', $ids);