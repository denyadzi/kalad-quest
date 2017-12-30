<?php

namespace app\filters;

use yii\filters\AccessRule;

/**
 * @inheritdoc
 */
class QuestAdminAccessRule extends AccessRule
{
    /**
     * @inheritdoc
     */
    public function matchRole($user)
    {
        $items = empty($this->roles) ? [] : $this->roles;

        if (!empty($this->permissions)) {
            $items = array_merge($items, $this->permissions);
        }

        if (empty($items)) {
            return true;
        }

        if ($user === false) {
            throw new InvalidConfigException('The user application component must be available to specify roles in AccessRule.');
        }

        foreach ($items as $item) {
            if ($item === '?' && $user->getIsGuest()) {
                return true;
            }

            if ($item === '@' && !$user->getIsGuest()) {
                return true;
            }

            if (is_int ($item) && ! $user->getIsGuest() && $user->identity->role == $item) {
                return true;
            }
        }
        return false;
    }
}

