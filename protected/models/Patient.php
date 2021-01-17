<?php

/**
 * This is the model class for table "patient".
 *
 * The followings are the available columns in table 'patient':
 * @property integer $id
 * @property string $pid
 * @property string $card
 * @property string $oid
 * @property string $name
 * @property string $lname
 * @property string $birth
 * @property string $sex
 * @property integer $type
 * @property integer $branch
 * @property integer $emp_id
 * @property string $create_date
 * @property string $d_update
 */
class Patient extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'patient';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('oid, name, lname, birth, sex, type, branch, create_date,tel', 'required'),
            array('type, branch, emp_id,tel', 'numerical', 'integerOnly' => true),
            array('pid', 'length', 'max' => 10),
            array('tel', 'length', 'min' => 10, 'max' => 10),
            array('card', 'length', 'max' => 20),
            array('oid,occupation', 'length', 'max' => 3),
            array('name, lname,images', 'length', 'max' => 100),
            array('email, contact', 'length', 'max' => 255),
            array('sex', 'length', 'max' => 1),
            array('birth, create_date, d_update', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, pid, card, oid, name, lname, birth, sex, type, branch, emp_id,images, create_date, d_update,occupation', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'pid' => 'รหัสลูกค้า',
            'card' => 'บัตรประชาชน',
            'oid' => 'คำนำหน้า',
            'name' => 'ชื่อ',
            'lname' => 'นามสกุล',
            'birth' => 'วันเกิด',
            'sex' => 'เพศ',
            'type' => 'ประเภทลูกค้า',
            'branch' => 'สาขาที่รับบริการ',
            'emp_id' => 'ผู้บันทึกข้อมูล',
            'images' => 'รูปภาพ',
            'create_date' => 'วันที่ลงทะเบียน',
            'd_update' => 'วันที่อัพเดทข้อมูล',
            'occupation' => 'อาชีพ',
            'tel' => 'เบอร์โทรศัพท์',
            'email' => 'อีเมล์',
            'contact' => 'ที่อยู่'
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('pid', $this->pid, true);
        $criteria->compare('card', $this->card, true);
        $criteria->compare('oid', $this->oid, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('lname', $this->lname, true);
        $criteria->compare('birth', $this->birth, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('branch', $this->branch);
        $criteria->compare('emp_id', $this->emp_id);
        $criteria->compare('tel', $this->tel);
        $criteria->compare('email', $this->email);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('d_update', $this->d_update, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Patient the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function GetPatient() {
        $branch = Yii::app()->session['branch'];
        if ($branch == '99') {
            $where = " 1=1";
        } else {
            $where = " branch = '$branch' ";
        }
        $sql = "SELECT id,card,CONCAT(name,' ',lname) AS name FROM patient WHERE $where";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        return $result;
    }

    public function GetPatientAll() {
        $sql = "SELECT id,card,CONCAT(name,' ',lname) AS name FROM patient";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        return $result;
    }

    public function GetpatientId($id) {
        $sql = "SELECT p.*,g.grad,g.distcount,g.distcountsell
                FROM patient p INNER JOIN gradcustomer g ON p.type = g.id
                WHERE p.id = '$id' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();

        return $result;
    }

    public function GetpatientCard($card) {
        $sql = "SELECT p.*,g.grad,g.distcount,g.distcountsell
                FROM patient p INNER JOIN gradcustomer g ON p.type = g.id
                WHERE p.card = '$card' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();

        return $result;
    }

    public function GetpatientPid($pid) {
        $sql = "SELECT p.*,g.grad,g.distcount,g.distcountsell
                FROM patient p LEFT JOIN gradcustomer g ON p.type = g.id
                WHERE p.pid = '$pid' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();

        return $result;
    }

    public function GetlistpromotionRegister($pid) {
        $sql = "SELECT d.diagname,d.price,p.price as pricepromotion,r.pid,r.promotion,p.number
                FROM promotionprocedureregister r INNER JOIN promotionprocedure p ON r.promotion = p.id
                INNER JOIN diag d ON p.diag = d.diagcode
                WHERE r.pid = '$pid'  AND r.`status` = '0' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        return $result;
    }

}
