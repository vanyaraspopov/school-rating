<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var SchoolRating $SchoolRating */
if (!$SchoolRating = $modx->getService('schoolrating', 'SchoolRating', $modx->getOption('schoolrating_core_path', null,
        $modx->getOption('core_path') . 'components/schoolrating/') . 'model/schoolrating/', $scriptProperties)
) {
    return 'Could not load SchoolRating class!';
}

$userId = $modx->getOption('userId', $scriptProperties, $modx->user->get('id'));
$tpl = $modx->getOption('tpl', $scriptProperties, 'sr-last-rating-tpl');
$sortby = $modx->getOption('sortby', $scriptProperties, 'id');
$sortdir = $modx->getOption('sortbir', $scriptProperties, 'DESC');
$limit = $modx->getOption('limit', $scriptProperties, 0);
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

// Build query
$c = $modx->newQuery('srUserRating');
$c->where(['user_id' => $userId]);
$c->sortby($sortby, $sortdir);
$c->limit($limit);
$items = $modx->getIterator('srUserRating', $c);

// Iterate through items
$list = array();
/** @var srUserRating $item */
foreach ($items as $item) {
    $list[] = $modx->getChunk($tpl, $item->toArray());
}

// Output
$output = implode($outputSeparator, $list);
if (!empty($toPlaceholder)) {
    // If using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder, $output);

    return '';
}
// By default just return output
return $output;
