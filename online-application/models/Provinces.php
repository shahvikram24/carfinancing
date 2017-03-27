<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property integer $id
 * @property string $name
 * @property string $is_active
 *
 * @property Application[] $application
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provinces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_active'], 'string'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Province'),
            'is_active' => Yii::t('app', 'Is Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasMany(Application::className(), ['province_id' => 'id']);
    }
}
