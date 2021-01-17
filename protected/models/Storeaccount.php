<?php

/**
 * This is the model class for table "storeaccount".
 *
 * The followings are the available columns in table 'storeaccount':
 * @property integer $id
 * @property string $accountnumber
 * @property string $accountname
 * @property integer $bank
 * @property string $bankbranch
 */
class Storeaccount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'storeaccount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('accountnumber,accountname,bank','required'),
			array('bank', 'numerical', 'integerOnly'=>true),
			array('accountnumber', 'length', 'max'=>20),
			array('accountname, bankbranch', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accountnumber, accountname, bank, bankbranch', 'safe', 'on'=>'search'),
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
			'accountnumber' => 'เลขบัญชี',
			'accountname' => 'ชื่อบัญชี',
			'bank' => 'ธนาคาร',
			'bankbranch' => 'สาขา',
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
		$criteria->compare('accountnumber',$this->accountnumber,true);
		$criteria->compare('accountname',$this->accountname,true);
		$criteria->compare('bank',$this->bank);
		$criteria->compare('bankbranch',$this->bankbranch,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Storeaccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function getbank(){
		$sql = "select s.id,s.accountname,s.accountnumber,s.bank,s.bankbranch,b.bankname 
				from storeaccount s inner join bank b on s.bank = b.id";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function statement($accountnumber){
		$sql = "select * from logsell where accountnumber = '$accountnumber'";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
}
