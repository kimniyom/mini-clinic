<?php

class ReturnproductController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='template_backend';


    public function actionCreate() {
        $model = new Returnproduct;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Returnproduct'])) {
            $model->attributes = $_POST['Returnproduct'];
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

        if (isset($_POST['Returnproduct'])) {
            $model->attributes = $_POST['Returnproduct'];
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
    public function actionIndex($branch) {
        $branchModel = new Branch();
        $data['branchname'] = $branchModel->Getbranch($branch);
        $data['branch'] = $branch;
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Returnproduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Returnproduct']))
            $model->attributes = $_GET['Returnproduct'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Returnproduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Returnproduct::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Returnproduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'returnproduct-form') {
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
        $data['branch'] = $branch;
        $this->renderPartial('datastockproduct', $data);
    }

    public function actionCutstock(){
        $id = Yii::app()->request->getPost('id');
        $product_id = Yii::app()->request->getPost('product_id');
        $lotnumber = Yii::app()->request->getPost('lotnumber');
        $etc = Yii::app()->request->getPost('etc');
        $number = Yii::app()->request->getPost('numbers');
        $total = Yii::app()->request->getPost('totals');
        $branch = Yii::app()->request->getPost('branch');
        //$etc = Yii::app()->request->getPost('etc');
        $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $sumtotal = ($total - $number);
        $columns = array("total" => $sumtotal);
        Yii::app()->db->createCommand()
            ->update("clinic_storeproduct",$columns,"id = '$id'");
        
        $product = CenterStockproduct::model()->find('product_id=:product_id',array(':product_id' => $product_id));
        $price_total = ($product['costs'] * $number);
        $column = array(
            "product_id" => $product_id,
            "lotnumber" => $lotnumber,
            "number" => $number,
            "product_price" => $product['costs'],
            "price_total" => $price_total,
            "user_return" => $user_id,
            "branch" => $branch,
            "etc" => $etc,
            "create_date" => date("Y-m-d H:i:s")
            );
        Yii::app()->db->createCommand()
            ->insert("returnproduct",$column);
    }

    public function actionView(){
        $data['product'] = Returnproduct::model()->findAll('status=:status',array(':status' => '0'));
        $this->render('view',$data);
    }

    public function actionConfirm(){
        $id = Yii::app()->request->getPost('id');
        Yii::app()->db->createCommand()
            ->update("returnproduct",array("status" => "1"),"id='$id'");
    }

    public function actionReport(){
        $branch = Yii::app()->session['branch'];
        $data['branchModel'] = Branch::model()->find('id=:id', array(':id' => $branch));
        $data['branch'] = $branch;
        if ($branch == "99") {
            $BranchList = Branch::model()->findAll();
        } else {
            $BranchList = Branch::model()->findAll("id = '$branch'");
        }
        $data['BranchList'] = $BranchList;
        $this->render('report', $data);
    }

    public function actionGetdata(){
        $branch = Yii::app()->request->getPost('branch');
        if($branch != '99'){
            $where = "branch = '$branch' AND status = '1'";
        } else {
            $where = "1=1 AND status = '1'";
        }
        $sql = "select * from returnproduct where $where";
        $data['datareturn'] = Yii::app()->db->createCommand($sql)->queryAll();
        $this->renderPartial('datareturnproduct', $data);
    }

}
