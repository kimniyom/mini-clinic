<?php

/**
 * This is the model class for table "items".
 *
 * The followings are the available columns in table 'items':
 * @property integer $id
 * @property string $itemcode
 * @property string $product_id
 * @property integer $delete_flag
 * @property integer $status
 * @property string $expire
 * @property string $date_input
 * @property string $d_update
 */
class Items extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('delete_flag, status', 'numerical', 'integerOnly' => true),
            array('itemcode', 'length', 'max' => 50),
            array('product_id', 'length', 'max' => 20),
            array('expire, date_input, d_update', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, itemcode, product_id, delete_flag, status, expire, date_input, d_update', 'safe', 'on' => 'search'),
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
            'itemcode' => 'รหัสสินค้าชิ้นนั้น',
            'product_id' => 'รหัสสินค้า',
            'delete_flag' => '0 = ยังไม่ถูกลบ,1 = ลบสินค้าแล้ว',
            'status' => '0 = ขาย,1 = ยังไม่ขาย',
            'expire' => 'วันที่หมดอายุ',
            'date_input' => 'วันที่นำเข้า',
            'd_update' => 'วันที่อัพเดท',
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
        $criteria->compare('itemcode', $this->itemcode, true);
        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('delete_flag', $this->delete_flag);
        $criteria->compare('status', $this->status);
        $criteria->compare('expire', $this->expire, true);
        $criteria->compare('date_input', $this->date_input, true);
        $criteria->compare('d_update', $this->d_update, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Items the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function GetItem($productID = null) {
        $sql = "SELECT *,DATEDIFF(expire,NOW()) AS day_expire FROM items WHERE product_id = '$productID' AND status = '0' ORDER BY expire ASC";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function CountItems($productID = null) {
        $sql = "SELECT COUNT(*) AS TOTAL FROM items WHERE product_id = '$productID' AND  items.status='' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs['TOTAL'];
    }

    public function DayExpire($expire = null) {
        if ($expire <= 0) {
            $status = "<button type='button' class='btn btn-danger btn-xs'>" . $expire . " วัน</button>";
        } else if ($expire <= 30) {
            $status = "<button type='button' class='btn btn-warning btn-xs'>" . $expire . " วัน</button>";
        } else {

            $status = "<button type='button' class='btn btn-success btn-xs'>" . ceil($expire / 30) . " เดือน</button>";
        }

        return $status;
    }

    public function GetItemSell() {
        $branch = Yii::app()->session['branch'];
        if ($branch == '99') {
            $where = "";
        } else {
            $where = " AND p.branch = '$branch' ";
        }
        $sql = "SELECT i.itemcode,i.itemcode AS itemname FROM items i INNER JOIN product p ON i.product_id = p.product_id WHERE i.status = '0' $where";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        return $result;
    }
    
    /*
    public function GetProductSell() {
        $branch = Yii::app()->session['branch'];
        if ($branch == '99') {
            $where = " 1=1";
        } else {
            $where = " i.branch = '$branch' ";
        }
        $sql = "SELECT p.product_id,p.product_nameclinic AS product_name
                FROM clinic_stockproduct i INNER JOIN center_stockproduct p ON i.product_id = p.product_id WHERE $where";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        return $result;
    }
    */
    public function GetProductSell() {
        $month = date("m");
        if(strlen($month) < 2){
            $months = "0".$month;
        } else {
            $months = $month;
        }
        $sql = "SELECT p.product_id,p.product_nameclinic AS product_name,p.product_nameclinic AS detail,p.product_price,'1' as type
                FROM center_stockproduct p 

                UNION

                SELECT d.diagcode,d.diagname,d.diagname AS detail,d.price,'2' as type
                FROM diag d 

                UNION 

                SELECT p.id,d.diagname,CONCAT(d.diagname,'(',p.detail,')') as detail,p.price,'3' as type
                FROM promotionprocedure p INNER JOIN diag d ON p.diag = d.diagcode
                WHERE p.`month` = '' OR p.`month` IS NULL OR p.`month` = null

                UNION

                SELECT p.id,d.diagname,CONCAT(d.diagname,'(',p.detail,')') as detail,p.price,'3' as type
                FROM promotionprocedure p INNER JOIN diag d ON p.diag = d.diagcode
                WHERE p.`month` = '$months' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        return $result;
    }

}
