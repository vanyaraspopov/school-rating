<?php
/**
 * Update a user from a grid
 *
 * @param integer $id The ID of the user
 *
 * @package modx
 * @subpackage processors.security.user
 */
class UserExtraUpdateFromGridProcessor extends modObjectUpdateProcessor {
    public $classKey = 'modUser';
    public $languageTopics = array('user');
    //public $permission = 'save_user';
    public $objectType = 'user';
    public $beforeSaveEvent = 'OnBeforeUserFormSave';
    public $afterSaveEvent = 'OnUserFormSave';

    /** @var modUser $object */
    public $object;
    /** @var modUserProfile $profile */
    public $profile;

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function beforeSave() {
        $this->setProfile();
        return parent::beforeSave();
    }

    public function initialize() {
        $data = $this->getProperty('data');
        if (empty($data)) return $this->modx->lexicon('invalid_data');
        $data = $this->modx->fromJSON($data);

        if ($data['agreement_filepath']) {
            $data['extended']['agreement_filepath'] = $data['agreement_filepath'];
        }
        if ($data['agreement_deadline']) {
            $data['extended']['agreement_deadline'] = $data['agreement_deadline'];
        }
        if ($data['locking_expire']) {
            $data['extended']['locking_expire'] = $data['locking_expire'];
        }

        unset($data['agreement_filepath']);
        unset($data['agreement_deadline']);
        unset($data['locking_expire']);

        if (empty($data)) return $this->modx->lexicon('invalid_data');
        $this->setProperties($data);
        $this->unsetProperty('data');
        return parent::initialize();
    }

    /**
     * Set the profile data for the user
     * @return modUserProfile
     */
    public function setProfile() {
        $this->profile = $this->object->getOne('Profile');
        if (empty($this->profile)) {
            $this->profile = $this->modx->newObject('modUserProfile');
            $this->profile->set('internalKey',$this->object->get('id'));
            $this->profile->save();
            $this->object->addOne($this->profile,'Profile');
        }
        $data = $this->getProperties();
        $data['extended'] = array_merge($this->profile->get('extended'), $data['extended']);
        $this->profile->fromArray($data);
        return $this->profile;
    }
}
return 'UserExtraUpdateFromGridProcessor';