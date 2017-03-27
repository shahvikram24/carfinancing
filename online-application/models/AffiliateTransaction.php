<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "affiliatetransaction".
 *
 * @property integer $affiliatetransactionid
 * @property integer $affiliateid
 * @property integer $contactinfoid
 * @property string $description
 * @property string $amount
 * @property string $dateadded
 * @property integer $status
 *
 * @property Contact $contactinfo
 * @property Affiliate $affiliate
 */
class AffiliateTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'affiliatetransaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['affiliateid', 'contactinfoid', 'description', 'amount', 'dateadded'], 'required'],
            [['affiliateid', 'contactinfoid', 'status'], 'integer'],
            [['description'], 'string'],
            [['amount'], 'number'],
            [['dateadded'], 'safe'],
            [['contactinfoid'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contactinfoid' => 'id']],
            [['affiliateid'], 'exist', 'skipOnError' => true, 'targetClass' => Affiliate::className(), 'targetAttribute' => ['affiliateid' => 'affiliate_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'affiliatetransactionid' => Yii::t('app', 'Affiliatetransactionid'),
            'affiliateid' => Yii::t('app', 'Affiliateid'),
            'contactinfoid' => Yii::t('app', 'Contactinfoid'),
            'description' => Yii::t('app', 'Description'),
            'amount' => Yii::t('app', 'Amount'),
            'dateadded' => Yii::t('app', 'Dateadded'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactinfo()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contactinfoid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffiliate()
    {
        return $this->hasOne(Affiliate::className(), ['affiliate_id' => 'affiliateid']);
    }
}
