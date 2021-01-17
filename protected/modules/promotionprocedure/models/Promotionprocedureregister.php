<?php

/**
 * This is the model class for table "promotionprocedureregister".
 *
 * The followings are the available columns in table 'promotionprocedureregister':
 * @property integer $id
 * @property string $pid
 * @property integer $branch
 * @property integer $promotion
 * @property integer $status
 * @property string $create_date
 */
class Promotionprocedureregister extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promotionprocedureregister';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('branch, promotion, status', 'numerical', 'integerOnly'=>true),
			array('pid', 'length', 'max'=>20),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pid, branch, promotion, status, create_date', 'safe', 'on'=>'search'),
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
			'pid' => 'รหัสลูกค้า',
			'branch' => 'สาขา',
			'promotion' => 'รหัสโปรที่เลือก',
			'status' => '0 = ยังไม่ครบ,1=ครบ',
			'create_date' => 'วันที่ลงทะเบียน',
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
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('branch',$this->branch);
		$criteria->compare('promotion',$this->promotion);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promosionprocedureregister the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
