<?php

/**
 * This is the model class for table "promosionprocedure".
 *
 * The followings are the available columns in table 'promosionprocedure':
 * @property integer $id
 * @property integer $diag
 * @property integer $number
 * @property integer $limt
 * @property string $date_start
 * @property string $date_end
 * @property string $price
 * @property integer $status
 * @property integer $fullprice
 * @property string $detail
 * @property integer $user_id
 * @property string $create_date
 */
class Promotionprocedure extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'promotionprocedure';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diag,number,limit,price,month,status', 'required'),
            array('diag, number, limit,,type, status, fullprice, user_id', 'numerical', 'integerOnly' => true),
            array('price', 'length', 'max' => 10),
            array('date_start, date_end, detail,month, create_date,year', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, diag, number, limit,month,type,year, date_start, date_end, price, status, fullprice, detail, user_id, create_date', 'safe', 'on' => 'search'),
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
            'diag' => 'หัตถการ',
            'number' => 'จำนวนครั้ง',
            'limit' => 'จำนวนจำกัด',
            'date_start' => 'วันที่เริ่มโปร',
            'date_end' => 'วันที่หมดโปร',
            'price' => 'ราคาทั้งคอร์ส',
            'status' => '0=active,1=nonactive',
            'fullprice' => 'ราคาเดิม',
            'detail' => 'รายละเอียด',
            'user_id' => 'ผู้บันทึก',
            'month' => 'ประจำเดือน',
            'year' => 'ประจำปี',
            'type' => 'ประเภท',
            //'level' => 'Level',
            //'service_id' => 'service_id',
            'create_date' => 'วันที่สร้าง',
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
        $criteria->compare('diag', $this->diag);
        $criteria->compare('number', $this->number);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_end', $this->date_end, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('fullprice', $this->fullprice);
        $criteria->compare('detail', $this->detail, true);
        $criteria->compare('user_id', $this->user_id);
        //$criteria->compare('level', $this->level, true);
        //$criteria->compare('service_id', $this->service_id);
        $criteria->compare('create_date', $this->create_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Promosionprocedure the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function Getpromotion($id) {
        $sql = "select p.*,d.diagname from promotionprocedure p inner join diag d on p.diag = d.diagcode where status = '0' and p.id = '$id'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function GetpromotionPatient($promotion, $pid) {
        $Model = new Promotionprocedure();
        $ProModel = $Model->Getpromotion($promotion);
        $ProRegis = Promotionprocedureservice::model()->findAll("promotion=:promotion and pid=:pid", array(":promotion" => $promotion, ":pid" => $pid));
        $count = count($ProRegis);
        $countresult = ($ProModel['number'] - $count);
        
        return "คอร์ส:: " . $ProModel['diagname'] . " " . $ProModel['number'] . " ครั้ง (คงเหลือ " . ($countresult) . " ครั้ง)";
    }
    
    public function GetpromotionPatientHistory($promotion, $pid,$service_id) {
        $Model = new Promotionprocedure();
        $ProModel = $Model->Getpromotion($promotion);
        $ProRegis = Promotionprocedureservice::model()->find("promotion=:promotion and pid=:pid and service_id=:service_id", array(":promotion" => $promotion, ":pid" => $pid,":service_id" => $service_id));
        $count = $ProRegis['level'];
        $countresult = ($ProModel['number'] - $count);
        
        return "คอร์ส:: " . $ProModel['diagname'] . " " . $ProModel['number'] . " ครั้ง (คงเหลือ " . ($countresult) . " ครั้ง)";
    }

    //ยอดคงเหลือ
    public function Getresultprice($pid,$promotion,$level){
        $Patient = Patient::model()->find("pid=:pid",array(":pid" => $pid));
        $patientID = $Patient['id'];
        $sql = "select * from service where patient_id = '$patientID' and promotion = '$promotion' order by id asc limit $level";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $sum = 0;
        foreach($result as $rs):
            $sum = $sum + $rs['price_total'];
        endforeach;
        return $sum;
    }

    public function GetresultPromotion($promotion,$pid,$service_id){
        $promotionRegis = Promotionprocedureregister::model()->find("pid=:pid and promotion=:promotion",array(":pid" => $pid,":promotion" => $promotion));
        $Model = new Promotionprocedure();
        $sql = "select * from promotionprocedureservice where promotion = '$promotion' and pid = '$pid' order by id desc limit 1";
        $ProRegis = Yii::app()->db->createCommand($sql)->queryRow();
        //$ProRegis = Promotionprocedureservice::model()->find("promotion=:promotion and pid=:pid and service_id=:service_id", array(":promotion" => $promotion, ":pid" => $pid,"service_id" => $service_id));
        $ProModel = $Model->Getpromotion($promotion);
        $resultpromotion = $this->Getresultprice($pid,$promotion,$ProRegis['level']);
        $resultfinal = ($ProModel['price'] - $resultpromotion);
        if($promotionRegis['status'] == "1"){
            $level = $ProRegis['level'];
        } else {
            $level = ($ProRegis['level']+1);
        }
        return " มาครั้งที่(".$ProRegis['level'].") ยอดคงเหลือ(".number_format($resultfinal,2)." บาท)";

    }
    
    public function GetresultPromotionHistory($promotion,$pid,$service_id){
        $Model = new Promotionprocedure();
        $sql = "select * from promotionprocedureservice where promotion = '$promotion' and pid = '$pid' and service_id = $service_id";
        $ProRegis = Yii::app()->db->createCommand($sql)->queryRow();
        //$ProRegis = Promotionprocedureservice::model()->find("promotion=:promotion and pid=:pid and service_id=:service_id", array(":promotion" => $promotion, ":pid" => $pid,"service_id" => $service_id));
        $ProModel = $Model->Getpromotion($promotion);
        $resultpromotion = $this->Getresultprice($pid,$promotion,$ProRegis['level']);
        $resultfinal = ($ProModel['price'] - $resultpromotion);
        return " มาครั้งที่(".$ProRegis['level'].") ยอดคงเหลือ(".number_format($resultfinal,2)." บาท)";

    }

}
