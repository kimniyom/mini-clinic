<?php

class CenterstockmixController extends Controller {

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
                'actions' => array('create', 'update','addmix','getmixer','deletemixer','getitem'),
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
        $model = new CenterStockmix;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CenterStockmix'])) {
            $model->attributes = $_POST['CenterStockmix'];
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

        if (isset($_POST['CenterStockmix'])) {
            $model->attributes = $_POST['CenterStockmix'];
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
    public function actionDeletemixer() {
        $id = Yii::app()->request->getPost('id');
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        /*
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
         * 
         */
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('CenterStockmix');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CenterStockmix('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CenterStockmix']))
            $model->attributes = $_GET['CenterStockmix'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CenterStockmix the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CenterStockmix::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CenterStockmix $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'center-stockmix-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddmix() {
        $itemid = Yii::app()->request->getPost('itemid');
        $product_id = Yii::app()->request->getPost('product_id');
        $number = Yii::app()->request->getPost('number');
        $columns = array(
            "itemid" => $itemid,
            "product_id" => $product_id,
            "number" => $number,
            "create_date" => date("Y-m-d")
        );

        Yii::app()->db->createCommand()
                ->insert("center_stockmix", $columns);
    }
    
    public function actionGetmixer(){
        $product_id = Yii::app()->request->getPost('product_id');
        $Model = new CenterStockmix();
        $data['mixer'] = $Model->Getmixer($product_id);
        $this->renderPartial('mixer',$data);
    }
    
    public function actionGetitem(){
        $product_id = Yii::app()->request->getPost('product_id');
        $data['number'] = Yii::app()->request->getPost('number');
        $Model = new CenterStockmix();
        $data['mixer'] = $Model->Getiteminproduct($product_id);
        $this->renderPartial('getitem',$data);
    }

}
