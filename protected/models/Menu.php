<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id
 * @property string $menu
 * @property string $link
 * @property integer $active
 * @property string $icon
 */
class Menu extends CActiveRecord {

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly' => true),
			array('menu', 'length', 'max' => 100),
			array('link, icon', 'length', 'max' => 255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, menu, link, active, icon', 'safe', 'on' => 'search'),
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
			'menu' => 'เมนู',
			'link' => 'ลิงค์',
			'active' => 'Active',
			'icon' => 'Icon',
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
		$criteria->compare('menu', $this->menu, true);
		$criteria->compare('link', $this->link, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('icon', $this->icon, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	function Getrolemenu($user_id = null, $group = null) {
		$sql = "SELECT m.*,Q.menu_id
                   FROM menu m
                   LEFT JOIN
                   (
                    SELECT r.user_id,r.menu_id FROM role_menu r WHERE r.user_id = '$user_id'
                    ) Q ON m.id = Q.menu_id
		   WHERE m.active = '1' AND m.`group` = '$group'
                ORDER BY Q.user_id,m.order ASC";

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function GetcountRoleMenu($userId = "", $group = "") {
		$sql = "SELECT COUNT(*) AS total,g.groupname
                    FROM menu m INNER JOIN role_menu r ON m.id = r.`menu_id`
                    INNER JOIN groupmenu g ON  m.`group` = g.id
                    WHERE m.`group` ='$group'
                    AND r.user_id = '$userId' ";
		$rsCount = Yii::app()->db->createCommand($sql)->queryRow();
		return $rsCount['total'];
	}

	function GetgroupMenu() {
		$sql = "SELECT m.*,g.`groupname` FROM menu m
                    INNER JOIN groupmenu g ON m.`group` = g.`id`
                    WHERE m.`group` != ''
                    GROUP BY m.`group`
                    ORDER BY m.`group` ASC";
		$group = Yii::app()->db->createCommand($sql)->queryAll();
		return $group;
	}

}
