<?php

class Report {

	function getproduct($branch = null) {
		$sql = "SELECT p.*
                FROM product p
                WHERE p.status = 0 AND p.branch = '$branch' ";

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function getproductinputAll($year = null, $month = null, $product_id = null) {
		$sql = "SELECT SUBSTR(i.date_input,6,2) AS MONTHS,COUNT(*) AS TOTAL
                FROM items i
                WHERE LEFT(i.date_input,4) = '$year'
                AND SUBSTR(i.date_input,6,2) = '$month' AND i.product_id = '$product_id' ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['TOTAL'];
	}

	function getproductsell($year = null, $month = null, $product_id = null) {
		$sql = "SELECT SUBSTR(s.date_sell,6,2) AS MONTHS,COUNT(*) AS TOTAL
                FROM sell s INNER JOIN items i ON s.itemcode = i.itemcode
                WHERE LEFT(s.date_sell,4) = '$year'
                AND SUBSTR(s.date_sell,6,2) = '$month'
                AND i.product_id = '$product_id' AND i.`status` = '1' ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['TOTAL'];
	}

	function getproductstockAll($year = null, $month = null, $product_id = null) {
		$monthNows = date("m");
		if (strlen($monthNows) < 1) {
			$monthNow = "0" . ($monthNows + 1);
		} else {
			$monthNow = ($monthNows + 1);
		}
		$sql = "SELECT SUBSTR(i.date_input,6,2) AS MONTHS,COUNT(*) AS TOTAL
                FROM items i
                WHERE LEFT(i.date_input,4) = '$year'
                    AND SUBSTR(i.date_input,6,2) <= '$month' AND $month < $monthNow
                    AND i.product_id = '$product_id' AND i.`status` = '0'";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['TOTAL'];
	}

	function Getcostproduct($year = null, $branch = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}
		$sql = "SELECT SUM(Q.itemstotal) AS itemstotal,SUM(Q.pricrtotal) AS pricetotal
                FROM(
                    SELECT p.product_name,i.product_id,COUNT(*) as itemstotal,p.costs,(p.costs * COUNT(*)) as pricrtotal
                    FROM items i INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(i.date_input,4) = '$year' $WHERE
                    GROUP BY i.product_id
                ) Q ";
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

	function Gettotalsell($year = null, $branch = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}
		$sql = "SELECT SUM(Q.totalitem) AS totalitems,SUM(Q.totalprice) AS totalprice
                FROM(
                    SELECT p.product_name,i.product_id,p.product_price,COUNT(*) AS totalitem,(p.product_price * COUNT(*)) AS totalprice
                    FROM sell s INNER JOIN items i ON s.itemcode = i.itemcode
                    INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(s.date_sell,4) = '$year' $WHERE
                    GROUP BY i.product_id
                ) Q  ";
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

	//ข	้อมูลการซื้อสินค้ารายไตรมาส
	function GetcostproductPeriod($year = null, $branch = null, $period = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}

		if ($period == '1') {
			$PERIODS = " BETWEEN '01' AND '03' ";
		} else if ($period == '2') {
			$PERIODS = " BETWEEN '04' AND '06' ";
		} else if ($period == '3') {
			$PERIODS = " BETWEEN '07' AND '09' ";
		} else if ($period == '4') {
			$PERIODS = " BETWEEN '10' AND '12' ";
		}
		$sql = "SELECT IFNULL(SUM(Q.itemstotal),0) AS itemstotal,IFNULL(SUM(Q.pricrtotal),0) AS pricrtotal
                FROM(
                    SELECT SUBSTR(i.date_input,5),p.product_name,i.product_id,COUNT(*) as itemstotal,p.costs,(p.costs * COUNT(*)) as pricrtotal
                    FROM items i INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(i.date_input,4) = '$year' $WHERE AND SUBSTR(i.date_input,6,2) $PERIODS
                GROUP BY i.product_id
                ) Q  ";
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

	//ข	้อมูลการขายสินค้ารายไตรมาส
	function GettotalsellPeriod($year = null, $branch = null, $period = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}

		if ($period == '1') {
			$PERIODS = " BETWEEN '01' AND '03' ";
		} else if ($period == '2') {
			$PERIODS = " BETWEEN '04' AND '06' ";
		} else if ($period == '3') {
			$PERIODS = " BETWEEN '07' AND '09' ";
		} else if ($period == '4') {
			$PERIODS = " BETWEEN '10' AND '12' ";
		}
		$sql = "SELECT IFNULL(SUM(Q.totalitem),0) AS totalitems,IFNULL(SUM(Q.totalprice),0) AS totalprice
                FROM(
                    SELECT p.product_name,i.product_id,p.product_price,COUNT(*) AS totalitem,(p.product_price * COUNT(*)) AS totalprice
                    FROM sell s INNER JOIN items i ON s.itemcode = i.itemcode
                    INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(s.date_sell,4) = '$year' $WHERE AND SUBSTR(s.date_sell,6,2) $PERIODS
                    GROUP BY i.product_id
                ) Q  ";
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

	//ต	้นทุนรายเดือน
	function GetcostproductMonth($year = null, $branch = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}

		$sql = "SELECT m.id,m.month_th,IFNULL(SUM(Q.pricrtotal),0) AS pricrtotal
                FROM `month` m
                LEFT JOIN
                (
                    SELECT SUBSTR(i.date_input,6,2) AS month,p.product_name,i.product_id,COUNT(*) as itemstotal,p.costs,(p.costs * COUNT(*)) as pricrtotal
                    FROM items i INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(i.date_input,4) = '$year' $WHERE
                    GROUP BY SUBSTR(i.date_input,6,2),p.product_id
                ) Q
                ON m.id = Q.month
                GROUP BY m.id";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	//ย	อดขายรายเดือน
	function GettotalsellMonth($year = null, $branch = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}

		$sql = "SELECT m.id,m.month_th,IFNULL(SUM(Q.totalprice),0) AS totalprice
                FROM `month` m
                LEFT JOIN
                (
                    SELECT SUBSTR(s.date_sell,6,2) AS month,i.product_id,COUNT(*) AS totalitem,(p.product_price * COUNT(*)) AS totalprice
                    FROM sell s INNER JOIN items i ON s.itemcode = i.itemcode
                    INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(s.date_sell,4) = '$year' $WHERE
                    GROUP BY SUBSTR(s.date_sell,6,2),i.product_id
                ) Q
                ON m.id = Q.month
                GROUP BY m.id ";

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function GetprofitMonth($year = null, $branch = null) {
		if (!empty($branch)) {
			$WHERE = " AND p.branch = '$branch'";
		} else {
			$WHERE = "";
		}
		$sql = "SELECT m.id,IFNULL((SUM(selltotal) - SUM(costtotal)),0) AS profit
                FROM month m
                LEFT JOIN
                (
                SELECT SUBSTR(i.date_input,6,2) AS month,(p.costs * COUNT(*)) as costtotal,0 AS selltotal
                    FROM items i INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(i.date_input,4) = '$year' $WHERE
                    GROUP BY SUBSTR(i.date_input,6,2),p.product_id
                UNION
                SELECT SUBSTR(s.date_sell,6,2) AS month,0,(p.product_price * COUNT(*)) AS selltotal
                    FROM sell s INNER JOIN items i ON s.itemcode = i.itemcode
                    INNER JOIN product p ON i.product_id = p.product_id
                    WHERE LEFT(s.date_sell,4) = '$year' $WHERE
                    GROUP BY SUBSTR(s.date_sell,6,2),i.product_id
                ) Q
                ON m.id = Q.month
                GROUP BY m.id ";

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function ProductSalable($year = null, $branch = null) {
		if ($branch != "99") {
			$WHERE = " AND s.branch = '$branch'";
		} else {
			$WHERE = " AND 1=1 ";
		}

		$sql = "SELECT p.product_name,p.product_nameclinic,IFNULL(Q.total,0) AS total
                FROM center_stockproduct p
                LEFT JOIN
                (
	                SELECT p.product_id,p.product_name,SUM(s.number) AS total
	                FROM sell s INNER JOIN center_stockproduct p ON s.product_id = p.product_id
	                WHERE LEFT(s.date_sell,4) = '$year' $WHERE
	                GROUP BY p.product_id
                ) Q
                ON p.product_id = Q.product_id
                ORDER BY Q.total DESC ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function ReportSellproduct($datestart = null, $dateend = null, $branch = null) {
		if ($branch != "99") {
			$WHERE = " AND l.branch = '$branch'";
		} else {
			$WHERE = "";
		}
		$sql = "SELECT l.*,e.`name`,e.lname,e.alias
                FROM logsell l INNER JOIN employee e ON l.user_id = e.id
                WHERE l.date_sell BETWEEN '$datestart' AND '$dateend' $WHERE
                ORDER BY l.date_sell DESC";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function ReportSumSellproduct($datestart = null, $dateend = null, $branch = null) {
		if ($branch != "99") {
			$WHERE = " AND l.branch = '$branch'";
		} else {
			$WHERE = "";
		}
		$sql = "SELECT IFNULL(SUM(l.totalfinal),0) AS total
                FROM logsell l
                WHERE l.date_sell BETWEEN '$datestart' AND '$dateend' $WHERE";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['total'];
	}

	function EmployeeMaxSell($datestart = null, $dateend = null, $branch = null) {
		if ($branch != "99") {
			$WHERE = " AND l.branch = '$branch'";
		} else {
			$WHERE = "";
		}
		$sql = "SELECT e.alias,SUM(l.totalfinal) AS totals
                FROM logsell l INNER JOIN employee e ON l.user_id = e.id
                WHERE l.date_sell BETWEEN '$datestart' AND '$dateend' $WHERE
                GROUP BY l.user_id
                ORDER BY totals DESC
                LIMIT 1 ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs;
	}

	/* หารายได้จากการให้บริการและการขายสินค้า */

	function GetIncome($year, $branch) {
		if ($branch != "99") {
			$wheresell = "o.branch = '$branch'";
			$whereservice = "s.branch = '$branch'";
		} else {
			$wheresell = " 1=1 ";
			$whereservice = " 1=1 ";
		}
		$sql = "SELECT IFNULL(SUM(Q.total),0) AS income
                    FROM(
                          SELECT SUM(o.totalfinal) AS total
		                  FROM logsell o
		                  WHERE  $wheresell AND LEFT(o.date_sell,4) = '$year'

                          UNION

                          SELECT SUM(s.pricedrug) AS total
                          FROM service s
                          WHERE $whereservice AND LEFT(s.service_date,4) = '$year'
                    ) Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['income'];
	}

	//รายรับวันนี้
	function GetIncomeToday($date, $branch) {
		if ($branch != "99") {
			$wheresell = "o.branch = '$branch'";
			$whereservice = "s.branch = '$branch'";
		} else {
			$wheresell = " 1=1 ";
			$whereservice = " 1=1 ";
		}
		$sql = "SELECT IFNULL(SUM(Q.total),0) AS income
                    FROM(
                          SELECT SUM(o.totalfinal) AS total
		          FROM logsell o
		          WHERE $wheresell AND o.date_sell = '$date'

                          UNION

                          SELECT SUM(s.pricedrug) AS total
                          FROM service s
                          WHERE $whereservice AND s.service_date = '$date'
                ) Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['income'];
	}

	//รายรับวันนี้
	function GetIncomeTomonth($date, $branch) {
		if ($branch != "99") {
			$wheresell = "o.branch = '$branch'";
			$whereservice = "s.branch = '$branch'";
		} else {
			$wheresell = " 1=1 ";
			$whereservice = " 1=1 ";
		}
		$MonthNow = date("Y-m");
		$sql = "SELECT IFNULL(SUM(Q.total),0) AS income
                    FROM(
                          SELECT SUM(o.totalfinal) AS total
		          FROM logsell o
		          WHERE LEFT(o.date_sell,7) = '$MonthNow'

                          UNION ALL

                          SELECT SUM(s.price_total) AS total
                          FROM service s
                          WHERE LEFT(s.service_date,7) = '$MonthNow'
                ) Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['income'];
	}

	//หาค่าใช้จ่ายของสาขา
	function GetOutcome($year, $branch) {
		if ($branch != "99") {
			$where = "o.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}

		/*
			          $sql = "SELECT IFNULL(SUM(o.priceresult),0) AS outcome
			          FROM orders o
			          WHERE $where AND LEFT(o.create_date,4) = '$year' ";
		*/
		/* แก้ไข 2018-02-19 */

		$sql = "SELECT IFNULL(SUM(Q.outcome),0) AS outcome
                FROM(

                SELECT IFNULL(SUM(o.price),0) AS outcome
                FROM `repair` o
                WHERE $where AND o.`status` = '1' AND LEFT(o.date_alert,4) = '$year'

                UNION

                SELECT IFNULL(SUM(o.total),0) AS outcome
                FROM salary o
                WHERE $where AND o.year = '$year'
                ) Q ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['outcome'];
	}

	function GetIncomePeriod($year = null, $branch = null, $period = null) {
		if ($branch != "99") {
			$wheresell = "o.branch = '$branch'";
			$whereservice = "s.branch = '$branch'";
		} else {
			$wheresell = " 1=1 ";
			$whereservice = " 1=1 ";
		}

		if ($period == '1') {
			$PERIODS = " BETWEEN '01' AND '03' ";
		} else if ($period == '2') {
			$PERIODS = " BETWEEN '04' AND '06' ";
		} else if ($period == '3') {
			$PERIODS = " BETWEEN '07' AND '09' ";
		} else if ($period == '4') {
			$PERIODS = " BETWEEN '10' AND '12' ";
		}

		//AND SUBSTR(i.date_input,6,2) $PERIOD
		$sql = "SELECT IFNULL(SUM(Q.total),0) AS income
                    FROM(
                          SELECT SUM(o.totalfinal) AS total
		                  FROM logsell o
		                  WHERE $wheresell AND LEFT(o.date_sell,4) = '$year' AND SUBSTR(o.date_sell,6,2) $PERIODS

                          UNION

                          SELECT SUM(s.price_total) AS total
                          FROM service s
                          WHERE $whereservice AND LEFT(s.service_date,4) = '$year'
                          AND SUBSTR(s.service_date,6,2) $PERIODS
                    ) Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['income'];
	}

	function GetOutcomePeriod($year = null, $branch = null, $period = null) {
		if ($branch != "99") {
			$where = "o.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}

		if ($period == '1') {
			$PERIODS = " BETWEEN '01' AND '03' ";
		} else if ($period == '2') {
			$PERIODS = " BETWEEN '04' AND '06' ";
		} else if ($period == '3') {
			$PERIODS = " BETWEEN '07' AND '09' ";
		} else if ($period == '4') {
			$PERIODS = " BETWEEN '10' AND '12' ";
		}

		//AND SUBSTR(i.date_input,6,2) $PERIOD
		/* รายจ่ายคำนวนจากการซ่อมบำรุง แก้ไขเมื่อ 2018-02-19 */
		/*
			          $sql = "SELECT IFNULL(SUM(o.priceresult),0) AS outcome
			          FROM orders o
			          WHERE $where AND LEFT(o.create_date,4) = '$year'
			          AND SUBSTR(o.create_date,6,2) $PERIODS";
		*/
		$sql = "SELECT IFNULL(SUM(Q.outcome),0) AS outcome
                FROM(
                    SELECT IFNULL(SUM(o.price),0) AS outcome
                    FROM repair o
                    WHERE $where AND LEFT(o.date_alert,4) = '$year'
                    AND SUBSTR(o.date_alert,6,2) $PERIODS AND o.status = '1'

                    UNION

                    SELECT IFNULL(SUM(o.total),0) AS outcome
                    FROM salary o
                    WHERE $where AND o.year = '$year' AND o.month $PERIODS
                ) Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['outcome'];
	}

	function GetIncomeMonth($year = null, $branch = null) {
		if ($branch != "99") {
			$wheresell = "o.branch = '$branch'";
			$whereservice = "s.branch = '$branch'";
		} else {
			$wheresell = " 1=1 ";
			$whereservice = " 1=1 ";
		}
		$sql = "SELECT m.id,m.month_th,IFNULL(SUM(Q.total),0) AS total
                FROM `month` m
                LEFT JOIN
                (
                    SELECT SUBSTR(o.date_sell,6,2) AS month,SUM(o.totalfinal) AS total
                        FROM logsell o
                        WHERE $wheresell AND LEFT(o.date_sell,4) = '$year'
                        GROUP BY SUBSTR(o.date_sell,6,2)

                        UNION

                        SELECT SUBSTR(s.service_date,6,2) AS month,SUM(s.price_total) AS total
                        FROM service s
                        WHERE $whereservice AND LEFT(s.service_date,4) = '$year'
                        GROUP BY SUBSTR(s.service_date,6,2)
                 ) Q ON m.id = Q.month
                GROUP BY m.id ";
		//return $sql;
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function GetOutcomeMonth($year = null, $branch = null) {
		if ($branch != "99") {
			$where = "o.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}
		/*
			          $sql = "SELECT m.id,m.month_th,IFNULL(SUM(Q.total),0) AS total
			          FROM `month` m
			          LEFT JOIN
			          (
			          SELECT SUBSTR(o.create_date,6,2) AS month,SUM(o.priceresult) AS total
			          FROM orders o
			          WHERE $where AND LEFT(o.create_date,4) = '$year'
			          GROUP BY SUBSTR(o.create_date,6,2)
			          ) Q ON m.id = Q.month
			          GROUP BY m.id ";
		*/
		$sql = "SELECT m.id,m.month_th,IFNULL(SUM(Q.total),0) AS total
                FROM `month` m
                LEFT JOIN
                (
				SELECT Q1.month,SUM(Q1.total) AS total
				FROM(
						SELECT SUBSTR(o.date_alert,6,2) AS month,SUM(o.price) AS total
						FROM repair o
						WHERE $where AND LEFT(o.date_alert,4) = '$year' AND o.status = '1'
						GROUP BY SUBSTR(o.date_alert,6,2)

						UNION

						SELECT o.month,o.total
						FROM salary o
						WHERE $where AND o.year = '$year'
					) Q1
				GROUP BY Q1.month
                 ) Q ON m.id = Q.month
                GROUP BY m.id";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function CountServiceNow($branch) {
		if ($branch != "99") {
			$where = "s.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}
		$sql = "SELECT IFNULL(COUNT(*),0) AS total
                FROM service s
                WHERE $where AND s.service_date = DATE(NOW())";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['total'];
	}

	function CountLoginNow($branch) {
		if ($branch != "99") {
			$where = "s.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}
		$sql = "SELECT IFNULL(COUNT(*),0) AS total
                FROM loglogin s
                WHERE $where AND LEFT(s.date,10) = DATE(NOW())";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['total'];
	}

	function GetOutcomePeriodCenter($year = null, $branch = null, $period = null) {
		if ($branch != "99") {
			$where = "o.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}

		if ($period == '1') {
			$PERIODS = " BETWEEN '01' AND '03' ";
		} else if ($period == '2') {
			$PERIODS = " BETWEEN '04' AND '06' ";
		} else if ($period == '3') {
			$PERIODS = " BETWEEN '07' AND '09' ";
		} else if ($period == '4') {
			$PERIODS = " BETWEEN '10' AND '12' ";
		}

		$sql = "SELECT IFNULL(SUM(Q.outcome),0) AS outcome
                FROM(
                    SELECT IFNULL(SUM(o.price),0) AS outcome
                    FROM repair o
                    WHERE $where AND LEFT(o.date_alert,4) = '$year'
                    AND SUBSTR(o.date_alert,6,2) $PERIODS AND o.status = '1'

                    UNION

                    SELECT IFNULL(SUM(o.total),0) AS outcome
                    FROM salary o
                    WHERE $where AND o.year = '$year' AND o.month $PERIODS

                    UNION

                    SELECT IFNULL(SUM(c.price),0) AS outcome
                    FROM clinic_storeproduct c
                    WHERE c.branch ='99' AND LEFT(c.lotnumber,4) = '$year' AND SUBSTR(c.lotnumber,5,2) $PERIODS
                ) Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['outcome'];
	}

	function GetOutcomeMonthCenter($year = null, $branch = null) {
		if ($branch != "99") {
			$where = "o.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}
		$sql = "SELECT m.id,m.month_th,IFNULL(SUM(Q.total),0) AS total
                FROM `month` m
                LEFT JOIN
                (
                SELECT Q1.month,SUM(Q1.total) AS total
                FROM(
                        SELECT SUBSTR(o.date_alert,6,2) AS month,SUM(o.price) AS total
                        FROM repair o
                        WHERE $where AND LEFT(o.date_alert,4) = '$year' AND o.status = '1'
                        GROUP BY SUBSTR(o.date_alert,6,2)

                        UNION

                        SELECT o.month,o.total
                        FROM salary o
                        WHERE $where AND o.year = '$year'

                        UNION

                        SELECT SUBSTR(c.lotnumber,5,2) AS month,IFNULL(SUM(c.price),0) AS total
                        FROM clinic_storeproduct c
                        WHERE c.branch ='99' AND LEFT(c.lotnumber,4) = '$year'
                        GROUP BY SUBSTR(c.lotnumber,5,2)
                    ) Q1
                GROUP BY Q1.month
                 ) Q ON m.id = Q.month
                GROUP BY m.id";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	//หาค่าใช้จ่ายของสาขา
	function GetOutcomeCenter($year) {

		$sql = "SELECT IFNULL(SUM(Q.outcome),0) AS outcome
                FROM(

                SELECT IFNULL(SUM(o.price),0) AS outcome
                FROM `repair` o
                WHERE o.`status` = '1' AND LEFT(o.date_alert,4) = '$year'

                UNION

                SELECT IFNULL(SUM(o.total),0) AS outcome
                FROM salary o
                WHERE o.year = '$year'

                UNION

                SELECT IFNULL(SUM(c.price),0) AS outcome
                FROM clinic_storeproduct c
                WHERE c.branch ='99' AND LEFT(c.lotnumber,4) = '$year'
                ) Q ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['outcome'];
	}

	public function Getmaxsellproduct($branch) {
		$sql = "SELECT p.product_id,p.product_name,SUM(s.number) AS total
                FROM sell s INNER JOIN center_stockproduct p ON s.product_id = p.product_id
                WHERE s.branch = '$branch'
                GROUP BY p.product_id
                ORDER BY SUM(s.number) DESC
                LIMIT 1 ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs;
	}

	public function CountserviceAll($branch) {
		$sql = "SELECT COUNT(*) AS total
                FROM service s
                WHERE s.branch = '$branch' ";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['total'];
	}

	function LastserviceAll($limit) {
		if (!empty($limit)) {
			$limit = " limit $limit";
		} else {
			$limit = "";
		}
		$sql = "select s.*,p.name,p.lname,b.branchname from service s inner join patient p on s.patient_id = p.id inner join branch b ON s.branch = b.id order by s.id desc $limit";
		$rs = Yii::app()->db->createCommand($sql)->queryAll();
		return $rs;
	}

	function Countpatient() {
		$sql = "SELECT b.branchname,IFNULL(COUNT(*),0) AS total
                FROM branch b LEFT JOIN patient p ON b.id = p.branch
                WHERE p.branch != '99'
                GROUP BY b.id ";
		$rs = Yii::app()->db->createCommand($sql)->queryAll();
		return $rs;
	}

	function CountReportProductInType($datestart = null, $dateend = null, $branch = null) {
		if ($branch != "99") {
			$where = "l.branch = '$branch'";
		} else {
			$where = " 1=1 ";
		}
		$sql = "SELECT ty.type_id,ty.type_name,IFNULL(SUM(Q.total),0) AS total
                FROM product_type ty
                LEFT JOIN
                    (
                        SELECT t.type_id,t.upper,t.type_name,SUM(e.number) AS total
                        FROM logsell l INNER JOIN sell e ON l.sell_id = e.sell_id
                        INNER JOIN center_stockproduct p ON e.product_id = p.product_id
                        INNER JOIN product_type t ON p.subproducttype = t.id
                        WHERE l.date_sell BETWEEN '$datestart' AND '$dateend' AND $where
                        AND t.sublevel = '0'
                        GROUP BY t.type_id
                    ) Q ON ty.id = Q.upper
                WHERE ty.sublevel = '1'
                GROUP BY ty.type_id ";
		$rs = Yii::app()->db->createCommand($sql)->queryAll();
		return $rs;
	}

	function getServicePatient($patientId = "", $branch = "", $date = "") {
		$sql = "SELECT s.id,s.`patient_id`,s.`service_date` AS d_date
                FROM service s
                WHERE service_date = '$date' AND s.branch = '$branch'
                AND s.`patient_id` = '$patientId' ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function getDetailServiceAll($serviceId = "") {
		$sql = "SELECT CONCAT('ประวัติการรักษา : ',s.detail) AS detail,1 AS `number`,s.price AS total,1 AS type
                FROM service_detail s
                WHERE s.service_id = '$serviceId'

                UNION ALL

				SELECT s.detail,1 AS `number`,s.price AS total,2 AS type
                FROM service_etc s
                WHERE s.service_id = '$serviceId'

                UNION ALL

				SELECT d.diagname AS detail,1 AS `number`,s.diagprice AS total,2 AS type
                FROM service_diag s INNER JOIN diag d ON s.`diagcode` = d.diagcode
                WHERE s.service_id = '$serviceId'

                UNION ALL

                SELECT p.product_nameclinic AS detail,s.number AS `number`,0 AS total,2 AS type
                FROM service_drug s INNER JOIN center_stockproduct p ON s.drug = p.product_id
                WHERE s.service_id = '$serviceId'

                UNION ALL

                SELECT CONCAT('รวมค่ายา (',s.pricedrug,' บาท)') AS detail,'-' AS `number`,s.pricedrug AS total,2 AS type
                FROM service s
                WHERE s.id = '$serviceId' ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	function sumServiceAll($patientId = "", $dateServe = "") {
		$sql = "SELECT SUM(Q.total) AS total
		FROM(
		SELECT d.diagname AS detail,1 AS `number`,s.diagprice AS total
                FROM service_diag s INNER JOIN diag d ON s.`diagcode` = d.diagcode
                WHERE s.patient_id = '$patientId ' AND LEFT(s.date_serv,10) = '$dateServe'

                UNION ALL

                SELECT '' AS detail,0 AS `number`,s.pricedrug AS total
                FROM service s
                WHERE s.patient_id = '$patientId ' AND LEFT(s.service_date,10) = '$dateServe'

                UNION ALL

                SELECT s.detail,1 AS `number`,s.price AS total
                FROM service_detail s
                WHERE s.patient_id = '$patientId ' AND LEFT(s.date_serv,10) = '$dateServe'

                UNION ALL

                SELECT s.detail,1 AS `number`,s.price AS total
                FROM service_etc s
                WHERE s.patient_id = '$patientId ' AND LEFT(s.date_serv,10) = '$dateServe'
            ) AS Q";
		$rs = Yii::app()->db->createCommand($sql)->queryRow();
		return $rs['total'];
	}

	//ดึงประวัติการบริการลูกค้ามาวันนี้
	function getPatientService($branch = "", $date = "") {
		$sql = "SELECT 'ขายยา(ไม่ตรวจ)' AS productname,
				IFNULL(SUM(s.number),0) AS number,
				IFNULL(SUM(s.price),0) AS price
				FROM sell s
				WHERE s.date_sell = '$date' AND s.branch = '$branch'";
		//AND p.id = '$patientId'
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

}
