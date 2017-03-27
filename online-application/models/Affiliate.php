<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "affiliate".
 *
 * @property integer $affiliate_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $telephone
 * @property string $fax
 * @property string $salt
 * @property string $HASH
 * @property string $company
 * @property string $website
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $postcode
 * @property integer $country_id
 * @property integer $zone_id
 * @property string $code
 * @property string $commission
 * @property string $tax
 * @property string $payment
 * @property string $cheque
 * @property string $paypal
 * @property string $bank_name
 * @property string $bank_branch_number
 * @property string $bank_swift_code
 * @property string $bank_account_name
 * @property string $bank_account_number
 * @property string $ip
 * @property integer $status
 * @property integer $approved
 * @property string $date_added
 *
 * @property Affiliatetransaction[] $affiliatetransactions
 */
class Affiliate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'affiliate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['affiliate_id', 'firstname', 'lastname', 'email', 'telephone', 'fax', 'salt', 'HASH', 'company', 'website', 'address_1', 'address_2', 'city', 'postcode', 'code', 'ip', 'status', 'approved', 'date_added'], 'required'],
            [['affiliate_id', 'country_id', 'zone_id', 'status', 'approved'], 'integer'],
            [['commission'], 'number'],
            [['date_added'], 'safe'],
            [['firstname', 'lastname', 'telephone', 'fax', 'company'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 96],
            [['salt', 'HASH'], 'string', 'max' => 50],
            [['website'], 'string', 'max' => 255],
            [['address_1', 'address_2', 'city'], 'string', 'max' => 128],
            [['postcode'], 'string', 'max' => 10],
            [['code', 'tax', 'paypal', 'bank_name', 'bank_branch_number', 'bank_swift_code', 'bank_account_name', 'bank_account_number'], 'string', 'max' => 64],
            [['payment'], 'string', 'max' => 6],
            [['cheque'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'affiliate_id' => Yii::t('app', 'Affiliate ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'email' => Yii::t('app', 'Email'),
            'telephone' => Yii::t('app', 'Telephone'),
            'fax' => Yii::t('app', 'Fax'),
            'salt' => Yii::t('app', 'Salt'),
            'HASH' => Yii::t('app', 'Hash'),
            'company' => Yii::t('app', 'Company'),
            'website' => Yii::t('app', 'Website'),
            'address_1' => Yii::t('app', 'Address 1'),
            'address_2' => Yii::t('app', 'Address 2'),
            'city' => Yii::t('app', 'City'),
            'postcode' => Yii::t('app', 'Postcode'),
            'country_id' => Yii::t('app', 'Country ID'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'code' => Yii::t('app', 'Code'),
            'commission' => Yii::t('app', 'Commission'),
            'tax' => Yii::t('app', 'Tax'),
            'payment' => Yii::t('app', 'Payment'),
            'cheque' => Yii::t('app', 'Cheque'),
            'paypal' => Yii::t('app', 'Paypal'),
            'bank_name' => Yii::t('app', 'Bank Name'),
            'bank_branch_number' => Yii::t('app', 'Bank Branch Number'),
            'bank_swift_code' => Yii::t('app', 'Bank Swift Code'),
            'bank_account_name' => Yii::t('app', 'Bank Account Name'),
            'bank_account_number' => Yii::t('app', 'Bank Account Number'),
            'ip' => Yii::t('app', 'Ip'),
            'status' => Yii::t('app', 'Status'),
            'approved' => Yii::t('app', 'Approved'),
            'date_added' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffiliatetransactions()
    {
        return $this->hasMany(Affiliatetransaction::className(), ['affiliateid' => 'affiliate_id']);
    }
}
