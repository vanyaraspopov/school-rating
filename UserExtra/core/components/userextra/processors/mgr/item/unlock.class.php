<?php
require_once MODX_CORE_PATH . 'model/modx/processors/security/user/update.class.php';

class UserExtraUnlockProcessor extends modUserUpdateProcessor
{
    public $objectType = 'modUser';
    public $classKey = 'modUser';
    public $languageTopics = array('userextra');
    /** @var string $afterSaveEvent The name of the event to fire after saving */
    public $permission = '';

    /**
     * Can be used to provide custom methods prior to processing. Return true to tell MODX that the Processor
     * initialized successfully. If you return anything else, MODX will output that return value as an error message.
     *
     * @return boolean
     */
    public function initialize() { return true; }

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = json_decode($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('userextra_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var modUser $this->object */
            if (!$this->object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('userextra_item_err_nf'));
            }

            $this->object->set('active', 1);
            if ($this->object->save()) {
                $profile = $this->object->getOne('Profile');
                if ($profile) {
                    $extended = $profile->get('extended');
                    unset($extended['locking_expire']);
                    $profile->set('extended', $extended);
                    $profile->save();
                }
                $this->fireAfterSaveEvent();
            }
        }

        return $this->success();
    }

}

return 'UserExtraUnlockProcessor';