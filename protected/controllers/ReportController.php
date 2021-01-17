<?php

class ReportController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'template_backend';

	/**
	 * @return array action filters
	 */

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionReportinputproductmonth() {
		$monthnow = date("m");
		if (strlen($monthnow) < 2) {
			$monthactive = "0" . $monthnow;
		} else {
			$monthactive = $monthnow;
		}
		$data['monthactive'] = $monthactive;
		$data['month'] = Month::model()->findAll();
		$this->render('reportinputproductmonth', $data);
	}

	public function actionDatainputproductmonth() {
		$year = Yii::app()->request->getPost('year');
		$month = Yii::app()->request->getPost('month');
		$branch = Yii::app()->request->getPost('branch');
		$monthval = (int) $month;
		if ($monthval == "1") {
			$months = "01";
			$monthlast = "12";
			$yearsstart = ($year - 1);
			$years = $year;
		} else {
			$months = $month;
			$yearsstart = $year;
			$years = $year;
			$monthlasts = $monthval - 1;
			if (strlen($monthlasts) < 2) {
				$monthlast = "0" . $monthlasts;
			} else {
				$monthlast = $monthlasts;
			}
		}

		//echo $yearsstart." last = ".$monthlast." ".$years."monthnow = ".$months;
		$data['monthnow'] = $months;
		$data['monthlast'] = $monthlast;
		$data['yearnow'] = $years;
		$data['yearlast'] = $yearsstart;
		$data['sellmonthnow'] = $this->Getproductmonthnow($years, $months, $branch);
		$data['sellmonthlast'] = $this->Getproductmonthnow($yearsstart, $monthlast, $branch);

		$this->renderPartial('datareportinputproductmonth', $data);
	}

	function Getproductmonthnow($year, $month, $branch) {
		$sql = "SELECT Q1.product_id,Q1.product_name,Q1.product_nameclinic,IFNULL(Q2.total,0) AS total,Q1.unit,Q1.costs
                FROM
                (
                SELECT cs.product_id,cs.product_name,cs.product_nameclinic,st.costs,u.unit
                 FROM clinic_stockproduct st INNER JOIN center_stockproduct cs ON st.product_id = cs.product_id
                LEFT JOIN unit u ON st.unit = u.id
                WHERE st.branch = '$branch'
                ) Q1

                LEFT JOIN

                (
                        SELECT cs.product_id,cs.product_nameclinic,cs.product_name,SUM(c.number) AS total
                        FROM clinic_stockproduct s INNER JOIN clinic_storeproduct c ON s.product_id = c.product_id AND s.branch = c.branch
                        INNER JOIN center_stockproduct cs ON s.product_id = cs.product_id
                        WHERE LEFT(c.generate,4) = '$year' AND SUBSTR(c.generate,6,2) = '$month' AND s.branch = '$branch'
                        GROUP BY cs.product_id
                ) Q2 ON Q1.product_id = Q2.product_id ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function actionGetproductmonthlast($branch, $month) {

	}

	public function actionReportcostprofit() {
		$branch = Yii::app()->session['branch'];
		if ($branch == "99") {
			$data['branchlist'] = Branch::model()->findAll();
		} else {
			$data['branchlist'] = Branch::model()->findAll("id=:id", array(":id" => $branch));
		}
		$this->render('reportcostprofit', $data);
	}

	public function actionDatareportcostprofit() {
		$year = Yii::app()->request->getPost('year');
		$branch = Yii::app()->request->getPost('branch');
		$ReportModel = new Report();

		//$data['Cost'] = $ReportModel->Getcostproduct($year, $branch);
		//$data['Sell'] = $ReportModel->Gettotalsell($year, $branch);

		$data['income'] = $ReportModel->GetIncome($year, $branch); //รายได้,คำนวนจากการรักษาการขายสินค้าแต่ละสาขา
		$data['outcome'] = $ReportModel->GetOutcome($year, $branch); //รายจ่าย,คำนวนจากค่าซ่อมบำรุงแต่ละสาขา
		//ต้นทุน กำไรรายไตรมาส
		$data['incomeperiod1'] = $ReportModel->GetIncomePeriod($year, $branch, 1);
		$data['incomeperiod2'] = $ReportModel->GetIncomePeriod($year, $branch, 2);
		$data['incomeperiod3'] = $ReportModel->GetIncomePeriod($year, $branch, 3);
		$data['incomeperiod4'] = $ReportModel->GetIncomePeriod($year, $branch, 4);

		$data['outcomeperiod1'] = $ReportModel->GetOutcomePeriod($year, $branch, 1);
		$data['outcomeperiod2'] = $ReportModel->GetOutcomePeriod($year, $branch, 2);
		$data['outcomeperiod3'] = $ReportModel->GetOutcomePeriod($year, $branch, 3);
		$data['outcomeperiod4'] = $ReportModel->GetOutcomePeriod($year, $branch, 4);

		//กำไรขาดทุนรายเดือน

		$incomeMonth = $ReportModel->GetIncomeMonth($year, $branch);
		$outcomeMonth = $ReportModel->GetOutcomeMonth($year, $branch);

		foreach ($incomeMonth as $cm):
			$Month[] = "'" . $cm['month_th'] . "'";
			$IncomeMonthArr[] = $cm['total'];
			$tablemonthIncome[$cm['id']] = $cm['total'];
		endforeach;

		foreach ($outcomeMonth as $pm):
			$OutcomeMonthArr[] = $pm['total'];
			$tablemonthOutcome[$pm['id']] = $pm['total'];
		endforeach;

		$data['IncomeMonth'] = implode(",", $IncomeMonthArr);
		$data['OutcomeMonth'] = implode(",", $OutcomeMonthArr);
		$data['month'] = implode(",", $Month);
		$data['year'] = $year;
		$data['masmonth'] = Month::model()->findAll();
		$data['tablemonthIncome'] = $tablemonthIncome;
		$data['tablemonthOutcome'] = $tablemonthOutcome;
		$this->renderPartial('datareportcostprofit', $data);
	}

	public function actionReportproductsalable() {
		$this->render('reportproductsalable');
	}

	public function actionDataproductsalable() {
		$year = Yii::app()->request->getPost('year');
		$branch = Yii::app()->request->getPost('branch');
		$ReportModel = new Report();
		$ProductSalable = $ReportModel->ProductSalable($year, $branch);
		$catArr = array();
		$valAll = array();
		foreach ($ProductSalable as $rs):
			$catArr[] = "'" . $rs['product_name'] . "'";
			$valAll[] = $rs['total'];
		endforeach;

		$data['category'] = implode(",", $catArr);
		$data['value'] = implode(",", $valAll);
		$data['year'] = $year;
		$data['product'] = $ProductSalable;
		$this->renderPartial('dataproductsalable', $data);
	}

	public function actionReportsellproduct() {
		$this->render('reportsellproduct');
	}

	public function actionDatareportsellproduct() {
		$branch = Yii::app()->request->getPost('branch');
		$datestart = Yii::app()->request->getPost('datestart');
		$dateend = Yii::app()->request->getPost('dateend');
		$Model = new Report();
		$data['sell'] = $Model->ReportSellproduct($datestart, $dateend, $branch);
		$data['count'] = count($data['sell']);
		$data['sumsell'] = $Model->ReportSumSellproduct($datestart, $dateend, $branch);
		$emplomaxyeesell = $Model->EmployeeMaxSell($datestart, $dateend, $branch);
		$data['empname'] = $emplomaxyeesell['alias'];
		$data['empsell'] = $emplomaxyeesell['totals'];
		$ChartType = $Model->CountReportProductInType($datestart, $dateend, $branch);

		$typeArr = array();
		foreach ($ChartType as $typechart):
			$typeName = $typechart['type_name'];
			$total = $typechart['total'];
			$typeArr[] = "['" . $typeName . "',$total]";
		endforeach;
		$data['charttype'] = implode(",", $typeArr);

		$this->renderPartial('datareportsellproduct', $data);
	}

	public function actionFormreportprofitcenter() {
		$this->render('formreportprofitcenter');
	}

	public function actionReportprofitcenter() {
		$year = Yii::app()->request->getPost('year');
		$Model = new ReportStoreCenter();
		$data['year'] = $year;
		$data['head'] = "รายงานรายรับ - รายจ่าย ปี พ.ศ. " . ($year + 543);
		$data['income'] = $Model->GetSumIncome($year)['total'];
		$data['outcome'] = $Model->GetSumOutcome($year)['total'];
		$Chart = $Model->GetchartProfit($year);
		foreach ($Chart as $key) {
			$incomeArr[] = $key['income'];
			$outcomeArr[] = $key['outcome'];
			$profitArr[] = $key['profit'];
		}

		$data['chartincome'] = implode(",", $incomeArr);
		$data['chartoutcome'] = implode(",", $outcomeArr);
		$data['chartprofit'] = implode(",", $profitArr);

		$data['datas'] = $Chart;

		$this->renderPartial('reportprofitcenter', $data);
	}

	public function actionReportbranch() {
		$branch = Yii::app()->session['branch'];
		if ($branch == "99") {
			$data['branchlist'] = Branch::model()->findAll();
		} else {
			$data['branchlist'] = Branch::model()->findAll("id=:id", array(":id" => $branch));
		}
		$this->render('reportbranch', $data);
	}

	public function actionDatareportcostprofitcenter() {
		$year = Yii::app()->request->getPost('year');
		$branch = '99';
		$ReportModel = new Report();

		//$data['Cost'] = $ReportModel->Getcostproduct($year, $branch);
		//$data['Sell'] = $ReportModel->Gettotalsell($year, $branch);

		$data['income'] = $ReportModel->GetIncome($year, $branch); //รายได้,คำนวนจากการรักษาการขายสินค้าแต่ละสาขา
		$data['outcome'] = $ReportModel->GetOutcomeCenter($year); //รายจ่าย,คำนวนจากค่าซ่อมบำรุงแต่ละสาขา
		//ต้นทุน กำไรรายไตรมาส
		$data['incomeperiod1'] = $ReportModel->GetIncomePeriod($year, $branch, 1);
		$data['incomeperiod2'] = $ReportModel->GetIncomePeriod($year, $branch, 2);
		$data['incomeperiod3'] = $ReportModel->GetIncomePeriod($year, $branch, 3);
		$data['incomeperiod4'] = $ReportModel->GetIncomePeriod($year, $branch, 4);

		$data['outcomeperiod1'] = $ReportModel->GetOutcomePeriodCenter($year, $branch, 1);
		$data['outcomeperiod2'] = $ReportModel->GetOutcomePeriodCenter($year, $branch, 2);
		$data['outcomeperiod3'] = $ReportModel->GetOutcomePeriodCenter($year, $branch, 3);
		$data['outcomeperiod4'] = $ReportModel->GetOutcomePeriodCenter($year, $branch, 4);

		//กำไรขาดทุนรายเดือน

		$incomeMonth = $ReportModel->GetIncomeMonth($year, $branch);
		$outcomeMonth = $ReportModel->GetOutcomeMonthCenter($year, $branch);

		foreach ($incomeMonth as $cm):
			$Month[] = "'" . $cm['month_th'] . "'";
			$IncomeMonthArr[] = $cm['total'];
			$tablemonthIncome[$cm['id']] = $cm['total'];
		endforeach;

		foreach ($outcomeMonth as $pm):
			$OutcomeMonthArr[] = $pm['total'];
			$tablemonthOutcome[$pm['id']] = $pm['total'];
		endforeach;

		$data['IncomeMonth'] = implode(",", $IncomeMonthArr);
		$data['OutcomeMonth'] = implode(",", $OutcomeMonthArr);
		$data['month'] = implode(",", $Month);
		$data['year'] = $year;
		$data['masmonth'] = Month::model()->findAll();
		$data['tablemonthIncome'] = $tablemonthIncome;
		$data['tablemonthOutcome'] = $tablemonthOutcome;
		$this->renderPartial('datareportcostprofitcenter', $data);
	}

	public function actionReportsellall($date = "", $branch = "") {
		$branchs = Yii::app()->session['branch'];
		/*
					$sql = "SELECT l.sell_id,IFNULL(e.`name`,'ไม่ระบุ') AS `name`,IFNULL(e.lname,'') AS lname,l.total,l.date_sell
			                FROM logsell l LEFT JOIN patient e ON l.pid = e.pid
			                WHERE l.date_sell = DATE(NOW()) AND l.branch = '$branch' ";
					$data['reporttoday'] = Yii::app()->db->createCommand($sql)->queryAll();
		*/
		if ($branchs == "99") {
			$data['branchlist'] = Branch::model()->findAll("id!='99'");
		} else {
			$data['branchlist'] = Branch::model()->findAll("id=:id", array(":id" => $branchs));
		}
		if ($date != "") {
			$dates = $date;
		} else {
			$dates = date("Y-m-d");
		}
		$data['branch'] = $branchs;
		$data['date'] = $dates;
		$data['list'] = $this->getServiceAll($date, $branchs);
		$this->render('reportsellall', $data);
	}

	function getServiceAll($date, $branch) {
		//$branch = Yii::app()->session['branch'];
		if ($date != "") {
			$dateS = $date;
		} else {
			$dateS = date("Y-m-d");
		}
		$sql = "SELECT Q.*,p.`name`,p.`lname`,p.`branch`
                FROM(
                	SELECT s.`patient_id`,s.`service_date` AS d_date
                	FROM service s
                	WHERE service_date = '$dateS' AND s.branch = '$branch'
				) AS Q INNER JOIN patient p ON Q.patient_id = p.id

                GROUP BY Q.patient_id
                ORDER BY Q.d_date ASC ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function actionExportreportall($date = "", $branch = "") {
		if ($date != "") {
			$dates = $date;
		} else {
			$dates = date("Y-m-d");
		}
		$data['date'] = $dates;
		$data['list'] = $this->getServiceAll($date, $branch);
		$this->renderPartial('exportreporttoday', $data);
	}

}
