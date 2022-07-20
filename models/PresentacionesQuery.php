<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Presentaciones]].
 *
 * @see Presentaciones
 */
class PresentacionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Presentaciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Presentaciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
