<?php

class ClinicstockproductController extends Controller {

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
    public function actionCreate($branch = null) {
        $model = new ClinicStockproduct;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ClinicStockproduct'])) {
            $model->attributes = $_POST['ClinicStockproduct'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id, 'branch' => $branch));
            }
        }

        $this->render('create', array(
            'branch' => $branch,
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = null) {
        $product = new ClinicStockproduct();

        $data['product'] = $product->_get_detail_productByid($id);

        $this->render("update", $data);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        $product_id = Yii::app()->request->getPost('product_id');
        $branch = Yii::app()->request->getPost('branch');
        Yii::app()->db->createCommand()
                ->delete("clinic_stockproduct", "product_id=:product_id and branch=:branch", array(":product_id" => $product_id, ":branch" => $branch));
    }

    /**
     * Lists all models.
     */
    public function actionIndex($branch) {
        $branchModel = new Branch();
        $branchname = $branchModel->Getbranch($branch);
        $this->render('index', array(
            'branch' => $branch,
            'branchname' => $branchname,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ClinicStockproduct('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['ClinicStockproduct'])) {
            $model->attributes = $_GET['ClinicStockproduct'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ClinicStockproduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ClinicStockproduct::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ClinicStockproduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'clinic-stockproduct-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetdata() {
        $type = Yii::app()->request->getPost('type_id');
        $branch = Yii::app()->request->getPost('branch');
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $Model = new ClinicStockproduct();
        $data['branch'] = $branch;
        $data['product'] = $Model->GetproductlistSearch($type, $subproducttype, $branch);

        $this->renderPartial('data', $data);
    }

    public function actionGetproductinsubtype() {
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $branch = Yii::app()->session['branch'];
        //AND c.branch = '$branch '
        //INNER JOIN clinic_stockproduct c ON s.product_id = c.product_id
        //ดึงข้อมูลสินค้าที่ยังไม่มีในรายการสินค้าของแต่ละสาขา
        $sql = "SELECT s.*
                    FROM center_stockproduct s
                    WHERE s.subproducttype = '$subproducttype'
                    AND s.status = '0' AND s.private = '0' AND s.delete_flag = '0'
                    AND s.product_id NOT IN(
                    SELECT c.product_id FROM clinic_stockproduct c WHERE c.branch = '$branch'
                    )";
        $data['product'] = Yii::app()->db->createCommand($sql)->queryAll();
        //$data['product'] = CenterStockproduct::model()->findAll("subproducttype = '$subproducttype' ");
        $this->renderPartial('comboproduct', $data);
    }

    public function actionGetproductinsubtypeorder() {
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $branch = Yii::app()->session['branch'];
        //AND c.branch = '$branch '
        //INNER JOIN clinic_stockproduct c ON s.product_id = c.product_id
        //ดึงข้อมูลสินค้าที่ยังไม่มีในรายการสินค้าของแต่ละสาขา
        $sql = "SELECT s.*
                    FROM center_stockproduct s INNER JOIN clinic_stockproduct c ON s.product_id = c.product_id
                    WHERE s.subproducttype = '$subproducttype'
                    AND s.status = '0' AND s.private = '0' AND s.delete_flag = '0'
                    AND c.branch = '$branch'";
        $data['product'] = Yii::app()->db->createCommand($sql)->queryAll();
        //$data['product'] = CenterStockproduct::model()->findAll("subproducttype = '$subproducttype' ");
        $this->renderPartial('comboproduct', $data);
    }

    public function actionSave_product() {

        $data = array(
            'product_id' => Yii::app()->request->getPost('product_id'),
            //'product_name' => Yii::app()->request->getPost('product_name'),
            //'product_nameclinic' => Yii::app()->request->getPost('product_nameclinic'),
            //'company' => Yii::app()->request->getPost('company'),
            //'product_detail' => Yii::app()->request->getPost('product_detail'),
            'product_price' => Yii::app()->request->getPost('product_price'),
            'costs' => Yii::app()->request->getPost('costs'),
            'type_id' => Yii::app()->request->getPost('type_id'),
            'subproducttype' => Yii::app()->request->getPost('subproducttype'),
            'unit' => Yii::app()->request->getPost('unit'),
            //'private' => Yii::app()->request->getPost('private'),
            'branch' => Yii::app()->request->getPost('branch'),
            'd_update' => date('Y-m-d H:i:s'),
        );

        Yii::app()->db->createCommand()
                ->insert('clinic_stockproduct', $data);
        //echo $this->redirect(array('backend/product/detail_product&product_id=' . $_POST['product_id']));
    }

    public function actionDetail($product_id = null, $branch = null) {
        //$product_id = $_GET['product_id'];

        $product = new Backend_product();
        $Model = new ClinicStockproduct();
        //$Items = new Items();

        $data['images'] = $product->get_images_product($product_id);
        $data['product'] = $Model->_get_detail_product($product_id, $branch);
        $data['branch'] = $branch;
        $data['product_id'] = $product_id;
        //$data['items'] = $Items->GetItem($product_id);
        //$data['near'] = $product->get_product_near($product_id);

        $this->render("detail", $data);
    }

    public function actionSave_update() {
        $id = Yii::app()->request->getPost('id');
        $data = array(
            //'product_name' => Yii::app()->request->getPost('product_name'),
            //'product_nameclinic' => Yii::app()->request->getPost('product_nameclinic'),
            //'company' => Yii::app()->request->getPost('company'),
            //'product_detail' => Yii::app()->request->getPost('product_detail'),
            'product_price' => Yii::app()->request->getPost('product_price'),
            //'costs' => Yii::app()->request->getPost('costs'),
            //'type_id' => Yii::app()->request->getPost('type_id'),
            //'subproducttype' => Yii::app()->request->getPost('subproducttype'),
            'unit' => Yii::app()->request->getPost('unit'),
            //'private' => Yii::app()->request->getPost('private'),
            'd_update' => date('Y-m-d H:i:s'),
        );

        Yii::app()->db->createCommand()
                ->update('clinic_stockproduct', $data, "id = '$id'");
    }

    public function actionImportdrug() {
        $result = Yii::app()->db->createCommand("CALL import_product_to_clinic")->query();
        if ($result) {
            echo "1";
        } else {
            echo "0";
        }
    }

}
