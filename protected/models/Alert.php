<?php

/**
 * This is the model class for table "alert".
 *
 * The followings are the available columns in table 'alert':
 * @property integer $id
 * @property integer $alert_appoint
 * @property integer $alert_product
 * @property integer $alert_expire
 */
class Alert extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'alert';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('alert_appoint,alert_product,alert_expire,alert_repair', 'required'),
            array('alert_appoint, alert_product, alert_expire,alert_repair', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, alert_appoint, alert_product, alert_expire,alert_repair', 'safe', 'on' => 'search'),
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
            'alert_appoint' => 'แจ้งเตือนก่อนถึงวันนัด',
            'alert_product' => 'แจ้งเตือนสินค้าใกล้หมด',
            'alert_expire' => 'แจ้งเตือนสินค้าใกล้หมดอายุ',
            'alert_repair' => 'แจ้งเตือนการซ่อม - บำรุง'
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
        $criteria->compare('alert_appoint', $this->alert_appoint);
        $criteria->compare('alert_product', $this->alert_product);
        $criteria->compare('alert_expire', $this->alert_expire);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Alert the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function Getalert() {
        $result = Alert::model()->find("id = '1'");
        return $result;
    }

    //นับจำนวนสินค้าใกล้หมด
    public function Countalertproduct($branch) {
        $sql = "SELECT COUNT(*) AS alert
            FROM(
            SELECT s.product_id,c.product_nameclinic,c.product_price,c.costs,u.unit,c.type_id,c.subproducttype,t.type_name AS category,pt.type_name,SUM(st.total) AS total
                    FROM clinic_stockproduct s 
                    INNER JOIN center_stockproduct c ON s.product_id = c.product_id 
                    INNER JOIN unit u ON c.unit = u.id 
                    INNER JOIN product_type t ON c.type_id = t.id 
                    INNER JOIN product_type pt ON c.subproducttype = pt.id 
                    INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                    WHERE 1=1 AND s.branch = '$branch'  AND st.flag = '0'
            GROUP BY s.product_id 
            ) Q WHERE Q.total < (SELECT alert_product FROM alert LIMIT 1) ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs['alert'];
    }

    public function ListAlertproduct() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT *
                    FROM(
                    SELECT s.product_id,
                            c.product_nameclinic,
                            c.product_price,
                            c.costs,
                            u.unit,
                            c.type_id,
                            c.subproducttype,
                            t.type_name AS category,
                            pt.type_name,
                            SUM(st.total) AS total
                    FROM clinic_stockproduct s 
                    INNER JOIN center_stockproduct c ON s.product_id = c.product_id 
                    INNER JOIN unit u ON c.unit = u.id 
                    INNER JOIN product_type t ON c.type_id = t.id 
                    INNER JOIN product_type pt ON c.subproducttype = pt.id 
                    INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                    WHERE s.branch = '$branch' AND st.flag = '0'
                    GROUP BY s.product_id
                    ) Q 
                    WHERE Q.total < (SELECT alert_product FROM alert LIMIT 1)";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    public function CountAlertExpire() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT COUNT(*) AS alert
                    FROM
                    (SELECT *
                    FROM(
                    SELECT s.product_id,
                            c.product_nameclinic,
                            c.product_price,
                            c.costs,
                            u.unit,
                            c.type_id,
                            c.subproducttype,
                            t.type_name AS category,
                            pt.type_name,
                            st.lotnumber,
                            st.expire,
                            DATEDIFF(st.expire,DATE(NOW())) AS dayexpire,
                            st.total
                    FROM clinic_stockproduct s 
                    INNER JOIN center_stockproduct c ON s.product_id = c.product_id 
                    INNER JOIN unit u ON c.unit = u.id 
                    INNER JOIN product_type t ON c.type_id = t.id 
                    INNER JOIN product_type pt ON c.subproducttype = pt.id 
                    INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                    WHERE s.branch = '$branch' AND st.total > 0 AND st.flag = '0'
                    GROUP BY st.product_id,st.expire
                    ) Q 
                    WHERE Q.dayexpire <= (SELECT alert_expire FROM alert LIMIT 1) ) Q ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs['alert'];
    }

    public function ListAlertExpire() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT *
                    FROM(
                    SELECT st.id,
                            s.product_id,
                            c.product_nameclinic,
                            c.product_price,
                            c.costs,
                            u.unit,
                            c.type_id,
                            c.subproducttype,
                            t.type_name AS category,
                            pt.type_name,
                            st.lotnumber,
                            st.expire,
                            DATEDIFF(st.expire,DATE(NOW())) AS dayexpire,
                            st.total
                    FROM clinic_stockproduct s 
                    INNER JOIN center_stockproduct c ON s.product_id = c.product_id 
                    INNER JOIN unit u ON c.unit = u.id 
                    INNER JOIN product_type t ON c.type_id = t.id 
                    INNER JOIN product_type pt ON c.subproducttype = pt.id 
                    INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                    WHERE s.branch = '$branch' AND st.total > 0 AND st.flag = '0'
                    GROUP BY st.product_id,st.expire
                    ) Q 
                    WHERE Q.dayexpire <= (SELECT alert_expire FROM alert LIMIT 1) ";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    public function CountExpire() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT COUNT(*) AS alert
                    FROM(SELECT * FROM(
                                        SELECT s.product_id,
                                                c.product_nameclinic,
                                                c.product_price,
                                                c.costs,
                                                u.unit,
                                                c.type_id,
                                                c.subproducttype,
                                                t.type_name AS category,
                                                pt.type_name,
                                                st.lotnumber,
                                                st.expire,
                                                DATEDIFF(st.expire,DATE(NOW())) AS dayexpire,
                                                st.total
                                        FROM clinic_stockproduct s 
                                        INNER JOIN center_stockproduct c ON s.product_id = c.product_id 
                                        INNER JOIN unit u ON c.unit = u.id 
                                        INNER JOIN product_type t ON c.type_id = t.id 
                                        INNER JOIN product_type pt ON c.subproducttype = pt.id 
                                        INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                                        WHERE s.branch = '$branch' AND st.total > 0 AND st.flag = '0'
                                        GROUP BY st.product_id,st.expire
                                        ) Q 
                                        WHERE Q.dayexpire <= 0
                    ) Q2";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs['alert'];
    }

    public function ListExpire() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT * FROM(
                    SELECT st.id,
                            s.product_id,
                            c.product_nameclinic,
                            c.product_price,
                            c.costs,
                            u.unit,
                            c.type_id,
                            c.subproducttype,
                            t.type_name AS category,
                            pt.type_name,
                            st.lotnumber,
                            st.expire,
                            DATEDIFF(st.expire,DATE(NOW())) AS dayexpire,
                            st.total
                    FROM clinic_stockproduct s 
                    INNER JOIN center_stockproduct c ON s.product_id = c.product_id 
                    INNER JOIN unit u ON c.unit = u.id 
                    INNER JOIN product_type t ON c.type_id = t.id 
                    INNER JOIN product_type pt ON c.subproducttype = pt.id 
                    INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                    WHERE s.branch = '$branch' AND st.total > 0 AND st.flag = '0'
                    GROUP BY st.product_id,st.expire
                    ) Q 
                    WHERE Q.dayexpire <= 0 ";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    public function Alertcenterstockitem() {
        $sql = "SELECT COUNT(*) AS total
                FROM center_stockitem_name i 

                INNER JOIN 
                (
                    SELECT c.itemid,SUM(c.totalcut) AS total
                    FROM center_stockitem c
                    WHERE c.outstock = 'F' AND c.totalcut > 0
                    GROUP BY c.itemid
                ) Q ON i.id = Q.itemid

                WHERE i.alert > Q.total ";
        return Yii::app()->db->createCommand($sql)->queryRow()['total'];
    }

    public function Listalertcenterstockitem() {
        $sql = "SELECT i.id,i.itemcode,i.itemname,Q.total,i.alert,u.unit
                FROM center_stockitem_name i 

                INNER JOIN 

                (
                    SELECT c.itemid,SUM(c.totalcut) AS total
                    FROM center_stockitem c
                    WHERE c.outstock = 'F' AND c.totalcut > 0
                    GROUP BY c.itemid
                ) Q ON i.id = Q.itemid

                INNER JOIN center_stockunit u ON i.unitcut = u.id
                WHERE i.alert > Q.total";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function Alertexpirecenterstockitem() {
        $sql = "SELECT COUNT(*) AS total
                FROM center_stockitem c INNER JOIN center_stockitem_name n ON c.itemid = n.id
                INNER JOIN center_stockunit u ON n.unitcut = u.id
                WHERE c.outstock = 'F' AND c.totalcut > 0 AND c.expire != ''
                AND DATE(NOW()) > c.expire ";
        return Yii::app()->db->createCommand($sql)->queryRow()['total'];
    }

    public function Listexpirecenterstockitem() {
        $sql = "SELECT c.id,c.itemid,n.itemcode,c.lotnumber,n.itemname,c.totalcut,c.expire,u.unit
                FROM center_stockitem c INNER JOIN center_stockitem_name n ON c.itemid = n.id
                INNER JOIN center_stockunit u ON n.unitcut = u.id
                WHERE c.outstock = 'F' AND c.totalcut > 0 AND c.expire != ''
                AND DATE(NOW()) > c.expire";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function AlertRepair() {
        $branch = Yii::app()->session['branch'];
        if($branch == "99"){
            $branchs = "";
        } else {
            $branchs = " AND r.branch = '$branch' ";
        }
        $sql = "SELECT COUNT(*) AS total
                FROM `repair` r 
                WHERE r.`status` = '0' $branchs
                AND DATEDIFF(r.date_alert,DATE(NOW())) < (SELECT a.alert_repair FROM alert a LIMIT 1) ";
        return Yii::app()->db->createCommand($sql)->queryRow()['total'];
    }
    
    public function ListAlertRepair() {
        $branch = Yii::app()->session['branch'];
        if($branch == "99"){
            $branchs = "";
        } else {
            $branchs = " AND r.branch = '$branch' ";
        }
        $sql = "SELECT *
                FROM `repair` r 
                WHERE r.`status` = '0' $branchs
                AND DATEDIFF(r.date_alert,DATE(NOW())) < (SELECT a.alert_repair FROM alert a LIMIT 1) AND DATEDIFF(r.date_alert,DATE(NOW())) > 0";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function AlertreturnProduct(){
        $sql = "select IFNULL(COUNT(*),0) AS total from returnproduct where status = '0'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs['total'];
    }

}
