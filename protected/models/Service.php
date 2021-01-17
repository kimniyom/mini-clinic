<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $id
 * @property integer $branch
 * @property integer $patient_id
 * @property integer $diagcode
 * @property integer $price_total
 * @property integer $user_id
 * @property string $checkbody
 * @property string $service_date
 * @property string $service_result
 * @property string $comment
 * @property string $d_update
 */
class Service extends CActiveRecord {

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('branch, patient_id, diagcode, price_total, user_id', 'numerical', 'integerOnly' => true),
			array('checkbody, service_date, service_result, comment, d_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, branch, patient_id, diagcode, price_total, user_id, checkbody, service_date, service_result, comment, d_update', 'safe', 'on' => 'search'),
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
			'branch' => 'รหัสสาขา',
			'patient_id' => 'รหัสลูกค้า',
			'diagcode' => 'รหัสหัตถการ',
			'price_total' => 'ราคาหัตถการ(รวม)',
			'user_id' => 'ผู้ให้บริการ',
			'checkbody' => 'วันที่ตรวจร่างกาย',
			'service_date' => 'วันที่รับบริการ',
			'service_result' => 'ผลกการรักษา',
			'comment' => 'Comment',
			'd_update' => 'วันที่แก้ไขข้อมูล',
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
		$criteria->compare('branch', $this->branch);
		$criteria->compare('patient_id', $this->patient_id);
		$criteria->compare('diagcode', $this->diagcode);
		$criteria->compare('price_total', $this->price_total);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('checkbody', $this->checkbody, true);
		$criteria->compare('service_date', $this->service_date, true);
		$criteria->compare('service_result', $this->service_result, true);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('d_update', $this->d_update, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Service the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function Getseq($branch) {
		$sql = "SELECT p.id AS patient_id,s.id,p.`name`,p.images,p.lname,TIMESTAMPDIFF(YEAR,p.birth,NOW()) AS age,p.card,p.pid,p.sex,g.grad,s.`comment`,s.promotion
				FROM service s INNER JOIN patient p ON s.patient_id = p.id
				INNER JOIN `gradcustomer` g ON p.type = g.id
				WHERE s.branch = '$branch' AND s.`status` IN ('1','2') ORDER BY s.id ASC";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function GetseqEmployee($branch) {
		$sql = "SELECT p.id AS patient_id,s.id,p.`name`,p.images,p.lname,TIMESTAMPDIFF(YEAR,p.birth,NOW()) AS age,p.card,p.pid,p.sex,g.grad,s.`comment`,s.promotion
				FROM service s INNER JOIN patient p ON s.patient_id = p.id
				INNER JOIN `gradcustomer` g ON p.type = g.id
				WHERE s.branch = '$branch' AND s.`status` IN ('1') ORDER BY s.id ASC";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function GetseqSuccess($branch) {
		$sql = "SELECT s.id AS service_id,p.id AS patient_id,p.images,s.id,s.service_date,p.`name`,p.lname,TIMESTAMPDIFF(YEAR,p.birth,NOW()) AS age,p.card,p.pid,p.sex,g.grad,
						s.`comment`,s.promotion
				FROM service s INNER JOIN patient p ON s.patient_id = p.id
				INNER JOIN `gradcustomer` g ON p.type = g.id
				WHERE s.branch = '$branch' AND s.`status` = '3' ORDER BY s.id ASC";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function GetseqConfirm($branch) {
		$sql = "SELECT p.id AS patient_id,s.id,p.`name`,p.lname,TIMESTAMPDIFF(YEAR,p.birth,NOW()) AS age,p.card,p.pid,p.sex,g.grad,s.`comment`
				FROM service s INNER JOIN patient p ON s.patient_id = p.id
				INNER JOIN `gradcustomer` g ON p.type = g.id
				WHERE s.branch = '$branch' AND s.`status` = '4' ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

//update ไม่เอาราคายาไปคิด
	public function Listservice($service_id) {
		/*
			        $sql = "SELECT s.id,s.service_id,s.detail,1 AS number,s.price,s.price AS total,1 AS type,0 as item
								FROM service_detail s
								WHERE s.service_id = '$service_id'

								UNION ALL

								SELECT d.id,d.service_id,c.product_nameclinic AS detail,SUM(d.number) AS number,d.price,SUM(d.total) AS total,2 AS type,d.drug as item
								FROM service_drug d INNER JOIN center_stockproduct c ON d.drug = c.product_id
								WHERE d.service_id = '$service_id'
								GROUP BY d.drug

								UNION ALL

								SELECT a.id,a.service_id,d.diagname AS detail,1 AS number,a.diagprice AS price,a.diagprice AS total,3 AS type,a.diagcode as item
								FROM service_diag a INNER JOIN diag d ON a.diagcode = d.diagcode
								WHERE a.service_id = '$service_id'

								UNION ALL

								SELECT s.id,s.service_id,s.detail,1 AS number,s.price,s.price AS total,4 AS type,0 as item
								FROM service_etc s
								WHERE s.service_id = '$service_id'";
		*/
		$sql = "SELECT d.id,
							d.service_id,
							c.product_nameclinic AS detail,
							SUM(d.number) AS number,
							0 AS price,
							0 AS total,
							2 AS type,
							d.drug as item,
							drug_method AS method
					FROM service_drug d INNER JOIN center_stockproduct c ON d.drug = c.product_id
					WHERE d.service_id = '$service_id'
					GROUP BY d.drug";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function SUMservice($service_id) {
		$sql = "SELECT IFNULL(SUM(Q1.total),0) AS TOTAL
						FROM(
							SELECT s.service_id,s.detail,1 AS number,s.price,s.price AS total
							FROM service_detail s
							WHERE s.service_id = '$service_id'

							UNION ALL

							SELECT d.id AS service_id,'-' AS detail,'0' AS number,0 AS price,pricedrug AS total
							FROM service d
							WHERE d.id = '$service_id'

							UNION ALL

							SELECT a.service_id,d.diagname AS detail,1 AS number,a.diagprice,a.diagprice AS total
							FROM service_diag a INNER JOIN diag d ON a.diagcode = d.diagcode
							WHERE a.service_id = '$service_id'

							UNION ALL

							SELECT s.service_id,s.detail,1 AS number,s.price,s.price AS total
							FROM service_etc s
							WHERE s.service_id = '$service_id'
						) Q1 ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['TOTAL'];
	}

	public function GetdetailBillservice($service_id) {
		$sql = "SELECT s.service_date,s.branch,s.id AS service_id,s.pricedrug,s.appoint,
										p.card,p.`name`,p.lname,e.`name` AS empname,e.lname AS emplname,
										ed.`name` AS doctorname,ed.lname AS doctorlname,
										po.position AS positionemp,pod.position AS positiondoctor,b.branchname,
										s.promotion,p.pid,s.payment
						FROM service s INNER JOIN patient p ON s.patient_id = p.id
						INNER JOIN employee e ON s.user_bill = e.id
						INNER JOIN employee ed ON s.doctor = ed.id
						INNER JOIN position po ON e.position = po.id
						INNER JOIN position pod ON ed.position = pod.id
						INNER JOIN branch b ON s.branch = b.id
						WHERE s.id = '$service_id' ";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}

	function Procedure($serviceId) {
		$sql = "select * from service_detail where service_id = '$serviceId'";
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

}
