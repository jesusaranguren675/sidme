<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BackendUser]].
 *
 * @see BackendUser
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BackendUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BackendUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
