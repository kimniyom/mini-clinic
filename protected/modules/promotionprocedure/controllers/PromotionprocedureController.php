<?php

class PromotionprocedureController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'template_backend';

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
        $model = new Promotionprocedure;
        if (isset($_POST['Promotionprocedure'])) {
            $model->attributes = $_POST['Promotionprocedure'];
            $model->user_id = Yii::app()->user->id;
            $model->year = date("Y");
            $model->type = "1";
            $model->create_date = date("Y-m-d H:i:s");
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['Promotionprocedure'])) {
            $model->attributes = $_POST['Promotionprocedure'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdates($id) {
        $model = $this->loadModel($id);
        $this->render('updates', array(
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
        $rs = Promotionprocedureregister::model()->findAll("promotion=:promotion", array(":promotion" => $id));
        $count = count($rs);
        if ($count <= 0) {
            Yii::app()->db->createCommand()
                    ->delete("promotionprocedure", "id='$id'");
            echo "0";
        } else {
            echo "1";
        }
    }

    public function actionCreates(){
        $this->render('_formcreate');
    }

    public function actionSavepromotion(){
        $diag = Yii::app()->request->getPost('diag');
        $number = Yii::app()->request->getPost('number');
        $price = Yii::app()->request->getPost('price');
        $detail = Yii::app()->request->getPost('detail');
        $user = Yii::app()->user->id;
        $columns = array(
            "diag" => $diag,
            "number" => $number,
            "limit" => 0,
            "price" => $price,
            "user_id" => $user,
            "type" => 0,
            "detail" => $detail,
            "create_date" => date("Y-m-d H:i:s")
        );
        Yii::app()->db->createCommand()
            ->insert("promotionprocedure",$columns);
    }

    public function actionSaveupdatepromotion(){
        $id = Yii::app()->request->getPost('id');
        $diag = Yii::app()->request->getPost('diag');
        $number = Yii::app()->request->getPost('number');
        $price = Yii::app()->request->getPost('price');
        $detail = Yii::app()->request->getPost('detail');
        $user = Yii::app()->user->id;
        $columns = array(
            "diag" => $diag,
            "number" => $number,
            //"limit" => 0,
            "price" => $price,
            //"user_id" => $user,
            //"type" => 0,
            "detail" => $detail,
            //"create_date" => date("Y-m-d H:i:s")
        );
        Yii::app()->db->createCommand()
            ->update("promotionprocedure",$columns,"id='$id'");
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $Config = new Configweb_model();
        $month = date("m");
        if(strlen($month) < 2){
            $months = "0".$month;
        } else {
            $months = $month;
        }
        $data['month'] = $Config->MonthFullArrays()[$month];
        $data['promotion'] = Promotionprocedure::model()->findAll("status=:status and type=:type", array(":status" => "0",":type" => "0"));
        $data['promotionmonth'] = Promotionprocedure::model()->findAll("status=:status and type=:type and month=:month", array(":status" => "0",":type" => "1",":month" => $months));
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Promotionprocedure('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Promotionprocedure']))
            $model->attributes = $_GET['Promotionprocedure'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Promosionprocedure the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Promotionprocedure::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Promosionprocedure $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'promotionprocedure-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
