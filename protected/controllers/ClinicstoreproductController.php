<?php

class ClinicstoreproductController extends Controller {

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
                'actions' => array('create', 'update', 'saveproduct', 'getsubproduct', 'getproductinsubtype',
                    'getdatastockproduct', 'searchproduct', 'datasearchproduct', 'deleteproductlot', 'moveproduct'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'getdatastockproduct'),
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
    public function actionCreate($branch = null) {
        $model = new ClinicStoreproduct;
        $branchModel = new Branch();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        /*
          if (isset($_POST['ClinicStoreproduct'])) {
          $model->attributes = $_POST['ClinicStoreproduct'];
          if ($model->save())
          $this->redirect(array('view', 'id' => $model->id));
          }
         *
         */
        $branchname = $branchModel->Getbranch($branch);
        $this->render('create', array(
            'branch' => $branch,
            'branchname' => $branchname
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

        if (isset($_POST['ClinicStoreproduct'])) {
            $model->attributes = $_POST['ClinicStoreproduct'];
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
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex($branch = null) {
        $branchModel = new Branch();
        $data['branchname'] = $branchModel->Getbranch($branch);
        $data['branch'] = $branch;
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ClinicStoreproduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ClinicStoreproduct']))
            $model->attributes = $_GET['ClinicStoreproduct'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ClinicStoreproduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ClinicStoreproduct::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ClinicStoreproduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'clinic-storeproduct-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetdatastockproduct() {
        $type = Yii::app()->request->getPost('type_id');
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $branch = Yii::app()->request->getPost('branch');
        $Model = new ClinicStoreproduct();
        $data['product'] = $Model->Searchstore($type, $subproducttype, $branch);
        $data['branch'] = Branch::model()->find("id=:id", array(":id" => $branch));
        $data['branchlist'] = Branch::model()->findAll("active=:active", array(":active" => "1"));
        $this->renderPartial('datastockproduct', $data);
    }

    public function actionSaveproduct() {

        $data = array(
            'product_id' => Yii::app()->request->getPost('product_id'),
            'lotnumber' => Yii::app()->request->getPost('lotnumber'),
            'number' => Yii::app()->request->getPost('number'),
            'total' => Yii::app()->request->getPost('number'),
            //'lotnumber' => Yii::app()->request->getPost('lotnumber'),
            'generate' => Yii::app()->request->getPost('generate'),
            'expire' => Yii::app()->request->getPost('expire'),
            'branch' => Yii::app()->request->getPost('branch'),
            'd_update' => date('Y-m-d H:i:s')
        );

        Yii::app()->db->createCommand()
                ->insert('clinic_storeproduct', $data);
        //echo $this->redirect(array('backend/product/detail_product&product_id=' . $_POST['product_id']));
    }

    public function actionGetsubproduct() {
        $upper = Yii::app()->request->getPost('type_id');
        $data['type'] = ProductType::model()->findAll("upper = '$upper' ");
        $this->renderPartial('subproducttype', $data);
    }

    public function actionGetproductinsubtype() {
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $branch = Yii::app()->request->getPost('branch');

        $clinicstockModel = new ClinicStockproduct();

        $data['product'] = $clinicstockModel->comboproduct($subproducttype, $branch);
        $this->renderPartial('comboproduct', $data);
    }

    public function actionSearchproduct() {
        $branch = Yii::app()->session['branch'];
        $data['branchModel'] = Branch::model()->find('id=:id', array(':id' => $branch));
        $data['branch'] = $branch;
        if ($branch == "99") {
            $BranchList = Branch::model()->findAll("id != '99'");
        } else {
            $BranchList = Branch::model()->findAll("id = '$branch'");
        }
        $data['BranchList'] = $BranchList;
        $this->render('searchproduct', $data);
    }

    public function actionDatasearchproduct() {
        $type = Yii::app()->request->getPost('type_id');
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $branch = Yii::app()->request->getPost('branch');
        $product_id = Yii::app()->request->getPost('product_id');
        $Model = new ClinicStoreproduct();
        $data['product'] = $Model->SearchProduct($type, $subproducttype, $branch, $product_id);
        $data['branch'] = $branch;
        //echo $data['product'];
        $this->renderPartial('datasearchproduct', $data);
    }

    public function actionDeleteproductlot() {
        $id = Yii::app()->request->getPost('id');
        Yii::app()->db->createCommand()
                ->delete("clinic_storeproduct", "id = '$id'");
    }

    public function actionMoveproduct() {
        $id = Yii::app()->request->getPost('id');
        $product_id = Yii::app()->request->getPost('product_id');
        $lotnumber = Yii::app()->request->getPost('lotnumber');
        $total = Yii::app()->request->getPost('total');
        $number = Yii::app()->request->getPost('number');
        $branch_start = Yii::app()->request->getPost('branch_start');
        $branch_end = Yii::app()->request->getPost('branch_end');

        $detailstock = ClinicStoreproduct::model()->find("id=:id", array(":id" => $id));
        //เช็คว่าล๊อตของสินค้านี้มีอยู่ในสต๊อกยัง
        $sql = "select * from clinic_storeproduct c where c.branch = '$branch_end' and c.product_id = '$product_id' and c.lotnumber = '$lotnumber' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs['product_id'] != "") {
            //ตัดสต๊อกต้นทางก่ร
            //----->Source code
            $cutnumber = ($detailstock['number'] - $number);
            $cuttotal = ($detailstock['total'] - $number);
            $columnscutstock = array(
                "total" => $cuttotal,
                "number" => $cutnumber
            );
            Yii::app()->db->createCommand()
                    ->update("clinic_storeproduct", $columnscutstock, "id='$id'");


            //ถ้ามีสินค้าชนิดนี้ล๊อตนี้อยู่ให้เพิ่มเข้าไปบวกอันเดิมได้
            $oldid = $rs['id'];
            $oldnumber = $rs['number'];
            $oldtotal = $rs['total'];
            $newsnumber = ($oldnumber + $number);
            $newstotal = ($oldtotal + $number);
            $columns = array(
                "total" => $newstotal,
                "number" => $newsnumber
            );
            Yii::app()->db->createCommand()
                    ->update("clinic_storeproduct", $columns, "id='$oldid'");

            //เพิ่ม log
            $columnslog = array(
                "product_id" => $rs['product_id'],
                "number" => $number,
                "user_id" => Yii::app()->user->id,
                "branch_start" => $branch_start,
                'lotnumber' => $lotnumber,
                "branch_end" => $branch_end,
                "create_date" => date("Y-m-d H:i:s")
            );
            Yii::app()->db->createCommand()
                    ->insert("log_moveproduct", $columnslog);
        } else {
            //ตัดสต๊อกต้นทางก่ร
            //----->Source code
            $newsnumber = ($detailstock['number'] - $number);
            $newstotal = ($detailstock['total'] - $number);
            $columns = array(
                "total" => $newstotal,
                "number" => $newsnumber
            );
            Yii::app()->db->createCommand()
                    ->update("clinic_storeproduct", $columns, "id='$id'");
            //
            //insert storeproduct
            $columnsdata = array(
                'product_id' => $product_id,
                'lotnumber' => $lotnumber,
                'number' => $number,
                'total' => $number,
                'generate' => $detailstock['generate'],
                'expire' => $detailstock['expire'],
                'branch' => $branch_end,
                'd_update' => date('Y-m-d H:i:s')
            );

            Yii::app()->db->createCommand()
                    ->insert('clinic_storeproduct', $columnsdata);

            //เพิ่ม log
            $columnslog = array(
                "product_id" => $product_id,
                "number" => $number,
                'lotnumber' => $lotnumber,
                "user_id" => Yii::app()->user->id,
                "branch_start" => $branch_start,
                "branch_end" => $branch_end,
                "create_date" => date("Y-m-d H:i:s")
            );
            Yii::app()->db->createCommand()
                    ->insert("log_moveproduct", $columnslog);
        }
    }

}
