<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Medicamentosalmacen]].
 *
 * @see Medicamentosalmacen
 */
class MedicamentosalmacenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Medicamentosalmacen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Medicamentosalmacen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
