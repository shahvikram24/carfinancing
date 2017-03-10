<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_types".
 *
 * @property integer $id
 * @property string $keyword
 * @property integer $is_default
 * @property string $name
 * @property string $photo
 *
 * @property Application[] $application
 */
class VehicleTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_default'], 'integer'],
            [['name', 'photo'], 'required'],
            [['keyword', 'name'], 'string', 'max' => 12],
            [['photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'keyword' => Yii::t('app', 'Keyword'),
            'is_default' => Yii::t('app', 'Is Default'),
            'name' => Yii::t('app', 'Vehicle'),
            'photo' => Yii::t('app', 'Photo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasMany(Application::className(), ['vehicle_type_id' => 'id']);
    }
}
