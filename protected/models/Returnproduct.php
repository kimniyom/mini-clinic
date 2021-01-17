<?php

/**
 * This is the model class for table "returnproduct".
 *
 * The followings are the available columns in table 'returnproduct':
 * @property integer $id
 * @property integer $product_id
 * @property string $lotnumber
 * @property integer $number
 * @property string $product_price
 * @property string $price_total
 * @property integer $branch
 * @property integer $user_return
 * @property string $status
 * @property string $create_date
 */
class Returnproduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'returnproduct';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, number, branch, user_return', 'numerical', 'integerOnly'=>true),
			array('lotnumber, product_price', 'length', 'max'=>10),
			array('price_total', 'length', 'max'=>20),
			array('status', 'length', 'max'=>1),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, lotnumber, number, product_price, price_total, branch, user_return, status, create_date', 'safe', 'on'=>'search'),
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
			'product_id' => 'รหัสสินค้า(id)',
			'lotnumber' => 'ล๊อตที่',
			'number' => 'จำนวนสินค้า',
			'product_price' => 'ราคาต้นทุน  ณ วันที่ส่งคืน',
			'price_total' => 'ราคารวม',
			'branch' => 'สาขา',
			'user_return' => 'ผู้ส่งคืน',
			'status' => '1 = ปลายทาง Confirm',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('lotnumber',$this->lotnumber,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('price_total',$this->price_total,true);
		$criteria->compare('branch',$this->branch);
		$criteria->compare('user_return',$this->user_return);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Returnproduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
