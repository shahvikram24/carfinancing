<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property integer $id
 * @property integer $vehicle_type_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property integer $month_of_birth
 * @property integer $day_of_birth
 * @property integer $year_of_birth
 * @property string $address
 * @property string $postal_code
 * @property integer $province_id
 * @property string $city
 * @property string $rent_or_own
 * @property integer $residence_years
 * @property string $monthly_payment
 * @property string $company_name
 * @property string $job_title
 * @property string $work_phone
 * @property string $monthly_income
 * @property string $sin_number
 * @property integer $years_on_job
 * @property integer $months_on_job
 *
 * @property VehicleTypes $vehicleType
 * @property Provinces $province
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicle_type_id', 'first_name', 'last_name', 'email', 'phone', 'month_of_birth', 'day_of_birth', 'year_of_birth', 'address', 'province_id', 'city', 'residence_years', 'monthly_payment', 'company_name', 'job_title', 'work_phone', 'monthly_income', 'years_on_job', 'months_on_job'], 'required'],
            [['vehicle_type_id', 'month_of_birth', 'day_of_birth', 'year_of_birth', 'province_id', 'residence_years', 'years_on_job', 'months_on_job', 'monthly_payment', 'phone', 'work_phone'], 'integer'],
            [['rent_or_own', 'notes'], 'string'],
            [['email'], 'email'],
            [['first_name', 'last_name', 'email', 'sin_number', 'city', 'company_name', 'job_title'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 80],
            [['postal_code'], 'match', 'pattern' => '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/'],
            [['monthly_income'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['vehicle_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleTypes::className(), 'targetAttribute' => ['vehicle_type_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vehicle_type_id' => Yii::t('app', 'Vehicle'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'month_of_birth' => Yii::t('app', 'Month Of Birth'),
            'day_of_birth' => Yii::t('app', 'Day Of Birth'),
            'year_of_birth' => Yii::t('app', 'Year Of Birth'),
            'address' => Yii::t('app', 'Address'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'province_id' => Yii::t('app', 'Province'),
            'city' => Yii::t('app', 'City'),
            'rent_or_own' => Yii::t('app', 'Rent Or Own'),
            'residence_years' => Yii::t('app', 'Residence Years'),
            'monthly_payment' => Yii::t('app', 'Monthly Payment'),
            'company_name' => Yii::t('app', 'Company Name / Employer'),
            'job_title' => Yii::t('app', 'Job Title / Occupation'),
            'work_phone' => Yii::t('app', 'Work Phone'),
            'monthly_income' => Yii::t('app', 'Monthly Income'),
            'sin_number' => Yii::t('app', 'Sin Number (Optional)'),
            'years_on_job' => Yii::t('app', 'Years On Job'),
            'months_on_job' => Yii::t('app', 'Months On Job'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleType()
    {
        return $this->hasOne(VehicleTypes::className(), ['id' => 'vehicle_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'province_id']);
    }
}
