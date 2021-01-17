<?php

class SellController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'template_backend';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'Detailservice', 'test',
                    'result', 'loadorder', 'sell', 'calculator', 'bill',
                    'confirmorder', 'logsell', 'patient', 'cutstock', 'checkstock', 'deleteitemsinorder', 'comboproduct',
                    'detailproduct', 'searchpatient', 'updatenumber', 'payment', 'uploadtmpslip', 'loadtmpslip', 'logselltransfer',
                    'reporttoday', 'sumreporttoday',
                ),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        //ลบสินค้าที่ยังไม่ Confirm
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT * FROM sell
                    WHERE sell_id NOT IN(SELECT sell_id FROM logsell)";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($result as $rs):
            $itemcode = $rs['itemcode'];
            $columns = array("status" => "0");
            Yii::app()->db->createCommand()
                    ->update("items", $columns, "itemcode = '$itemcode'");

            /*
              Yii::app()->db->createCommand()
              ->delete("sell", "itemcode = '$itemcode' ");
             *
             */
        endforeach;
        $sqlEmployee = "select id,name,lname from employee where branch = '$branch' AND position in('7','11','12','14')";
        $data['employee'] = Yii::app()->db->createCommand($sqlEmployee)->queryAll();
        //$data['employee'] = Employee::model()->findAll("branch=:branch",array(":branch" => $branch));

        $this->layout = 'template_sell';
        $this->render('index', $data);
    }

    public function actionPayment() {
        $sell_id = Yii::app()->request->getPost('sell_id');
        $BankModel = new Storeaccount();
        $data['sell_id'] = $sell_id;
        $data['banklist'] = $BankModel->getbank();
        $this->renderPartial("payment", $data);
    }

    public function actionSell() {
        $itemcode = Yii::app()->request->getPost('itemcode');
        $pid = Yii::app()->request->getPost('pid');
        $sellcode = Yii::app()->request->getPost('sellcode');
        $branch = Yii::app()->request->getPost('branch');
        $number = Yii::app()->request->getPost('number');
        $price = Yii::app()->request->getPost('price');
        $productname = Yii::app()->request->getPost('productname');
        $typeproduct = Yii::app()->request->getPost('typeproduct');
        $user_id = Yii::app()->request->getPost('employee');
        $datesell = Yii::app()->request->getPost('datesell');
        $columns = array(
            "itemcode" => $itemcode,
            "product_id" => $itemcode,
            "pid" => $pid,
            "sell_id" => $sellcode,
            "user_id" => $user_id,
            "branch" => $branch,
            "number" => $number,
            "price" => $price,
            "productname" => $productname,
            "typeproduct" => $typeproduct,
            //"promotion" => $promotion,
            "date_sell" => $datesell,
            "d_update" => date("Y-m-d H:i:s"),
        );
        Yii::app()->db->createCommand()
                ->insert("sell", $columns);
    }

    public function actionSellBackup() {
        $itemcode = Yii::app()->request->getPost('itemcode');
        $pid = Yii::app()->request->getPost('pid');
        $sellcode = Yii::app()->request->getPost('sellcode');
        $branch = Yii::app()->request->getPost('branch');
        $number = Yii::app()->request->getPost('number');
        $price = Yii::app()->request->getPost('price');
        $promotion = Yii::app()->request->getPost('promotion');
        $promotion_id = Yii::app()->request->getPost('promotion_id');

        $Product = ClinicStockproduct::model()->find("product_id=:product_id AND branch=:branch", array(":product_id" => $itemcode, ":branch" => $branch));
        //เช็คว่ามีสินค้าตัวเดิมอยู่ในรายการไหม
        $sql = "select * from sell where sell_id = '$sellcode' and product_id = '$itemcode' and promotion = ''";
        $selllist = Yii::app()->db->createCommand($sql)->queryRow();
        $countproduct = Yii::app()->db->createCommand($sql)->queryAll();
        /*
          $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
         */
        $user_id = Yii::app()->request->getPost('employee');
        $count = count($countproduct);
        if ($count > "0" && $promotion_id == "") {
            $numberold = $selllist['number'];
            $newsnumber = ($numberold + $number);
            $id = $selllist['id'];
            $columns = array("number" => $newsnumber);
            Yii::app()->db->createCommand()
                    ->update("sell", $columns, "id='$id'");
        } else {
            if ($promotion_id != "") {
                $Proprice = Promotionproduct::model()->find("id=:id", array(":id" => $promotion_id))['price'];
                $productprice = $Proprice;
            } else {
                $productprice = $Product['product_price'];
            }
            $columns = array(
                "itemcode" => $itemcode,
                "product_id" => $itemcode,
                "pid" => $pid,
                "sell_id" => $sellcode,
                "user_id" => $user_id,
                "branch" => $branch,
                "number" => $number,
                "price" => $productprice,
                "promotion" => $promotion,
                "date_sell" => date("Y-m-d"),
            );
            Yii::app()->db->createCommand()
                    ->insert("sell", $columns);
        }
        //ตักสต๊อก
        /*
          $stock = array("status" => "1", "flag" => "E");
          Yii::app()->db->createCommand()
          ->update("items", $stock, "itemcode = '$itemcode'");
         *
         */
    }

    public function actionLoadorder() {
        $sell_id = Yii::app()->request->getPost('sell_id');
        $branch = Yii::app()->request->getPost('branch');
        /*
          $sql = "SELECT s.id,p.product_id,c.product_nameclinic AS product_name,SUM(s.number) AS total,s.price AS product_price
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          INNER JOIN center_stockproduct c ON p.product_id = c.product_id
          WHERE s.sell_id = '$sell_id'
          GROUP BY p.product_id";
         */
        /*
          $sql = "SELECT Q.*
          FROM
          (
          (SELECT s.id,p.product_id,c.product_nameclinic AS product_name,SUM(s.number) AS total,s.price AS product_price,s.promotion
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          INNER JOIN center_stockproduct c ON p.product_id = c.product_id
          WHERE s.sell_id = '$sell_id'  AND s.promotion = '' AND p.branch = '$branch'
          GROUP BY p.product_id
          )
          UNION ALL
          (SELECT s.id,p.product_id,CONCAT('โปร ',c.product_nameclinic,' ',s.promotion,' ปกติหน่วยละ ',p.product_price,'.-') AS product_name,s.number AS total,s.price AS product_price,s.promotion
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          INNER JOIN center_stockproduct c ON p.product_id = c.product_id
          WHERE s.sell_id = '$sell_id'  AND s.promotion != '' AND p.branch = '$branch'
          )
          ) Q ";
         */
        $sql = "SELECT s.id,s.product_id,s.productname AS product_name,s.number AS total,s.price AS product_price
                FROM sell s
                WHERE s.sell_id = '$sell_id'";
        $data['order'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->renderPartial('order', $data);
    }

    public function actionCalculator() {
        $sell_id = Yii::app()->request->getPost('sell_id');
        $branch = Yii::app()->request->getPost('branch');
        /*
          $sql = "SELECT SUM(Q.total) AS total
          FROM
          (
          SELECT (SUM(s.number) * s.price) AS total
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          WHERE s.sell_id = '$sell_id' AND promotion = '' AND p.branch = '$branch'
          GROUP BY s.product_id

          UNION ALL

          SELECT SUM(s.price) AS total
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          WHERE s.sell_id = '$sell_id' AND promotion != '' AND p.branch = '$branch'
          ) Q ";
         */
        $sql = "SELECT SUM(price) AS total FROM sell WHERE sell_id = '$sell_id' ";

        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $json = array("total" => $result['total']);
        echo json_encode($json);
    }

    public function actionBill($sell_id, $branch = null) {
        $Model = new Sell();
        //$sell_id = Yii::app()->request->getPost('sell_id');
        //$data['order'] = $Model->Getlistorder($sell_id);
        $data['detail'] = $Model->Detailorder($sell_id);
        $branch = $data['detail']['branch'];
        $data['order'] = $Model->Getordersell($sell_id, $branch);

        $data['logsell'] = Logsell::model()->find("sell_id = '$sell_id' ");
        //update 20200215
        //$this->renderPartial('bill', $data);
        $this->Savelog($data['order'], $sell_id);
        $this->renderPartial('bill', $data);
    }

    function Savelog($order, $sellId) {
        foreach ($order as $rs):
            $columns = array(
                "sellid" => $sellId,
                "product_id" => $rs['product_id'],
                "product_name" => $rs['product_name'],
                "number" => $rs['total'],
                "price" => $rs['product_price'],
                "date_sell" => $rs['date_sell']
            );
            Yii::app()->db->createCommand()
                    ->insert("logbuysell", $columns);
        endforeach;
    }

    public function actionConfirmorder($sell_id = null) {
        $Model = new Sell();
        $order = $Model->Getlistorder($sell_id);
        foreach ($order as $rs):
            $product_id = $rs['product_id'];
            $number = $rs['total'];
            $this->actionCutstock($product_id, $number, $rs['branch']);
            /*
              $itemcode = $rs['itemcode'];
              $columns = array("status" => "1");
              Yii::app()->db->createCommand()
              ->update("items", $columns, "itemcode = '$itemcode' ");
             *
             */
        endforeach;

        /*
          $confirm = array("confirm" => '1');
          Yii::app()->db->createCommand()
          ->update("sell", $confirm, "sell_id = '$sell_id' ");
         *
         */
    }

    public function actionLogsell() {
        //$itemcode = Yii::app()->request->getPost('itemcode');
        $pid = Yii::app()->request->getPost('pid');
        $sellcode = Yii::app()->request->getPost('sellcode');
        $branch = Yii::app()->request->getPost('branch');
        $total = Yii::app()->request->getPost('total');
        $income = Yii::app()->request->getPost('income');
        $change = Yii::app()->request->getPost('change');
        $totalfinal = Yii::app()->request->getPost('totalfinal');
        $distcount = Yii::app()->request->getPost('distcount');
        $typebuy = Yii::app()->request->getPost('typebuy');
        $payment = Yii::app()->request->getPost('payment');
        $account = Yii::app()->request->getPost('account');
        $comment = Yii::app()->request->getPost('comment');
        $datesell = Yii::app()->request->getPost('datesell');
        $CheckOrder = Logsell::model()->find("sell_id = '$sellcode' ");

        //$user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $user_id = Yii::app()->request->getPost('employee');
        if (empty($CheckOrder['sell_id'])) {
            $columns = array(
                "pid" => $pid,
                "sell_id" => $sellcode,
                "user_id" => $user_id,
                "branch" => $branch,
                "total" => $total,
                "income" => $totalfinal,
                "change" => 0,
                "totalfinal" => $totalfinal,
                "distcount" => 0,
                "typebuy" => $typebuy,
                "payment" => $payment,
                "accountnumber" => $account,
                "comment" => $comment,
                "date_sell" => $datesell,
            );
            Yii::app()->db->createCommand()
                    ->insert("logsell", $columns);
        } else {
            $columns = array(
                "pid" => $pid,
                "user_id" => $user_id,
                "branch" => $branch,
                "total" => $total,
                "income" => $totalfinal,
                "change" => 0,
                "totalfinal" => $totalfinal,
                "distcount" => 0,
                "typebuy" => $typebuy,
                "payment" => $payment,
                "accountnumber" => $account,
                "comment" => $comment,
                "date_sell" => $datesell,
            );
            Yii::app()->db->createCommand()
                    ->update("logsell", $columns, "sell_id = '$sellcode'");
        }

        //insert Privilege
        if ($typebuy == "1" && $distcount != "0") {

            $month = date("m");
            if (strlen($month) < 2) {
                $monthNow = "0" . $month;
            } else {
                $monthNow = $month;
            }

            $yearNow = date("Y");
            $CheckPrivilege = privilegebuyemployee::model()->find("pid=:pid and month=:month and year=:year", array(":pid" => $pid, ":month" => $monthNow, ":year" => $yearNow));
            if ($CheckPrivilege['pid'] == "") {
                $columns = array("pid" => $pid, "year" => $yearNow, "month" => $monthNow, "money" => Common::SetMoneyPrivilege(), "d_update" => date("Y-m-d H:i:s"));
                Yii::app()->db->createCommand()
                        ->insert("privilegebuyemployee", $columns);
            }
        }

        $this->actionConfirmorder($sellcode);
    }

    public function actionPatient() {
        $pid = Yii::app()->request->getPost('pid');
        $typebuy = Yii::app()->request->getPost('typebuy');
        /*
          $sql = "SELECT p.*,g.grad,g.distcount,g.distcountsell
          FROM patient p INNER JOIN gradcustomer g ON p.type = g.id
          WHERE p.card = '$card' ";
          $rs = Yii::app()->db->createCommand($sql)->queryRow();
         *
         */
        if ($typebuy == "0") {
            $Model = new Patient();
            $rs = $Model->GetpatientPid($pid);
            $patient_id = $rs['id'];
            $str = "";
            $str .= "<label>HN : </label> " . $rs['cn'];
            //$str .= "<br/><label>บัตรประชาชน : </label> " . $rs['card'];
            $str .= "<br/><label>คุณ : </label> " . $rs['name'] . " " . $rs['lname'];
            //$str .= "<br/><label>ที่อยู่ : </label> " . $rs['contact'];
            $str .= "<br/><label>เบอร์โทรศัพท์ : </label> " . $rs['tel'];
            //$str .= "<br/><label>ประเภทลูกค้า : </label> " . $rs['grad'];
            //$str .= "<br/><label>ส่วนลด : </label> " . $rs['distcountsell'] . " <label>บาท</label>";
            //$str .= "<input type='hidden' id='distcount' class='form-control' value='".$rs['distcountsell']."'/>";
            //$str .= "<script>$(document).ready(function(){ $('#distcount').val(" . $rs['distcountsell'] . ");});</script>";
            //ประวัติการรับยา
            $sqlDrug = "SELECT s.product_nameclinic,d.drug_method
                                FROM service_drug d INNER JOIN center_stockproduct s ON d.drug = s.product_id
                                WHERE d.patient_id = '$patient_id'
                                GROUP BY s.product_id";
            $resultDrug = Yii::app()->db->createCommand($sqlDrug)->queryAll();
            $str .= "<hr style='margin:0px;'/><div style='color:#ffffff'><b>ประวัติการรับยา(หมอสั่ง)</b><br/>";
            if ($resultDrug) {
                foreach ($resultDrug as $rsDrug):
                    $str .= $rsDrug['product_nameclinic'] . "<br/>";
                endforeach;
            } else {
                $str .= "== ไม่มี ==";
            }
            $str .= "</div>";

            //ประวัติการซื้อยา
            $sqlSell = "SELECT *
                            FROM sell s
                            WHERE s.pid = '$pid'
                            GROUP BY s.product_id ";
            $resultSell = Yii::app()->db->createCommand($sqlSell)->queryAll();
            $str .= "<hr style='margin:0px;'/><div style='color:pink'><b>ประวัติซื้อยา</b><br/>";
            if ($resultSell) {
                foreach ($resultSell as $rsSell):
                    $str .= $rsSell['productname'] . "<br/>";
                endforeach;
            } else {
                $str .= "== ไม่มี ==";
            }
            $str .= "</div>";
            if ($rs) {
                echo $str;
            }
        } else {
            echo $this->GetEmployee($pid);
        }
    }

    function GetEmployee($pid) {
        $sql = "select * from employee where pid = '$pid'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        //เช็คสิทธิเดือนนี้
        $month = date("m");
        if (strlen($month) < 2) {
            $monthNow = "0" . $month;
        } else {
            $monthNow = $month;
        }

        $yearNow = date("Y");
        $privilege = Privilegebuyemployee::model()->find("pid=:pid and year=:year and month=:month", array(":pid" => $pid, ':year' => $yearNow, ':month' => $monthNow));
        $str = "";
        $str .= "<label>รหัส : </label> " . $rs['pid'];
        //$str .= "<br/><label>บัตรประชาชน : </label> " . $rs['card'];
        $str .= "<br/><label>คุณ : </label> " . $rs['name'] . " " . $rs['lname'];
        //$str .= "<br/><label>ที่อยู่ : </label> " . $rs['contact'];
        $str .= "<br/><label>เบอร์โทรศัพท์ : </label> " . $rs['tel'];
        //$str .= "<br/><label>ประเภทลูกค้า : </label> " . $rs['grad'];
        //$str .= "<br/><label>ส่วนลด : </label> " . $rs['distcountsell'] . " <label>บาท</label>";
        //$str .= "<input type='hidden' id='distcount' class='form-control' value='".$rs['distcountsell']."'/>";
        //$str .= "<script>$(document).ready(function(){ $('#distcount').val(" . $rs['distcountsell'] . ");});</script>";
        if ($privilege['pid'] == "") {
            $str .= "<br/><button type='button' class='btn btn-warning' style='font-size:20px;' onclick='setprivilege(" . Common::SetMoneyPrivilege() . ")'>ใช้สิทธิส่วนลดพนักงาน " . Common::SetMoneyPrivilege() . " บาท</button>";
        }
        if ($rs) {
            return $str;
        }
        return "";
    }

    public function actionCutstock($product_id, $number, $branch) {
        $sql = "SELECT *
                FROM clinic_storeproduct i
                WHERE i.product_id = '$product_id' AND i.branch = $branch AND i.total > 0
                ORDER BY i.lotnumber,i.d_update ASC ";

        $item = Yii::app()->db->createCommand($sql)->queryAll();
        //ดึงข้อมูลตารางitem
        $numbercut = 0;
        foreach ($item as $rs):
            $id = $rs['id'];
            $totalinstock = $rs['total']; //คงเหลือในสต๊อกที่ตัดได้
            if ($totalinstock >= $number) {
                //<==กรณีสินค้าในล๊อตนั้นมีมากกว่า
                $totalstock = ($totalinstock - $number);
                $numbercut = $totalstock;
                $columns = array("total" => $numbercut);
                Yii::app()->db->createCommand()->update("clinic_storeproduct", $columns, "id = '$id' ");
                break;
            } else if ($totalinstock < $number) {
//<==กรณีสินค้าในล๊อตนั้นมีน้อยกว่า
                $number = ($number - $totalinstock);
                //$numbercut = $totalstock;
                $columns = array("total" => "0");
                Yii::app()->db->createCommand()->update("clinic_storeproduct", $columns, "id = '$id' ");
            }

        endforeach;
    }

    public function actionCheckstock() {
        $product_id = Yii::app()->request->getPost('product_id');
        $branch = Yii::app()->request->getPost('branch');
        $sql = "SELECT IFNULL(SUM(p.total),0) AS total
                FROM clinic_storeproduct p
                WHERE p.product_id = '$product_id' AND p.branch = '$branch' AND p.flag ='0'";

        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        echo $rs['total'];
    }

    public function actionDeleteitemsinorder() {
        $id = Yii::app()->request->getPost('id');
        Yii::app()->db->createCommand()
                ->delete("sell", "id = '$id' ");
    }

    public function actionComboproduct() {
        $items = new Items();
        $branch = Yii::app()->request->getPost('branch');
        $data['itemlist'] = $items->GetProductSell($branch);
        /*
          $data['itemlist'] = $items->GetItemSell();
         *
         */
        $this->renderPartial('comboproduct', $data);
    }

    public function actionDetailproduct() {
        //$product_id = $_GET['product_id'];
        $productFull = Yii::app()->request->getPost('product_id');
        if ($productFull) {
            $pieces = explode('||', $productFull);
            $product_id = $pieces[0];
            $productdetail = $pieces[1];
            $producttype = $pieces[2];
            $productprice = $pieces[3];
            $productname = $pieces[4];
            //$product = new Backend_product();
            $Model = new CenterStockproduct();
            //$Items = new Items();
            //$data['images'] = $product->get_images_product($product_id);
            //$data['product'] = $Model->_get_detail_product($product_id);
            //$product = $Model->_get_detail_product($product_id);
            //$this->renderPartial("detailproduct", $data);
        } else {
            $product_id = "";
            $productdetail = "";
            $producttype = "";
            $productprice = "";
            $productname = "";
        }

        $json = array('product_id' => $product_id, 'productdetail' => $productdetail, 'producttype' => $producttype, 'productname' => $productname);
        echo json_encode($json);
    }

    public function actionSearchpatient() {
        $name = Yii::app()->request->getPost('name');
        $lname = Yii::app()->request->getPost('lname');
        $typebuy = Yii::app()->request->getPost('typebuy');
        if ($typebuy == "0") {
            $table = "patient";
        } else {
            $table = "employee";
        }

        $where = "1=1 ";
        if ($name != "" && $lname == "") {
            $where .= " AND p.name like '%$name%'";
        }

        if ($name != "" && $lname != "") {
            $where .= " AND p.name like '%$name%' and p.lname like '%$lname%'";
        }

        if ($name == "" && $lname != "") {
            $where .= " AND p.lname like '%$lname%'";
        }

        $sql = "select p.*,b.branchname from $table p inner join branch b on p.branch = b.id where $where";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $data['patient'] = $rs;
        $data['typebuy'] = $typebuy;
        $this->renderPartial('datasearchselect', $data);
    }

    public function actionUpdatenumber() {
        $id = Yii::app()->request->getPost('id');
        $number = Yii::app()->request->getPost('number');
        $columns = array("number" => $number);
        Yii::app()->db->createCommand()
                ->update("sell", $columns, "id = '$id'");
    }

    public function actionUploadtmpslip() {
        $sell_id = $_GET['sell_id'];
        //$Path = Yii::app()->baseUrl . '/uploads/profile/';
        $sqlCkeck = "SELECT slip FROM tmpslip WHERE sell_id = '$sell_id' ";
        $rs = Yii::app()->db->createCommand($sqlCkeck)->queryRow();
        if ($rs['slip']) {
            if (file_exists('./uploads/slip/' . $rs['slip'])) {
                unlink('./uploads/slip/' . $rs['slip']);
            }
        }
// A list of permitted file extensions
        $allowed = array('jpg', 'jpeg');

        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {

            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

            $filename = $_FILES["upl"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
            $file_ext = substr($filename, strripos($filename, '.')); // get file name
            $newfilename = md5(date("H:i:s") . $file_basename) . $file_ext;

            if (!in_array(strtolower($extension), $allowed)) {
                echo 'error';
                exit;
            }

            $columns = array(
                "sell_id" => $sell_id,
                "slip" => $newfilename,
            );

            Yii::app()->db->createCommand()
                    ->insert("tmpslip", $columns);

            $images = $_FILES["upl"]["tmp_name"];
            //copy($_FILES["upl"]["tmp_name"],$Path.$newfilename);
            $width = 300; //*** Fix Width & Heigh (Autu caculate) ***//
            $size = GetimageSize($images);
            $height = round($width * $size[1] / $size[0]);
            $images_orig = ImageCreateFromJPEG($images);
            $photoX = ImagesX($images_orig);
            $photoY = ImagesY($images_orig);
            $images_fin = ImageCreateTrueColor($width, $height);
            ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
            ImageJPEG($images_fin, "uploads/slip/" . $newfilename);
            ImageDestroy($images_orig);
            ImageDestroy($images_fin);

            //if(move_uploaded_file($_FILES['upl']['tmp_name'],$Path.$newfilename)){
            echo 'success';
            exit;
            //}
        }

        echo 'error';
        exit;
    }

    public function actionLoadtmpslip() {
        $sell_id = Yii::app()->request->getPost('sell_id');
        $sql = "select * from tmpslip where sell_id = '$sell_id'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        if ($result['slip'] != '') {
            echo "หลักฐานการโอนเงิน";
            echo "<center><img src='" . Yii::app()->baseUrl . '/uploads/slip/' . $result['slip'] . "' class='img-responsive'/></center>";
        } else {
            echo "";
        }
    }

    public function actionLogselltransfer() {
        //$itemcode = Yii::app()->request->getPost('itemcode');
        $pid = Yii::app()->request->getPost('pid');
        $sellcode = Yii::app()->request->getPost('sellcode');
        $branch = Yii::app()->request->getPost('branch');
        $total = Yii::app()->request->getPost('total');
        $income = Yii::app()->request->getPost('income');
        //$change = Yii::app()->request->getPost('change');
        $totalfinal = Yii::app()->request->getPost('totalfinal');
        //$distcount = Yii::app()->request->getPost('distcount');
        $typebuy = Yii::app()->request->getPost('typebuy');
        $CheckOrder = Logsell::model()->find("sell_id = '$sellcode' ");
        //$user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $user_id = Yii::app()->request->getPost('employee');
        $accountnumber = Yii::app()->request->getPost('account');
        $sql = "select * from tmpslip where sell_id = '$sellcode' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if (empty($CheckOrder['sell_id'])) {
            $columns = array(
                "pid" => $pid,
                "sell_id" => $sellcode,
                "user_id" => $user_id,
                "branch" => $branch,
                "total" => $total,
                "income" => $income,
                //"change" => $change,
                "totalfinal" => $totalfinal,
                //"distcount" => $distcount,
                "typebuy" => $typebuy,
                "payment" => 2,
                "slip" => $rs['slip'],
                "accountnumber" => $accountnumber,
                "date_sell" => date("Y-m-d"),
            );
            Yii::app()->db->createCommand()
                    ->insert("logsell", $columns);
        } else {
            $columns = array(
                "pid" => $pid,
                "user_id" => $user_id,
                "branch" => $branch,
                "total" => $total,
                "income" => $income,
                //"change" => $change,
                "totalfinal" => $totalfinal,
                //"distcount" => $distcount,
                "typebuy" => $typebuy,
                "payment" => 2,
                "slip" => $rs['slip'],
                "accountnumber" => $accountnumber,
                "date_sell" => date("Y-m-d"),
                "d_update" => date("Y-m-d H:i:s"),
            );
            Yii::app()->db->createCommand()
                    ->update("logsell", $columns, "sell_id = '$sellcode'");
        }

        Yii::app()->db->createCommand()->delete("tmpslip", "sell_id='$sellcode'");

        $this->actionConfirmorder($sellcode);
    }

    public function actionReporttoday() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT *
                    FROM
                    (
                            (SELECT s.id,l.sell_id,IFNULL(e.`name`,'ไม่ระบุ') AS `name`,IFNULL(e.lname,'') AS lname,s.number,l.total,l.date_sell,s.d_update
                                    FROM logsell l LEFT JOIN patient e ON l.pid = e.pid
                                    INNER JOIN sell s ON l.sell_id = s.sell_id
                                    WHERE l.date_sell = DATE(NOW()) AND l.branch = '$branch' AND l.`typebuy` = '0'
                                    GROUP BY s.sell_id
                            )
                            UNION ALL
                            (
                                    SELECT s.id,l.sell_id,IFNULL(e.`name`,'ไม่ระบุ') AS `name`,IFNULL(e.lname,'') AS lname,s.number,l.total,l.date_sell,s.d_update
                                    FROM logsell l LEFT JOIN employee e ON l.pid = e.pid
                                    INNER JOIN sell s ON l.sell_id = s.sell_id
                                    WHERE l.date_sell = DATE(NOW()) AND l.branch = '$branch' AND l.`typebuy` = '1'
                                    GROUP BY s.sell_id
                            )
                    ) Q";
        $data['reporttoday'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->renderPartial('reporttoday', $data);
    }

    public function actionSumreporttoday() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT IFNULL(SUM(l.total),0) AS total
                FROM logsell l
                WHERE l.date_sell = DATE(NOW()) AND l.branch = '$branch' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        echo number_format($result['total']);
    }

}
