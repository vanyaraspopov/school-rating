<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var VerifyPhone $vp */
if (!$vp = $modx->getService('verifyphone', 'VerifyPhone', $modx->getOption('verifyphone_core_path', null,
        $modx->getOption('core_path') . 'components/verifyphone/') . 'model/verifyphone/', $scriptProperties)
) {
    return 'Could not load SchoolRating class!';
}

$phoneNumber = $modx->getOption('phoneNumber', $scriptProperties);

$vp->setSmscProvider();
$result = $vp->checkPhoneVerified($phoneNumber);
return $result;