<?php

/**
 * This is the model class for table "center_stockitem_name".
 *
 * The followings are the available columns in table 'center_stockitem_name':
 * @property integer $id
 * @property string $itemcode
 * @property string $itemname
 * @property integer $price
 * @property integer $unit
 */
class CenterStockitemName extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'center_stockitem_name';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemcode,itemname,price,unit,unitcut,alert','required'),
			array('price, unit,unitcut', 'numerical', 'integerOnly'=>true),
			array('itemcode,alert', 'length', 'max'=>10),
			array('itemname', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, itemcode, itemname, price, unit,unitcut', 'safe', 'on'=>'search'),
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
			'itemcode' => 'รหัสitem',
			'itemname' => 'ชื่อItem',
			'price' => 'ราคา / หน่วย',
			'unit' => 'หน่วยนับ',
            'unitcut' => 'หน่วยตัดสต๊อก',
            'alert' => 'แจ้งเตือนใกล้หมด'
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
		$criteria->compare('itemcode',$this->itemcode,true);
		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('unit',$this->unit);
                $criteria->compare('unitcut',$this->unitcut);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CenterStockitemName the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
