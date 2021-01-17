<?php

/**
 * This is the model class for table "center_stockunit".
 *
 * The followings are the available columns in table 'center_stockunit':
 * @property integer $id
 * @property string $unit
 */
class CenterStockunit extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'center_stockunit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('unit', 'required'),
            array('unit', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, unit', 'safe', 'on' => 'search'),
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
            'unit' => 'หน่วยนับ',
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
        $criteria->compare('unit', $this->unit, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CenterStockunit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function GetunitById($itemid = null) {
        $sql = "SELECT u.unit 
                FROM center_stockitem_name s INNER JOIN center_stockunit u ON s.unit = u.id 
                WHERE s.id = '$itemid'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        echo $result['unit'];
    }
    
    public function GetunitCutById($itemid = null) {
        $sql = "SELECT u.unit
                FROM center_stockitem_name s INNER JOIN center_stockunit u ON s.unitcut = u.id 
                WHERE s.id = '$itemid'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        echo $result['unit'];
    }

}
