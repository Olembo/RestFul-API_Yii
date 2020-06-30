<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property int $phoneNumber
 */
class Customer extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phoneNumber'], 'required'],
            [['phoneNumber'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    public function scenarios()  {         
    $scenarios = parent::scenarios();         
    $scenarios['create'] = ['name','phoneNumber'];         
    return $scenarios;     
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phoneNumber' => 'Phone Number',
        ];
    }
}
