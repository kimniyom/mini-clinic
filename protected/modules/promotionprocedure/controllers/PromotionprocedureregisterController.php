<?php

class PromotionprocedureregisterController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'template_backend';

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
        $this->render('create');
    }

    public function actionGetpromotions() {
        $type = Yii::app()->request->getPost('type');
        if ($type == "0") {
            $sql = "select p.*,d.diagname from promotionprocedure p inner join diag d on p.diag = d.diagcode where p.status = '0' and p.type = '0'";
        } else if ($type == "1") {
            $months = date("m");
            if(strlen($months) < 2){
                $month = "0".$months;
            } else {
                $month = $months;
            }
            $year = date("Y");
            $sql = "select p.*,d.diagname from promotionprocedure p inner join diag d on p.diag = d.diagcode where p.status = '0' and p.type = '1' and p.month = '$month' and p.year = '$year'";
        }
        
        $promotion = Yii::app()->db->createCommand($sql)->queryAll();
        $str = "";
        $str = '<select id="promotion" class="form-control" onchange="getpromotion()">';
        $str .= '<option value="">=== กรุณาเลือกโปรโมชั่น ===</option>';
        foreach ($promotion as $pro):
            $str .= '<option value="'.$pro['id'].'">'.$pro['diagname'] . " " . $pro['number'] . " ครั้ง " . number_format($pro['price']) .'บาท </option>';
        endforeach;
       $str .= '</select>';
       echo $str;
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

        if (isset($_POST['Promotionprocedureregister'])) {
            $model->attributes = $_POST['Promotionprocedureregister'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        Yii::app()->db->createCommand()
                ->update("promotionprocedureregister", array("status" => '1'), "id = '$id'");
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $sql = "SELECT r.*,p.number,p.price,d.diagname
                FROM promotionprocedureregister r INNER JOIN promotionprocedure p ON r.promotion = p.id
                INNER JOIN diag d ON p.diag = d.diagcode WHERE r.status = '0'";
        $data['register'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Promotionprocedureregister('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Promotionprocedureregister']))
            $model->attributes = $_GET['Promotionprocedureregister'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Promotionprocedureregister the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Promotionprocedureregister::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Promotionprocedureregister $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'promotionprocedureregister-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSearchpatient() {
        $name = Yii::app()->request->getPost('name');
        $lname = Yii::app()->request->getPost('lname');
        if ($name != "" && $lname == "") {
            $where = " p.name like '%$name%'";
        } else if ($name != "" && $lname != "") {
            $where = " p.name like '%$name%' and p.lname like '%$lname%'";
        }

        $sql = "select p.*,b.branchname from patient p inner join branch b on p.branch = b.id where $where";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $data['patient'] = $rs;
        $this->renderPartial('datasearchselect', $data);
    }

    public function actionPatient() {
        $pid = Yii::app()->request->getPost('pid');
        $Model = new Patient();
        $rs = $Model->GetpatientPid($pid);
        $str = "";
        $str .= "<label>รหัส : </label> " . $rs['pid'];
        //$str .= "<br/><label>บัตรประชาชน : </label> " . $rs['card'];
        $str .= "<br/><label>คุณ : </label> " . $rs['name'] . " " . $rs['lname'];
        //$str .= "<br/><label>ที่อยู่ : </label> " . $rs['contact'];
        $str .= "<br/><label>เบอร์โทรศัพท์ : </label> " . $rs['tel'];
        $str .= "<br/><label>ประเภทลูกค้า : </label> " . $rs['grad'];
        //$str .= "<br/><label>ส่วนลด : </label> " . $rs['distcountsell'] . " <label>บาท</label>";
        //$str .= "<input type='hidden' id='distcount' class='form-control' value='".$rs['distcountsell']."'/>";
        //$str .= "<script>$(document).ready(function(){ $('#distcount').val(" . $rs['distcountsell'] . ");});</script>";
        if ($rs) {
            echo $str;
        }
    }

    public function actionGetpromotion() {
        $id = Yii::app()->request->getPost('id');
        $pro = new Promotionprocedure();
        $rs = $pro->Getpromotion($id);
        $str = "";
        $str .= "<label>หัตถการ : </label> " . $rs['diagname'];
        //$str .= "<br/><label>บัตรประชาชน : </label> " . $rs['card'];
        $str .= "<br/><label>โควต้า : </label> " . $rs['limit'];
        $str .= "<br/><label>จำนวน : </label> " . $rs['number'] . " <label> ครั้ง</label>";
        $str .= "<br/><label>ระยะเวลา : </label> " . $rs['date_start'] . " " . $rs['date_end'];
        $str .= "<br/><label>ราคา : </label> " . number_format($rs['price'], 2) . " <label>บาท</label>";
        $str .= "<br/><label>รายละเอียด : </label> " . $rs['detail'];
        //$str .= "<input type='hidden' id='distcount' class='form-control' value='".$rs['distcountsell']."'/>";
        //$str .= "<script>$(document).ready(function(){ $('#distcount').val(" . $rs['distcountsell'] . ");});</script>";
        if ($rs) {
            echo $str;
        }
    }

    public function actionSave() {
        $promotion = Yii::app()->request->getPost('promotion');
        $pid = Yii::app()->request->getPost('pid');
        $comment = Yii::app()->request->getPost('comment');
        $branch = Yii::app()->session['branch'];
        $pro = Promotionprocedureregister::model()->find("promotion=:promotion", array(":promotion" => $promotion));
        $count = count($pro);
        if ($count > 0) {
            echo "1";
        } else {
            $columns = array("promotion" => $promotion, "pid" => $pid, "branch" => $branch, "status" => "0", "comment" => $comment, "create_date" => date("Y-m-d H:i:s"));
            Yii::app()->db->createCommand()
                    ->insert("promotionprocedureregister", $columns);
            echo "0";
        }
    }

}
