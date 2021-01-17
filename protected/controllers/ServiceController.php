<?php

class ServiceController extends Controller {

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
                'actions' => array('create', 'update', 'detail', 'formservice', 'uploadify', 'loadimages', 'checkImages', 'saveservice',
                    'checkresultservice', 'deleteitem', 'sumservice', 'bill', 'confirmservice', 'cutstock', 'deleteorder', 'checkdetail',
                    'savepopup', 'confirmpricedrug', 'saveappoint', 'getappoint', 'savecertificate',
                    'saverefer', 'getserviceremat'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Service;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Service'])) {
            $model->attributes = $_POST['Service'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Service'])) {
            $model->attributes = $_POST['Service'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Service');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Service('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Service'])) {
            $model->attributes = $_GET['Service'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Service the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Service::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Service $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDetail($patient_id, $diagcode) {
        //OpenService
        $data['patient_id'] = $patient_id;
        $Max = Yii::app()->db->createCommand("SELECT MAX(id) AS id FROM service")->queryRow()['id'];
        $data['serviceSEQ'] = ($Max + 1);

        $this->actionCheckImages($data['serviceSEQ']);

        $data['contact'] = PatientContact::model()->find("patient_id = '$patient_id'");
        $data['patient'] = Patient::model()->find("id = '$patient_id'");
        $data['diag'] = Diag::model()->find("diagcode = '$diagcode'");
        $this->renderPartial("detail", $data);
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

    public function actionFormservice($seq) {
        $data['seq'] = $seq;
        $data['model'] = Service::model()->find("id = '$seq'");

        $this->renderPartial("formservice", $data);
    }

    function Randstrgen() {
        $len = 30;
        $result = "";
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $charArray = str_split($chars);
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }
        return $result;
    }

    public function actionUploadify($seq = null) {

// Define a destination

        $targetFolder = Yii::app()->baseUrl . '/uploads/img_service'; // Relative to the root
        if (!empty($_FILES)) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $FULLNAME = $_FILES['Filedata']['name'];
            $type = substr($FULLNAME, -3);
            $Name = "img_" . $this->Randstrgen() . "." . $type;
            $targetFile = $targetPath . '/' . $Name;

//$targetFile = $targetFolder . '/' . $_FILES['Filedata']['name'];
            //$targetFile = $targetFolder . '/' . $Name;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'JPEG', 'png', 'PNG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
//$GalleryShot = $_FILES['Filedata']['name'];

            /*
              $tempFile = $_FILES['Filedata']['tmp_name'];
              $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
              $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];

              // Validate the file type
              $fileTypes = array('rar', 'pdf', 'zip'); // File extensions
              $fileParts = pathinfo($_FILES['Filedata']['name']);
             */

            if (in_array($fileParts['extension'], $fileTypes)) {

                $columns = array(
                    'seq' => $seq,
                    'images' => $Name,
                    'create_date' => date("Y-m-d H:i:s"),
                );
                Yii::app()->db->createCommand()
                        ->insert("service_images", $columns);

                $width = 1280; //*** Fix Width & Heigh (Autu caculate) ***//
                //$new_images = "Thumbnails_".$_FILES["Filedata"]["name"];
                $size = getimagesize($_FILES['Filedata']['tmp_name']);
                $height = round($width * $size[1] / $size[0]);
                $images_orig = imagecreatefromjpeg($tempFile);
                $photoX = imagesx($images_orig);
                $photoY = imagesy($images_orig);
                $images_fin = imagecreatetruecolor($width, $height);
                imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                imagejpeg($images_fin, "uploads/img_service/" . $Name);
                imagedestroy($images_orig);
                imagedestroy($images_fin);

                //move_uploaded_file($tempFile, $targetFile); เก่า
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function actionLoadimages() {
        $seq = Yii::app()->request->getPost('seq');
        $data['datas'] = ServiceImages::model()->findAll("seq = '$seq' ");
        $this->renderPartial('images', $data);
    }

    public function actionSaveservice() {
        $id = Yii::app()->request->getPost('id');
        $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        if (!empty($id)) {
            $columns = array(
                //"seq" => Yii::app()->request->getPost('seq'),
                "patient_id" => Yii::app()->request->getPost('patient_id'),
                "diagcode" => Yii::app()->request->getPost('diagcode'),
                "price_total" => Yii::app()->request->getPost('price_total'),
                "service_result" => Yii::app()->request->getPost('service_result'),
                "comment" => Yii::app()->request->getPost('comment'),
                "branch" => Yii::app()->request->getPost('branch'),
                "user_id" => $user_id,
                //"checkbody" => date("Y-m-d"),
                //"service_date" => date("Y-m-d"),
                "d_update" => date("Y-m-d H:i:s"),
            );

            Yii::app()->db->createCommand()
                    ->update("service", $columns, "id = '$id' ");
        } else {
            $columns = array(
                //"seq" => Yii::app()->request->getPost('seq'),
                "patient_id" => Yii::app()->request->getPost('patient_id'),
                "diagcode" => Yii::app()->request->getPost('diagcode'),
                "price_total" => Yii::app()->request->getPost('price_total'),
                "service_result" => Yii::app()->request->getPost('service_result'),
                "comment" => Yii::app()->request->getPost('comment'),
                "branch" => Yii::app()->request->getPost('branch'),
                "user_id" => $user_id,
                "checkbody" => date("Y-m-d"),
                "service_date" => date("Y-m-d"),
                "d_update" => date("Y-m-d H:i:s"),
            );

            Yii::app()->db->createCommand()
                    ->insert("service", $columns);
        }
    }

    public function actionCheckresultservice() {
        $service_id = Yii::app()->request->getPost('service_id');
        $result = Service::model()->find("id = '$service_id'");
        if (empty($result['id'])) {
            $val = 0;
        } else {
            $val = 1;
        }
        $json = array("result" => $val);
        echo json_encode($json);
    }

    public function actionDeleteitem() {
        $service_id = Yii::app()->request->getPost('service_id');
        $product_id = Yii::app()->request->getPost('product_id');

        $sql = "SELECT * FROM logserviceproduct WHERE service_id = '$service_id' AND product_id = '$product_id' ";
        $item = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($item as $rs):
            $itemcode = $rs['itemcode'];
            Yii::app()->db->createCommand()
                    ->update("items", array("status" => "0"), "itemcode = '$itemcode' ");
        endforeach;

        Yii::app()->db->createCommand()
                ->delete("logserviceproduct", "service_id = '$service_id' AND product_id = '$product_id' ");

        Yii::app()->db->createCommand()
                ->delete("service_drug", "service_id = '$service_id' AND drug = '$product_id' ");
    }

    public function actionSumservice() {
        $Model = new Service();
        $service_id = Yii::app()->request->getPost('service_id');
        $TOTAL = $Model->SUMservice($service_id);
        echo number_format($TOTAL, 2);
    }

    /*
      public function actionBill($service_id) {
      $Model = new Service();
      $ProModel = new Promotionprocedure();
      $data['listdetail'] = $Model->Listservice($service_id);
      $data['detail'] = $Model->GetdetailBillservice($service_id);
      $promotion = $data['detail']['promotion'];
      if ($promotion != '' && $promotion != '0') {
      $data['promotiondetail'] = $ProModel->GetpromotionPatient($promotion, $data['detail']['pid']);
      $data['promotionresultprice'] = $ProModel->GetresultPromotion($promotion, $data['detail']['pid'], $service_id);
      } else {
      $data['promotiondetail'] = "";
      $data['promotionresultprice'] = "";
      }
      $this->renderPartial('bill', $data);
      }
     */

    //Update 2020-01-31
    public function actionBill($service_id) {
        $Model = new Service();
        $ProModel = new Promotionprocedure();
        $data['listdetail'] = $Model->Listservice($service_id);
        $data['detail'] = $Model->GetdetailBillservice($service_id);
        $promotion = $data['detail']['promotion'];
        $data['procedure'] = $Model->Procedure($service_id);
        if ($promotion != '' && $promotion != '0') {
            $data['promotiondetail'] = $ProModel->GetpromotionPatient($promotion, $data['detail']['pid']);
            $data['promotionresultprice'] = $ProModel->GetresultPromotion($promotion, $data['detail']['pid'], $service_id);
        } else {
            $data['promotiondetail'] = "";
            $data['promotionresultprice'] = "";
        }
        $this->renderPartial('bill', $data);
    }

    public function actionConfirmservice() {
        $service_id = Yii::app()->request->getPost('service_id');
        $price_total = Yii::app()->request->getPost('price_total');
        $payment = Yii::app()->request->getPost('payment');
        $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $columns = array(
            "status" => "4",
            "user_bill" => $user_id,
            "price_total" => $price_total,
            "payment" => $payment,
        );
        Yii::app()->db->createCommand()
                ->update("service", $columns, "id = '$service_id'");

        //ส่วนของตัดสต๊อก
        $sql = "SELECT s.drug AS product_id,s.number
                    FROM service_drug s
                    WHERE s.service_id = '$service_id' ";
        $listdetail = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($listdetail as $rs):
            $product_id = $rs['product_id'];
            $number = $rs['number'];
            $this->actionCutstock($product_id, $number);
        endforeach;
    }

    public function actionCutstock($product_id, $number) {
        $sql = "SELECT *
                FROM clinic_storeproduct i
                WHERE i.product_id = '$product_id' AND i.total > 0
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

    public function actionDeleteorder() {
        $serviceid = Yii::app()->request->getPost('serviceid');
        $productid = Yii::app()->request->getPost('productid');
        Yii::app()->db->createCommand()
                ->delete("service_drug", "service_id = '$serviceid' and drug = '$productid'");
    }

    public function actionCheckdetail() {
        $serviceid = Yii::app()->request->getPost('service_id');
        $sql = "select * from service_detail where service_id = '$serviceid'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();

        if ($rs['id'] != "") {
            $columns = array(
                "detail" => $rs['detail'],
                "comment" => $rs['comment'],
                "diag" => $rs['diag'],
                "procedure" => $rs['procedure'],
                "price" => $rs['price'],
            );
        } else {
            $columns = array("detail" => "");
        }

        echo json_encode($columns);
    }

    public function actionSavepopup() {
        $serviceid = Yii::app()->request->getPost('service_id');
        $columns = array("popup" => 1);
        Yii::app()->db->createCommand()
                ->update("service", $columns, "id = '$serviceid'");
    }

    public function actionConfirmpricedrug() {
        $serviceid = Yii::app()->request->getPost('service_id');
        $pricedrug = Yii::app()->request->getPost('pricedrug');
        $service_procedure = Yii::app()->request->getPost('service_procedure');
        $columns = array("pricedrug" => $pricedrug);
        Yii::app()->db->createCommand()
                ->update("service", $columns, "id = '$serviceid'");

        //Update ServiceDetail
        $columnsDetail = array("procedure" => $service_procedure);
        Yii::app()->db->createCommand()
                ->update("service_detail", $columnsDetail, "service_id = '$serviceid'");
    }

    public function actionSaveappoint() {
        $serviceid = Yii::app()->request->getPost('service_id');
        $appoint = Yii::app()->request->getPost('appoint');
        $appoint_hours = Yii::app()->request->getPost('appoint_hours');
        $appoint_minute = Yii::app()->request->getPost('appoint_minute');
        $appoint_detail = Yii::app()->request->getPost('appoint_detail');
        $columns = array(
            "appoint" => $appoint,
            "appoint_detail" => $appoint_detail,
            "appoint_hours" => $appoint_hours,
            "appoint_minute" => $appoint_minute
        );
        $rs = Yii::app()->db->createCommand()
                ->update("service", $columns, "id = '$serviceid'");
        if ($rs) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function actionGetappoint() {
        $serviceid = Yii::app()->request->getPost('service_id');
        $sql = "select appoint from service where id = '$serviceid'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs['appoint'] != "") {
            echo $rs['appoint'];
        } else {
            echo "";
        }
    }

    public function actionSavecertificate() {
        $Masuser = new Masuser();
        $Profile = $Masuser->GetProfile();
        $flag = Yii::app()->request->getPost('flag');
        $id = Yii::app()->request->getPost('id');
        $service_id = Yii::app()->request->getPost('service_id');
        $patient_name = Yii::app()->request->getPost('patient_name');
        $id_card = Yii::app()->request->getPost('id_card');
        $age = Yii::app()->request->getPost('age');
        $comment = Yii::app()->request->getPost('comment');
        $day = Yii::app()->request->getPost('day');
        $datestart = Yii::app()->request->getPost('datestart');
        $dateend = Yii::app()->request->getPost('dateend');
        $doctor = $Profile['name'] . " " . $Profile['lname'];
        $columns = array(
            "service_id" => $service_id,
            "patient_name" => $patient_name,
            "id_card" => $id_card,
            "age" => $age,
            "comment" => $comment,
            "day" => $day,
            "datestart" => $datestart,
            "dateend" => $dateend,
            "doctor" => $doctor,
            "createdate" => date("Y-m-d"),
            "dupdate" => date("Y-m-d H:i:s")
        );
        if ($flag > 0) {
            Yii::app()->db->createCommand()
                    ->update("medicalcertificate", $columns, "id = '$id'");
        } else {
            Yii::app()->db->createCommand()
                    ->insert("medicalcertificate", $columns);
        }
    }

    public function actionPrintcetificate($serviceid = "") {

    }

    public function actionSaverefer() {
        $flag = Yii::app()->request->getPost('flag');
        $id = Yii::app()->request->getPost('id');
        $service_id = Yii::app()->request->getPost('service_id');
        $patient_name = Yii::app()->request->getPost('patient_name');
        $sendto = Yii::app()->request->getPost('sendto');
        $age = Yii::app()->request->getPost('age');
        $sex = Yii::app()->request->getPost('sex');
        $tel = Yii::app()->request->getPost('tel');
        $address = Yii::app()->request->getPost('address');
        $history = Yii::app()->request->getPost('history');
        $lab = Yii::app()->request->getPost('lab');
        $diag = Yii::app()->request->getPost('diag');
        $treat = Yii::app()->request->getPost('treat');
        $etc = Yii::app()->request->getPost('etc');
        $cause = Yii::app()->request->getPost('cause');
        $columns = array(
            "service_id" => $service_id,
            "name" => $patient_name,
            "sendto" => $sendto,
            "age" => $age,
            "sex" => $sex,
            "address" => $address,
            "history" => $history,
            "lab" => $lab,
            "diag" => $diag,
            "treat" => $treat,
            "etc" => $etc,
            "cause" => $cause,
            "tel" => $tel,
            "date_refer" => date("Y-m-d"),
            "d_update" => date("Y-m-d H:i:s")
        );
        if ($flag > 0) {
            Yii::app()->db->createCommand()
                    ->update("refer", $columns, "id = '$id'");
        } else {
            Yii::app()->db->createCommand()
                    ->insert("refer", $columns);
        }
    }

    public function actionGetserviceremat() {
        $config = new Configweb_model();
        $patientId = Yii::app()->request->getPost('patientId');
        $serviceId = Yii::app()->request->getPost('serviceId');
        $sql = "SELECT *
                FROM service s
                WHERE s.patient_id = '$patientId' AND s.id != '$serviceId'
                ORDER BY s.service_date DESC";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $str = "";

        //$str .= "<table><thead><tr>";
        //$str .= "<th>#</th>";
        //$str .= "<th>#</th>";
        //$str .= "</tr></thead>";
        $i = 0;
        foreach ($result as $rs):
            $i++;
            $result = $this->getDrugRemet($rs['id']);
            //if ($i > 1) {
            if (count($result) > 0) {
                $str .= "<button class='btn btn-success pull-right' onclick='remedDrug(" . $rs['id'] . ")'>เลือก</button>";
                $str .= "<h4>วันที่ " . $config->thaidate($rs['service_date']) . "(ค่ายา " . $rs['pricedrug'] . ")</h4>";
                $str .= "<table class='table table-striped'><thead><tr><th>ยา</th><th>วิธีช้</th><th>จำนวน</th></tr></thead>";
                $str .= "<tbody>";
                foreach ($result as $rss):
                    $str .= "<tr>";
                    $str .= "<td>" . $rss['product_name'] . "</td>";
                    $str .= "<td>" . $rss['drug_method'] . "</td>";
                    $str .= "<td>" . $rss['number'] . "</td>";
                    $str .= "</tr>";
                endforeach;
                $str .= "</tbody></table>";
                //}
            }
        endforeach;
        echo $str;
        //$str .= "</table>";
    }

    function getDrugRemet($serviceId) {
        $sql = "SELECT d.drug,c.product_name,d.drug_method,d.price,d.number,d.total
                    FROM service_drug d INNER JOIN center_stockproduct c ON d.drug = c.product_id
                    WHERE d.service_id = '$serviceId'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
