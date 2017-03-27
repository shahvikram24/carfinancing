<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[VehicleTypes]].
 *
 * @see VehicleTypes
 */
class VehicleTypesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VehicleTypes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VehicleTypes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
