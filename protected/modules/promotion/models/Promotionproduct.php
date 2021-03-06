<?php

/**
 * This is the model class for table "promotionproduct".
 *
 * The followings are the available columns in table 'promotionproduct':
 * @property integer $id
 * @property string $product_id
 * @property integer $number
 * @property integer $limit
 * @property string $price
 * @property integer $active
 * @property string $create_date
 */
class Promotionproduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promotionproduct';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promotionname,product_id,price,number,active','required'),
			array('number, limit, active', 'numerical', 'integerOnly'=>true),
			array('product_id, price,priceold', 'length', 'max'=>10),
			array('create_date', 'safe'),
			array('promotionname', 'length'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, number, limit, price, active, create_date,priceold,promotionname', 'safe', 'on'=>'search'),
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
			'product_id' => 'รหัสสินค้า',
			'promotionname' => 'ชื่อโปรโมชั่น',
			'number' => 'จำนวน',
			'limit' => 'จำนวนจำกัด',
			'price' => 'ราคา',
			'priceold' => 'ราคาเดิม',
			'active' => 'สถานะ',
			'create_date' => 'วันที่บันทึก',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('limit',$this->limit);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promotionproduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
