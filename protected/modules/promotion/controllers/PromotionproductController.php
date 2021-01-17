<?php

class PromotionproductController extends Controller {

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
        $model = new Promotionproduct;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $error = "";
        if (isset($_POST['Promotionproduct'])) {
            $model->attributes = $_POST['Promotionproduct'];
            $product_id = $model->product_id;
            $model->create_date = date("Y-m-d");
            $priceold = CenterStockproduct::model()->find("product_id=:product_id", array(":product_id" => $product_id));
            $productpriceOld = $priceold['product_price'];
            $model->priceold = $productpriceOld;
            $checkPromotion = Promotionproduct::model()->find("product_id=:product_id and active=:active", array(":product_id" => $product_id, ":active" => "0"));
            if ($checkPromotion['product_id'] != "") {
                $promotion = $checkPromotion;
                $error = $this->error($promotion);
            } else {
                if ($model->save())
                    $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'error' => $error
        ));
    }

    public function error($promotion) {
        $promotionname = CenterStockproduct::model()->find("product_id=:product_id", array(":product_id" => $promotion['product_id']))['product_nameclinic'];
        $url = Yii::app()->createUrl('promotion/promotionproduct/update',array('id' => $promotion['id']));
        $str = "";
        $str .= '<div class="alert alert-danger">';
        $str .= 'สินค้ามีการจัดโปรโมชั่นอยู่แล้วแก้ไขข้อมูลโปรโมชั่นเดิมเป็น "ไม่ใช้" เพื่อสร้างใหม่<br/>';
        $str .= $promotionname . '(' . $promotion['promotionname'] . ')';
        $str .= 'ราคาเดิม <del>' . $promotion['priceold'] . '</del> ราคาโปรโมชั่น ' . number_format($promotion['price']) . '<br/>';
        $str .= '<a href="'.$url.'"><button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> แก้ไขโปรโมชั่นเดิม</button></a>';
        $str .= '</div>';
        return $str;
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

        if (isset($_POST['Promotionproduct'])) {
            $model->attributes = $_POST['Promotionproduct'];
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $data['promotion'] = Promotionproduct::model()->findAll("active=:active", array(":active" => "0"));
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Promotionproduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Promotionproduct']))
            $model->attributes = $_GET['Promotionproduct'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Promotionproduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Promotionproduct::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Promotionproduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'promotionproduct-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
