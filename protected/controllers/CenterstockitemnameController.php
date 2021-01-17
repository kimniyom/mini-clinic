<?php

class CenterstockitemnameController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'template_backend';

    /**
     * @return array action filters
     */


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
        $model = new CenterStockitemName;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CenterStockitemName'])) {
            $model->attributes = $_POST['CenterStockitemName'];
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

        if (isset($_POST['CenterStockitemName'])) {
            $model->attributes = $_POST['CenterStockitemName'];
            if ($model->save())
                $this->redirect(array('index'));
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
        $data['item'] = CenterStockitemName::model()->findAll('');
        //$dataProvider=new CActiveDataProvider('CenterStockitemName');
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CenterStockitemName('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CenterStockitemName']))
            $model->attributes = $_GET['CenterStockitemName'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CenterStockitemName the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CenterStockitemName::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CenterStockitemName $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'center-stockitem-name-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetunit() {
        $itemid = Yii::app()->request->getPost('itemid');
        $sql = "SELECT u.unit,us.unit AS unitcut
                FROM center_stockitem_name s
                INNER JOIN center_stockunit u ON s.unit = u.id
                INNER JOIN center_stockunit us ON s.unitcut = us.id
                WHERE s.id = '$itemid'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $json = array("unit" => $result['unit'],"unitcut" => $result['unitcut']);
        echo json_encode($json);
    }

    public function actionGetunitcut(){
        $itemid = Yii::app()->request->getPost('itemid');
        $Model = new CenterStockunit();
        $unit = $Model->GetunitCutById($itemid);
        echo $unit;
    }



}
