<?php

/**
 * This is the model class for table "promotionprocedureservice".
 *
 * The followings are the available columns in table 'promotionprocedureservice':
 * @property integer $id
 * @property integer $promotion
 * @property string $pid
 * @property string $price
 * @property integer $employee
 * @property string $create_date
 */
class Promotionprocedureservice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promotionprocedureservice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promotion, employee', 'numerical', 'integerOnly'=>true),
			array('pid', 'length', 'max'=>20),
			array('price', 'length', 'max'=>10),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, promotion, pid, price, employee, create_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'promotion' => 'รหัสโปร',
			'pid' => 'รหัสลูกค้า',
			'price' => 'การชำระเงิน',
			'employee' => 'พนักงาน / หมอ',
			'create_date' => 'วันที่ทำรายการ',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('promotion',$this->promotion);
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promotionprocedureservice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
