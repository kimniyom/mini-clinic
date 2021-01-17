<?php

class PatientController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $enableCsrfValidation = false;
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
                'actions' => array('index', 'view', 'checkpatient',
                    'save_upload', 'getdata', 'history', 'appoint', 'sellhistory', 'getappointpatient',
                    'deleteappoint', 'detailsell', 'delete', 'serverside', 'getserverside', 'search', 'datasearch', 'viewpopup',
                    'searchpatientselect', 'datasearchpatient', 'sumbuyall', 'getcn', 'updatecn', 'checkpatientsmartcard', 'registersmartcard', 'updateregister', 'saveseq', 'getseq'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'dortorsearch', 'delete'),
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
        $contact = PatientContact::model()->find("patient_id = '$id'");
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'contact' => $contact,
        ));
    }

    public function actionViewpopup($id) {
        $contact = PatientContact::model()->find("patient_id = '$id'");
        $this->renderPartial('view', array(
            'model' => $this->loadModel($id),
            'contact' => $contact,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Patient;
        $config = new Configweb_model();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Patient'])) {
            $model->attributes = $_POST['Patient'];
            $cid = $_POST['Patient']['card'];
            $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
            $model->card = str_replace("-", "", $cid);
            $model->pid = $config->autoId("patient", "pid", "10");
            $model->cn = $this->Getcn();
            $model->d_update = date("Y-m-d");
            $model->emp_id = $user_id;
            if ($model->save()) {
                //$this->redirect(array('patientcontact/create', 'id' => $model->id));
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    function Getcn() {
        /*
          $branch = Yii::app()->session['branch'];
          $cn = $this->autoId("patient", "cn", "6", $branch);
         */
        $sql = "SELECT MAX(CAST(SUBSTRING_INDEX(cn, '-', -1) AS UNSIGNED)) + 1 as newcn FROM patient";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs['newcn']) {
            return $this->autoId("patient", "cn", "6", 1);
        } else {
            return '000001';
        }
    }

    function autoId($table, $value, $number, $branch) {
        $rs = Yii::app()->db->createCommand("Select Max($value)+1 as MaxID from  $table where branch = '$branch'")->queryRow();
        //เ     ลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
        $new_id = $rs['MaxID'];
        if ($new_id == '') {
            //          ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
            $std_id = sprintf("%0" . $number . "d", 1);
            //ถ         ้าไม่ใช่ค่าว่าง
        } else {
            $std_id = sprintf("%0" . $number . "d", $new_id);
            //ถ         ้าไม่ใช่ค่าว่าง
        }

        return $std_id;
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

        if (isset($_POST['Patient'])) {
            $model->attributes = $_POST['Patient'];
            $cid = $_POST['Patient']['card'];
            $model->card = str_replace("-", "", $cid);
            $model->d_update = date("Y-m-d");

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
    public function actionDelete() {
        $id = Yii::app()->request->getPost('id');
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        //if (!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $config = new Configweb_model();
        echo $pid = $config->autoId("patient", "pid", "10");
        exit();
        $branch = Yii::app()->session['branch'];
        $data['branchModel'] = Branch::model()->find('id=:id', array(':id' => $branch));
        $data['branch'] = $branch;
        if ($branch == "99") {
            $BranchList = Branch::model()->findAll("id != '99'");
        } else {
            $BranchList = Branch::model()->findAll("id = '$branch'");
        }

        $data['BranchList'] = $BranchList;
        $this->render('index', $data);
    }

    public function actionGetdata() {
        $branch = Yii::app()->request->getPost('branch');
        if ($branch == "99") {
            $WHERE = "";
        } else {
            $WHERE = "branch = '$branch'";
        }

        $data['patient'] = Patient::model()->findAll($WHERE);
        $this->renderPartial('getdata', $data);
    }

    public function actionServerside() {
        $config = new Configweb_model();
        $masUser = new Masuser();
        $emp = $masUser->GetProfile();
        $data['export'] = $config->userExportPatient($emp['user_id']);
        $data['branch'] = Yii::app()->request->getPost('branch');
        $this->renderPartial('serverside', $data);
    }

    public function actionGetserverside() {
        $requestData = $_REQUEST;
//$branch = "99";
        $branch = Yii::app()->request->getPost('branch');

        if ($branch == "99") {
            $WHERE = "";
        } else {
            $WHERE = "branch = '$branch'";
        }
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'lname',
        );
        $patient = Patient::model()->findAll($WHERE);

        $totalData = count($patient);
        $totalFiltered = $totalData;

        $sql = "SELECT p.id,p.images,p.tel,p.cn,pid,name,lname,branchname,grad";
        $sql .= " FROM patient p inner join branch b on p.branch = b.id inner join gradcustomer g on p.type = g.id WHERE 1=1";
        if (!empty($requestData['search']['value'])) {
            // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql .= " AND ( name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR lname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR branchname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pid LIKE '" . $requestData['search']['value'] . "%' )";
        }

        if (!empty($branch)) {
            if ($branch == "99") {
                $sql .= " AND 1=1 ";
            } else {
                $sql .= " AND p.branch = '$branch' ";
            }
            //$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
        }
        $querysearch = Yii::app()->db->createCommand($sql)->queryAll();
        $totalFiltered = count($querysearch);

        $query = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();

        $img = '<div class="container-card set-views-card box-all">';
        $img .= '<div class="img-wrapper">';
        foreach ($query as $row) {
            // preparing an array
            if (!empty($row['images'])) {
                $img .= "<img src='" . Yii::app()->baseUrl . "/uploads/profile/" . $row['images'] . "'";
                $img .= " class='img-responsive img-polaroid' style='height:30px;'/>";
            } else {
                $img = "<img src='" . Yii::app()->baseUrl . "/images/No_image.jpg'";
                $img .= " class='img-responsive img-polaroid' style='height:30px;'/>";
            }
            $img .= '</div></div>';
            $nestedData = array();
            $nestedData[] = $row["id"];
            //$nestedData[] = $img;
            //$nestedData[] = "'" . $row["pid"] . "'";
            $nestedData[] = "'" . $row["cn"] . "'";
            $nestedData[] = $row["name"] . ' ' . $row["lname"];
            $nestedData[] = "'" . $row["tel"] . "'";
            $nestedData[] = $row["branchname"];
            $nestedData[] = $row["grad"];
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data, // total data array
        );

        echo json_encode($json_data); // send data as json format
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Patient('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Patient'])) {
            $model->attributes = $_GET['Patient'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Patient the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Patient::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Patient $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'patient-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCheckpatient() {
        $card = Yii::app()->request->getPost('card');

        $sql = "SELECT COUNT(*)AS total FROM patient WHERE card = '$card'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        if ($result['total']) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function actionSave_upload() {
        $id = $_GET['id'];

        $sqlCkeck = "SELECT images FROM patient WHERE id = '$id' ";
        $rs = Yii::app()->db->createCommand($sqlCkeck)->queryRow();
        $filename = './uploads/profile/' . $rs['images'];

        if (!file_exists($filename)) {
            unlink('./uploads/profile/' . $rs['images']);
        }

        $allowed = array('jpg', 'jpeg');

        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {

            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
            //$Path = Yii::app()->baseUrl . '/uploads/profile/';

            $filename = $_FILES["upl"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
            $file_ext = substr($filename, strripos($filename, '.')); // get file name
            $newfilename = md5($file_basename) . $file_ext;

            if (!in_array(strtolower($extension), $allowed)) {
                echo 'error';
                exit;
            }

            $columns = array(
                "images" => $newfilename,
            );

            Yii::app()->db->createCommand()
                    ->update("patient", $columns, "id = '$id' ");

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
            ImageJPEG($images_fin, "uploads/profile/" . $newfilename);
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

    public function actionDortorsearch() {
        $card = Yii::app()->request->getPost('card');
        $patient = Patient::model()->find("card = '$card' ");
        if ($patient['card']) {
            $this->renderPartial('dortorsearch', array("patient" => $patient));
        } else {
            echo "0";
        }
    }

    public function actionHistory() {
        $patient_id = Yii::app()->request->getPost('patient_id');
        $sql = "SELECT s.*,b.branchname
          FROM service s INNER JOIN branch b ON s.branch = b.id
          WHERE s.patient_id = '$patient_id' AND s.status = '4' ORDER BY s.id DESC LIMIT 10";
        $data['history'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->renderPartial('history', $data);
    }

    public function actionAppoint() {
        $patient_id = Yii::app()->request->getPost('patient_id');
        $sql = "SELECT a.id,a.appoint,b.branchname
            FROM appoint a INNER JOIN branch b ON a.branch = b.id
            WHERE a.patient_id = '$patient_id' AND a.status = '0' ORDER BY a.id DESC";
        $data['appoint'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->renderPartial('appoint', $data);
    }

    public function actionSellhistory() {
        $pid = Yii::app()->request->getPost('pid');
        $sql = "SELECT s.*
              FROM logsell s WHERE s.pid = '$pid' AND s.typebuy = '0'
              ORDER BY s.id DESC LIMIT 10";
        $data['sell'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->renderPartial('sellhistory', $data);
    }

    public function actionGetappointpatient() {
        $Config = new Configweb_model();
        $Model = new Appoint();
        $appoint_id = Yii::app()->request->getPost('appoint_id');
        $appoint = $Model->GetappointPatient($appoint_id);

        $str = "";
        $str .= "<table class='table'><tr><td>วันที่นัด</td><td>" . $Config->thaidate($appoint['appoint']) . "</td></tr>";
        $str .= "<tr><td>ประเภทนัด</td><td>" . $Model->Typeappoint($appoint['type']) . "</td></tr>";
        $str .= "<tr><td>อื่น ๆ</td><td>" . $appoint['etc'] . "</td></tr>";
        $str .= "</table>";

        echo $str;
    }

    public function actionDeleteappoint() {
        $appoint_id = Yii::app()->request->getPost('appoint_id');
        Yii::app()->db->createCommand()
                ->delete("appoint", "id = '$appoint_id'");
    }

    public function actionDetailsell($sell_id) {
        $Model = new Sell();
        //$sell_id = Yii::app()->request->getPost('sell_id');
        $data['order'] = $Model->Getordersell($sell_id);
        $data['detail'] = $Model->Detailorder($sell_id);
        $data['logsell'] = Logsell::model()->find("sell_id=:sell_id", array(':sell_id' => $sell_id));
        $this->renderPartial('detailsell', $data);
    }

    public function actionSearch() {
        $this->render('searchpatient');
    }

    public function actionDatasearch() {
        $cn = Yii::app()->request->getPost('cn');
        $name = Yii::app()->request->getPost('name');
        $lname = Yii::app()->request->getPost('lname');
        if ($cn != "") {
            $where = " p.cn = '$cn'";
        } else if ($cn == "" && $name != "" && $lname == "") {
            $where = " p.name like '%$name%'";
        } else if ($cn == "" && $name != "" && $lname != "") {
            $where = " p.name like '%$name%' and p.lname like '%$lname%'";
        } else if ($cn == "" && $name == "" && $lname != "") {
            $where = " p.lname like '%$lname%'";
        }

        $sql = "select p.*,b.branchname,g.grad
        from patient p inner join branch b on p.branch = b.id
        inner join gradcustomer g on p.type = g.id where $where";
        //echo $sql;

        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $data['patient'] = $rs;
        $this->renderPartial('datasearch', $data);
    }

    public function actionSearchpatientselect() {
        $this->renderPatient('datasearchselect');
    }

    public function actionDatasearchpatient() {
        $pid = Yii::app()->request->getPost('pid');
        $name = Yii::app()->request->getPost('name');
        $lname = Yii::app()->request->getPost('lname');
        $where = "";
        if ($pid != "") {
            $where .= " p.pid = '$pid'";
        } else if ($pid == "" && $name != "" && $lname == "") {
            $where .= " p.name like '%$name%'";
        } else if ($pid == "" && $name != "" && $lname != "") {
            $where .= " p.name like '%$name%' and p.lname like '%$lname%'";
        } else if ($pid == "" && $name == "" && $lname != "") {
            $where .= " p.lname like '%$lname%'";
        }

        $sql = "select p.*,b.branchname,g.grad from patient p inner join branch b on p.branch = b.id left join gradcustomer g on p.type = g.id where $where";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $data['patient'] = $rs;
        $this->renderPartial('datasearchselect', $data);
    }

    public function actionSumbuyall() {
        $pid = Yii::app()->request->getPost('pid');
        $patient_id = Yii::app()->request->getPost('patient_id');
        $sql = "select sum(totalfinal) as total from logsell where pid='$pid'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        $sumsell = $rs['total'];

        $sql1 = "select sum(price_total) as total from service where patient_id='$patient_id'";
        $rss = Yii::app()->db->createCommand($sql1)->queryRow();
        $sumservice = $rss['total'];

        $sumAll = ($sumsell + $sumservice);
        echo "(รวมค่าใช้จ่าย " . number_format($sumAll) . ".-)";
    }

    public function actionUpdatecn() {
        $id = Yii::app()->request->getPost('id');
        $cn = Yii::app()->request->getPost('cn');

        $sql = "select COUNT(*) AS total from patient where id = '$id' and cn = '$cn'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs['total'] > 0) {
            echo "1";
        } else {
            $columns = array("cn" => $cn);
            Yii::app()->db->createCommand()
                    ->update("patient", $columns, "id = '$id'");
            echo "0";
        }
    }

    //Api SmartCard
    public function actionCheckpatientsmartcard() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        $name = Yii::app()->request->getPost('name');
        $lname = Yii::app()->request->getPost('lname');

        $sql = "select p.*
				from patient p
				where p.name like '%$name%' and p.lname like '%$lname%'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if (empty($rs['name'])) {
            echo 1;
        } else {
            $sqlDrug = "SELECT GROUP_CONCAT(drug) AS drug FROM patient_drug WHERE patient_id = '" . $rs['id'] . "'";
            $rsDrug = Yii::app()->db->createCommand($sqlDrug)->queryRow();

            $sqlDisease = "SELECT GROUP_CONCAT(disease) AS disease FROM patient_disease WHERE patient_id = '" . $rs['id'] . "'";
            $rsDisease = Yii::app()->db->createCommand($sqlDisease)->queryRow();
            $json = array(
                "name" => $rs['name'],
                "lname" => $rs['lname'],
                "tel" => $rs['tel'],
                "id" => $rs['id'],
                "hn" => $rs['cn'],
                "drug" => $rsDrug['drug'],
                "disease" => $rsDisease['disease'],
            );
            echo json_encode($json);
        }
    }

    public function actionRegistersmartcard() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        try {
            $config = new Configweb_model();
            $card = Yii::app()->request->getPost('card');
            $name = Yii::app()->request->getPost('name');
            $lname = Yii::app()->request->getPost('lname');
            $birth = Yii::app()->request->getPost('birth');
            $tel = Yii::app()->request->getPost('tel');
            $contact = Yii::app()->request->getPost('contact');
            $sex = Yii::app()->request->getPost('sex');
            $patientdrug = Yii::app()->request->getPost('patient_drug');
            $patientdisease = Yii::app()->request->getPost('patient_disease');
            $cn = $this->Getcn();
            $pid = $config->autoId("patient", "pid", "10");
            $columns = array(
                "name" => $name,
                "lname" => $lname,
                "card" => $card,
                "birth" => $birth,
                "tel" => $tel,
                "contact" => $contact,
                "sex" => $sex,
                "branch" => "1",
                "cn" => $cn,
                "pid" => $pid,
                "type" => "3",
                "create_date" => date("Y-m-d H:i:s"),
                "d_update" => date("Y-m-d H:i:s"),
            );

            Yii::app()->db->createCommand()
                    ->insert("patient", $columns);

            $Json = array("hn" => $cn, "status" => 1);

            if ($patientdrug != "" || $patientdisease != "") {
                $sql = "select max(id) as newId from patient";
                $rs = Yii::app()->db->createCommand($sql)->queryRow();
                $id = $rs['newId'];

                $this->Savedrug($id, $patientdrug, $patientdisease);
            }
            echo json_encode($Json);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function actionUpdateregister() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        try {
            $id = Yii::app()->request->getPost('id');
            $card = Yii::app()->request->getPost('card');
            $name = Yii::app()->request->getPost('name');
            $lname = Yii::app()->request->getPost('lname');
            $birth = Yii::app()->request->getPost('birth');
            $tel = Yii::app()->request->getPost('tel');
            $contact = Yii::app()->request->getPost('contact');
            $sex = Yii::app()->request->getPost('sex');
            $patientdrug = Yii::app()->request->getPost('patient_drug');
            $patientdisease = Yii::app()->request->getPost('patient_disease');
            //$cn = $this->Getcn();
            $columns = array(
                "name" => $name,
                "lname" => $lname,
                "card" => $card,
                "birth" => $birth,
                "tel" => $tel,
                "contact" => $contact,
                "sex" => $sex,
                "d_update" => date("Y-m-d H:i:s"),
            );

            Yii::app()->db->createCommand()
                    ->update("patient", $columns, "id = '$id'");

            $Json = array("status" => 1);

            if ($patientdrug != "" || $patientdisease != "") {
                $this->Savedrug($id, $patientdrug, $patientdisease);
            }

            echo json_encode($Json);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function Savedrug($id, $patientdrug, $patientdisease) {
        if ($patientdrug != "") {
            $sqlDrug = "SELECT GROUP_CONCAT(drug) AS drug FROM patient_drug WHERE patient_id = '$id'";
            $rsDrug = Yii::app()->db->createCommand($sqlDrug)->queryRow();
            if ($rsDrug['drug'] != "") {
                $columns = array("drug" => $patientdrug);
                Yii::app()->db->createCommand()
                        ->update("patient_drug", $columns, "patient_id = '$id'");
            } else {
                $columns = array("patient_id" => $id, "drug" => $patientdrug);
                Yii::app()->db->createCommand()
                        ->insert("patient_drug", $columns);
            }
        }

        if ($patientdisease != "") {
            $sqlDisease = "SELECT GROUP_CONCAT(disease) AS disease FROM patient_disease WHERE patient_id = '$id'";
            $rsDisease = Yii::app()->db->createCommand($sqlDisease)->queryRow();
            if ($rsDisease['disease'] != "") {
                $columns = array("patient_id" => $id, "disease" => $patientdisease);
                Yii::app()->db->createCommand()
                        ->update("patient_disease", $columns, "patient_id = '$id'");
            } else {
                $columns = array("patient_id" => $id, "disease" => $patientdisease);
                Yii::app()->db->createCommand()
                        ->insert("patient_disease", $columns);
            }
        }
    }

    public function actionSaveseq() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        $patient = Yii::app()->request->getPost('patient');
        $date_service = date("Y-m-d");
        $branch = 1;
        //ดึงข้อมูลวันนัดล่าสุดมาอัพเดท5้ามีการนัด

        $sql = "SELECT * FROM appoint WHERE patient_id = '$patient' AND status = '0' LIMIT 1";
        $appoint = Yii::app()->db->createCommand($sql)->queryRow();
        if ($appoint['appoint']) {
            $id = $appoint['id'];
            $status = array("status" => '1');
            Yii::app()->db->createCommand()
                    ->update("appoint", $status, "id = '$id'");
        }

        $columns = array(
            "patient_id" => $patient,
            "promotion" => "",
            "branch" => $branch,
            "user_id" => 1,
            "service_date" => $date_service,
        );

        Yii::app()->db->createCommand()
                ->insert("service", $columns);

        //รหัสบริการมากสุด
        $sqlMaxservice = "SELECT MAX(id) AS id FROM service ";
        $rsService = Yii::app()->db->createCommand($sqlMaxservice)->queryRow();
        $ServiceId = $rsService['id'];

        //ตรวจร่างกาย
        $btemp = Yii::app()->request->getPost('btemp');
        $pr = Yii::app()->request->getPost('pr');
        $rr = Yii::app()->request->getPost('rr');
        $weight = Yii::app()->request->getPost('weight');
        $height = Yii::app()->request->getPost('height');
        $ht = Yii::app()->request->getPost('ht');
        $waistline = Yii::app()->request->getPost('waistline');
        $cc = Yii::app()->request->getPost('cc');
        //$user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $columnsbody = array(
            "patient_id" => $patient,
            "btemp" => $btemp,
            "pr" => $pr,
            "rr" => $rr,
            "weight" => $weight,
            "height" => $height,
            "ht" => $ht,
            "waistline" => $waistline,
            "cc" => $cc,
            "date_serv" => $date_service,
            "user_id" => 1,
            "service_id" => $ServiceId,
        );

        Yii::app()->db->createCommand()
                ->insert("checkbody", $columnsbody);
        $this->LinrNotify($patient);
        echo 1;
    }

    function LinrNotify($patient) {
        $sql = "select * from patient where id = '$patient' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        //$message = "test";
        //$token = "tTB2872QNBu50i3FXUWsN1IKEZgqVHU9QdV0zLNTbst";
        $token = "KlUQGDiGhLxFzpNrMmKMzajA2kjcPH07q9gKgpXo1ja";
        //echo send_line_notify($message, $token);
        //function send_line_notify($message, $token) {

        $message = "";
        if ($rs) {
            //return; //ถ้าข้อความแจ้งเตือนเป็นค่าว่าง ไม่มีการแจ้งเตือนในไลน์

            $message .= "มีคิวคนไข้ " . $rs['name'] . " " . $rs['lname'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$message");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token",);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
        //}
    }

    public function actionGetseq() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        $Model = new Service();
        $Patient = new Patient();
        $branch = "1";
        $data['PatientList'] = $Patient->GetPatient();
        $data['seq'] = $Model->GetseqEmployee($branch);

        $this->renderPartial('getseq', $data);
    }

}
