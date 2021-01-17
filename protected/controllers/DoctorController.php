<?php

class DoctorController extends Controller {

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
                'actions' => array('create', 'update', 'doctorsearch', 'patientview',
                    'saveservicedetail', 'getdetailservice', 'deletedetailservice', 'saveetc',
                    'getdetailserviceetc', 'deleteetcservice', 'patientviewhistory', 'getdetailserviceview',
                    'getdetailserviceetcview', 'doctorconfirm', 'updateservicedetail', 'getdetaildrugjson',
                    'patientviewhistorymobile', 'printcetificate', 'printrefer'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex() {
        $this->render('index');
    }

    public function actionDoctorsearch() {

        $branch = Yii::app()->session['branch'];
        if ($branch == "99") {
            $b = " ";
        } else {
            $b = " AND branch = '$branch' ";
        }

        $card = Yii::app()->request->getPost('card');
        //$patient = Patient::model()->find("card = '$card' ");
        $sql = "SELECT * FROM patient WHERE card = '$card' $b";
        $patient = Yii::app()->db->createCommand($sql)->queryRow();
        if ($patient['card']) {
            $this->renderPartial('doctorsearch', array("patient" => $patient));
        } else {
            echo "0";
        }
    }

    public function actionPatientview($id, $service_id = null, $promotion = null) {
        $this->layout = "template_history";
        /*
          if (!empty($appoint)) {
          $columns = array("status" => '1');
          Yii::app()->db->createCommand()
          ->update("appoint", $columns, "id = '$id'");
          }
         *
         */

        //หา service ครั้งล่าสุด
        $serviceDrugLastService = "SELECT max(id) as lastservice FROM service WHERE patient_id = '$id' AND id != '$service_id'";
        $rsLastService = Yii::app()->db->createCommand($serviceDrugLastService)->queryRow();
        if (!empty($rsLastService['lastservice'])) {
            $data['lastService'] = $rsLastService['lastservice'];
        } else {
            $data['lastService'] = 0;
        }
        //ประวัติครั้งล่าสุด
        $data['lastserviceDetail'] = $this->getLastService($rsLastService['lastservice']);
        $sqlpatientDrug = "select * from patient_drug where patient_id = '$id' ";
        $data['rsPatientDrug'] = Yii::app()->db->createCommand($sqlpatientDrug)->queryAll();

        $sqlpatientDisease = "select * from patient_disease where patient_id = '$id' ";
        $data['rsPatientDisease'] = Yii::app()->db->createCommand($sqlpatientDisease)->queryAll();

        $data['drugAll'] = $this->getDrugPatient($id);
        Yii::app()->db->createCommand()->update("service", array("status" => "2"), "id = '$service_id'");
        //$data['contact'] = PatientContact::model()->find("patient_id = '$id'");
        $data['model'] = Patient::model()->find("id = '$id'");
        $checkbodyModel = new Checkbody();
        $data['checkbody'] = $checkbodyModel->Checkbody($service_id);

        //OpenService
        $data['patient_id'] = $id;
        $data['serviceSEQ'] = ($service_id);
        $data['service_id'] = $service_id;
        //$this->actionCheckImages($data['serviceSEQ']);
        //$data['contact'] = PatientContact::model()->find("patient_id = '$patient_id'");
        $data['patient'] = Patient::model()->find("id = '$id'");
        $data['service'] = Service::model()->find("id=:id", array(":id" => $service_id));
        $data['promotion'] = $promotion;

        $data['certificate'] = $this->getCertificate($service_id);
        $data['refer'] = $this->getRefer($service_id);
        //เช็คโปรโมชั่นว่าเหลือกี่ครั้ง
        $ProModel = new Promotionprocedure();
        if ($promotion != '' && $promotion != '0') {
            $pid = $data['patient']['pid'];
            $this->Promotion($promotion, $pid, $service_id, $data['service']['service_date']);
            $countnumber = $ProModel->GetresultPromotion($promotion, $data['patient']['pid'], $service_id);
            $data['promotiondetail'] = $ProModel->GetpromotionPatient($promotion, $data['patient']['pid']) . $countnumber;
        } else {
            $data['promotiondetail'] = "";
        }
        $this->render('patientview', $data);
    }

    function getLastService($serviceId) {
        $sql = "SELECT s.service_date,s.appoint,s.appoint_detail,s.appoint_hours,s.appoint_minute,d.detail,d.`comment`,d.diag,d.`procedure`
                    FROM service s INNER JOIN service_detail d ON s.id = d.service_id
                    WHERE s.id = '$serviceId'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs;
    }

    function getDrugPatient($patientId) {
        $sql = "SELECT p.product_nameclinic,s.drug_method
                    FROM service_drug s INNER JOIN center_stockproduct p ON s.drug = p.product_id
                    WHERE s.patient_id = '$patientId'
                    GROUP BY p.product_id
                    ORDER BY s.date_serv DESC ";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    function getCertificate($serviceid) {
        $sql = "select * from medicalcertificate where service_id = '$serviceid'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs;
    }

    function Promotion($promotion, $pid, $service_id, $service_date) {
        //Yii::app()->getModule('promotionprocedure');
        //เช็คว่าครบครั้งรึยัง
        $promotionNom = Promotionprocedure::model()->find("id=:id", array(":id" => $promotion));
        $Pronumber = $promotionNom['number'];
        $ProService = Promotionprocedureservice::model()->findAll("promotion=:promotion and pid=:pid", array(":promotion" => $promotion, ":pid" => $pid));
        $count = count($ProService);
        $user_id = Yii::app()->user->id;
        if ($count < $Pronumber) {
            //ไม่ให้บันทึกซ้ำกันในวันเดียวกัน
            $dateNow = date("Y-m-d");
            $CheckProService = Promotionprocedureservice::model()->find("promotion=:promotion and pid=:pid and create_date=:date", array(":promotion" => $promotion, ":pid" => $pid, ":date" => $service_date));
            if (empty($CheckProService)) {
                $Level = ($count + 1);
                $Columns = array("promotion" => $promotion, "pid" => $pid, "employee" => $user_id, "level" => $Level, "service_id" => $service_id, "create_date" => $service_date);
                Yii::app()->db->createCommand()
                        ->insert("promotionprocedureservice", $Columns);

                $this->CheckpromotionSuccess($promotion, $pid, $Pronumber);
            }
        }
    }

    function CheckpromotionSuccess($promotion, $pid, $number) {
        //Yii::app()->getModule('promotionprocedureservice');
        $ProService = Promotionprocedureservice::model()->findAll("promotion=:promotion and pid=:pid", array(":promotion" => $promotion, ":pid" => $pid));
        $count = count($ProService);
        if ($count == $number) {
            $Columns = array("status" => "1");
            Yii::app()->db->createCommand()
                    ->update("Promotionprocedureregister", $Columns, "pid='$pid' and promotion='$promotion'");
        }
    }

    public function actionPatientviewhistory($id, $service_id = null, $flag, $promotion = null) {
        /*
          if (!empty($appoint)) {
          $columns = array("status" => '1');
          Yii::app()->db->createCommand()
          ->update("appoint", $columns, "id = '$id'");
          }
         *
         */
        $this->layout = "template_history";
        //$data['contact'] = PatientContact::model()->find("patient_id = '$id'");
        $data['model'] = Patient::model()->find("id=:id", array("id" => $id));
        $checkbodyModel = new Checkbody();
        $data['checkbody'] = $checkbodyModel->Checkbody($service_id);
        $data['Modelservice'] = Service::model()->find("id=:id", array(":id" => $service_id));
        //OpenService
        $data['patient_id'] = $id;
        $data['serviceSEQ'] = ($service_id);
        $data['service_id'] = $service_id;

        //หา service ครั้งล่าสุด
        $serviceDrugLastService = "SELECT max(id) as lastservice FROM service WHERE patient_id = '$id' AND id != '$service_id'";
        $rsLastService = Yii::app()->db->createCommand($serviceDrugLastService)->queryRow();
        if (!empty($rsLastService['lastservice'])) {
            $data['lastService'] = $rsLastService['lastservice'];
        } else {
            $data['lastService'] = 0;
        }
        //ประวัติครั้งล่าสุด
        $data['lastserviceDetail'] = $this->getLastService($rsLastService['lastservice']);
        $data['drugAll'] = $this->getDrugPatient($id);
        //$this->actionCheckImages($data['serviceSEQ']);
        //$data['contact'] = PatientContact::model()->find("patient_id = '$patient_id'");
        $data['patient'] = $data['model'];
        $data['flag'] = $flag;
        $Modelservice = new Service();
        $data['procedure'] = $Modelservice->Procedure($service_id);
        $data['datalistservice'] = $Modelservice->Listservice($service_id);
        $data['service'] = Service::model()->find("id = '$service_id'");
        $data['certifiate'] = $this->getCertificate($service_id);
        $data['refer'] = $this->getRefer($service_id);
        //ผู้บันทึกข้อมูล
        $Author = Employee::model()->find("id=:id", array(":id" => $data['Modelservice']['doctor']));
        if ($data['Modelservice']['flag_service'] == "0") {
            $data['authors'] = "บันทึกการตรวจโดย " . $Author['name'] . " " . $Author['name'];
        } else {
            $data['authors'] = "พนักงานบันทึกแทนหมอ " . $Author['name'] . " " . $Author['name'];
        }
        //ดึงโปรโมชั่นมาแสดงถ้ามี
        $ProModel = new Promotionprocedure();
        if ($promotion != '' && $promotion != '0') {
            //$data['promotiondetail'] = $this->Getpromotion($promotion, $data['patient']['pid']);
            //ครั้งที่มารับบริการ
            $countnumber = $ProModel->GetresultPromotionHistory($promotion, $data['patient']['pid'], $service_id);
            $data['promotiondetail'] = $ProModel->GetpromotionPatientHistory($promotion, $data['patient']['pid'], $service_id) . $countnumber;
        } else {
            $data['promotiondetail'] = "";
        }
        $data['promotion'] = $promotion;
        $this->render('patientviewhistory', $data);
    }

    function Getpromotion($promotion, $pid) {
        $Model = new Promotionprocedure();
        $ProModel = $Model->Getpromotion($promotion);
        $ProRegis = Promotionprocedureservice::model()->findAll("promotion=:promotion and pid=:pid", array(":promotion" => $promotion, ":pid" => $pid));
        $count = count($ProRegis);

        return "คอร์ส:: " . $ProModel['diagname'] . " " . $ProModel['number'] . " ครั้ง คงเหลือ " . ($ProModel['number'] - $count) . " ครั้ง";
    }

    public function actionCheckImages($id) {
        $ServiceID = Service::model()->find("id = '$id'")['id'];
        $img = "";
        if (empty($ServiceID)) {
            $result = ServiceImages::model()->findAll("seq = '$id' ");
            foreach ($result as $rs) {
                $img .= $rs['images'] . "<br/>";
                unlink("./uploads/img_service/" . $rs['images']);
            }

            Yii::app()->db->createCommand()
                    ->delete("service_images", "seq = '$id' ");
        }
        //return $img;
    }

    public function actionSaveservicedetail() {
        $patient_id = Yii::app()->request->getPost('patient_id');
        $detail = Yii::app()->request->getPost('detail');
        $comment = Yii::app()->request->getPost('comment');
        $diag = Yii::app()->request->getPost('diag');
        //$procedure = Yii::app()->request->getPost('procedure');
        $price = Yii::app()->request->getPost('price');
        $service_id = Yii::app()->request->getPost('service_id');
        $doctor = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];

        $columns = array(
            "patient_id" => $patient_id,
            "detail" => $detail,
            "comment" => $comment,
            "price" => $price,
            "service_id" => $service_id,
            "diag" => $diag,
            //"procedure" => $procedure,
            "doctor" => $doctor,
            "date_serv" => date("Y-m-d H:i:s"),
        );
        Yii::app()->db->createCommand()
                ->insert("service_detail", $columns);
    }

    public function actionUpdateservicedetail() {
        $detail = Yii::app()->request->getPost('detail');
        $comment = Yii::app()->request->getPost('comment');
        $diag = Yii::app()->request->getPost('diag');
        $procedure = Yii::app()->request->getPost('procedure');
        $price = Yii::app()->request->getPost('price');
        $service_id = Yii::app()->request->getPost('service_id');
        $doctor = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];

        $columns = array(
            "detail" => $detail,
            "comment" => $comment,
            "price" => $price,
            "diag" => $diag,
            //"procedure" => $procedure,
            "doctor" => $doctor,
            "date_serv" => date("Y-m-d H:i:s"),
        );
        Yii::app()->db->createCommand()
                ->update("service_detail", $columns, "service_id = '$service_id'");
    }

    public function actionComboitem() {
        $items = new Items();
        $data['itemlist'] = $items->GetProductSell();
        /*
          $data['itemlist'] = $items->GetItemSell();
         *
         */
        $this->renderPartial('comboitem', $data);
    }

    public function actionGetdetailservice($service_id) {
        $sql = "SELECT * FROM service_detail WHERE service_id = '$service_id' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $grid = "<table style='width:100%;' class='table table-striped'>
                <thead>
                    <tr>
                        <th>การรักษา</th>
                        <th>อื่น ๆ</th>
                        <th style='text-align:right;'>ราคา</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($result as $row):
            $grid .= "<tr>
																			                        <td style='padding:3px;'>" . $row['detail'] . "</td>
																			                        <td style='padding:3px;'>" . $row['comment'] . "</td>
																			                        <td style='padding:3px;text-align:right;'>" . number_format($row['price'], 2) . "</td>
																			                        <td style='padding:3px;text-align:center;'>
																			                            <a href='javascript:deletedetailservice(" . $row['id'] . ")'><i class='fa fa-trash text-danger'></i></a>
																			                        </td>
																			                    </tr>";
        endforeach;
        $grid .= "</tbody></table>";

        echo $grid;
    }

    public function actionGetdetailserviceview($service_id) {
        $sql = "SELECT * FROM service_detail WHERE service_id = '$service_id' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $grid = "<table style='width:100%;' class='table table-striped'>
                <thead>
                    <tr>
                        <th>การรักษา</th>
                        <th>อื่น ๆ</th>
                        <th style='text-align:right;'>ราคา</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($result as $row):
            $grid .= "<tr>
																			                        <td style='padding:3px;'>" . $row['detail'] . "</td>
																			                        <td style='padding:3px;'>" . $row['comment'] . "</td>
																			                        <td style='padding:3px;text-align:right;'>" . number_format($row['price'], 2) . "</td>
																			                    </tr>";
        endforeach;
        $grid .= "</tbody></table>";

        echo $grid;
    }

    public function actionSaveetc() {
        $patient_id = Yii::app()->request->getPost('patient_id');
        $detail = Yii::app()->request->getPost('detail_etc');
        $price = Yii::app()->request->getPost('price_etc');
        $service_id = Yii::app()->request->getPost('service_id');
        $doctor = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $columns = array(
            "patient_id" => $patient_id,
            "service_id" => $service_id,
            "detail" => $detail,
            "price" => $price,
            "doctor" => $doctor,
            "date_serv" => date("Y-m-d H:i:s"),
        );
        Yii::app()->db->createCommand()
                ->insert("service_etc", $columns);
    }

    public function actionDeletedetailservice() {
        $id = Yii::app()->request->getPost('id');
        Yii::app()->db->createCommand()
                ->delete("service_detail", "id = $id");
    }

    public function actionGetdetailserviceetc($service_id) {
        $sql = "SELECT s.* FROM service_etc s WHERE service_id = '$service_id' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $grid = "<table style='width:100%;' class='table table-striped'>
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th style='text-align:right;'>ราคา</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($result as $row):
            $grid .= "<tr>
																			                        <td style='padding:3px;'>" . $row['detail'] . "</td>
																			                        <td style='padding:3px;text-align:right;'>" . number_format($row['price'], 2) . "</td>
																			                        <td style='padding:3px;text-align:center;'>
																			                            <a href='javascript:deleteEtcService(" . $row['id'] . ")'><i class='fa fa-trash text-danger'></i></a>
																			                        </td>
																			                    </tr>";
        endforeach;
        $grid .= "</tbody></table>";

        echo $grid;
    }

    public function actionGetdetailserviceetcview($service_id) {
        $sql = "SELECT s.* FROM service_etc s WHERE service_id = '$service_id' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $grid = "<table style='width:100%;' class='table table-striped'>
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th style='text-align:right;'>ราคา</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($result as $row):
            $grid .= "<tr>
																			                        <td style='padding:3px;'>" . $row['detail'] . "</td>
																			                        <td style='padding:3px;text-align:right;'>" . number_format($row['price'], 2) . "</td>

																			                    </tr>";
        endforeach;
        $grid .= "</tbody></table>";

        echo $grid;
    }

    public function actionDeleteetcservice() {
        $id = Yii::app()->request->getPost('id');
        Yii::app()->db->createCommand()
                ->delete("service_etc", "id = '$id'");
    }

    public function actionDoctorconfirm() {
        $service_id = Yii::app()->request->getPost('service_id');
        $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        if (Yii::app()->session['status'] == '2') {
            $columns = array("status" => "3", "doctor" => $user_id, 'flag_service' => '0');
        } else {
            $columns = array("status" => "3", "doctor" => $user_id, 'flag_service' => '1');
        }
        Yii::app()->db->createCommand()
                ->update("service", $columns, "id = '$service_id'");
    }

    public function actionGetdetaildrugjson() {
        $product_id = Yii::app()->request->getPost('product_id');
        $sql = "select * from center_stockproduct where product_id = '$product_id' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        $json = array(
            "size" => $rs['size'],
            "product_name" => $rs['product_name'],
        );

        echo json_encode($json);
    }

    public function actionPatientviewhistorymobile($id, $service_id = null, $flag, $promotion = null) {
        /*
          if (!empty($appoint)) {
          $columns = array("status" => '1');
          Yii::app()->db->createCommand()
          ->update("appoint", $columns, "id = '$id'");
          }
         *
         */
        $this->layout = "template_history";
        //$data['contact'] = PatientContact::model()->find("patient_id = '$id'");
        $data['model'] = Patient::model()->find("id=:id", array("id" => $id));
        $checkbodyModel = new Checkbody();
        $data['checkbody'] = $checkbodyModel->Checkbody($service_id);
        $data['Modelservice'] = Service::model()->find("id=:id", array(":id" => $service_id));
        //OpenService
        $data['patient_id'] = $id;
        $data['serviceSEQ'] = ($service_id);
        $data['service_id'] = $service_id;
        //$this->actionCheckImages($data['serviceSEQ']);
        //$data['contact'] = PatientContact::model()->find("patient_id = '$patient_id'");
        $data['patient'] = $data['model'];
        $data['flag'] = $flag;
        $Modelservice = new Service();
        $data['procedure'] = $Modelservice->Procedure($service_id);
        $data['datalistservice'] = $Modelservice->Listservice($service_id);
        $data['service'] = Service::model()->find("id = '$service_id'");
        //ผู้บันทึกข้อมูล
        $Author = Employee::model()->find("id=:id", array(":id" => $data['Modelservice']['doctor']));
        if ($data['Modelservice']['flag_service'] == "0") {
            $data['authors'] = "บันทึกการตรวจโดย " . $Author['name'] . " " . $Author['name'];
        } else {
            $data['authors'] = "พนักงานบันทึกแทนหมอ " . $Author['name'] . " " . $Author['name'];
        }
        //ดึงโปรโมชั่นมาแสดงถ้ามี
        $ProModel = new Promotionprocedure();
        if ($promotion != '' && $promotion != '0') {
            //$data['promotiondetail'] = $this->Getpromotion($promotion, $data['patient']['pid']);
            //ครั้งที่มารับบริการ
            $countnumber = $ProModel->GetresultPromotionHistory($promotion, $data['patient']['pid'], $service_id);
            $data['promotiondetail'] = $ProModel->GetpromotionPatientHistory($promotion, $data['patient']['pid'], $service_id) . $countnumber;
        } else {
            $data['promotiondetail'] = "";
        }
        $data['promotion'] = $promotion;
        $this->render('patientviewhistorymobile', $data);
    }

    public function actionPrintcetificate($service_id = "") {
        $Masuser = new Masuser();
        $Profile = $Masuser->GetProfile();
        $sql = "select * from form_txt where id = '1'";
        $data['form'] = Yii::app()->db->createCommand($sql)->queryRow();
        $data['company'] = Companycenter::model()->find("id=:id", array(":id" => 1));
        $columns = array("employeename" => $Profile['name'] . "   " . $Profile['lname']);
        Yii::app()->db->createCommand()
                ->update("medicalcertificate", $columns, "service_id = '$service_id'");
        $data['datas'] = $this->getCertificate($service_id);
        $this->renderPartial('certificate', $data);
    }

    public function actionPrintrefer($service_id = "") {
        $sql = "select * from form_txt where id = '1'";
        $data['form'] = Yii::app()->db->createCommand($sql)->queryRow();

        $data['datas'] = $this->getRefer($service_id);
        $this->renderPartial('refer', $data);
    }

    function getRefer($serviceid) {
        $sql = "select * from refer where service_id = '$serviceid'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        return $rs;
    }

}
