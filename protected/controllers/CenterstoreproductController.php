<?php

class CenterstoreproductController extends Controller {

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
                'actions' => array('create', 'update', 'getdatastockproduct',
                    'getsubproduct', 'getproductinsubtype', 'getproductinsubtype',
                    'detailproduct', 'getunit', 'getimages', 'Saveproduct','cutstock','cutitems'),
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
        $this->render('create');
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

        if (isset($_POST['CenterStoreproduct'])) {
            $model->attributes = $_POST['CenterStoreproduct'];
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
    public function actionIndex() {
        $this->render("index");
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CenterStoreproduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CenterStoreproduct']))
            $model->attributes = $_GET['CenterStoreproduct'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CenterStoreproduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CenterStoreproduct::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CenterStoreproduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'center-storeproduct-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetdatastockproduct() {
        $type = Yii::app()->request->getPost('type_id');
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $Model = new CenterStoreproduct();
        $data['product'] = $Model->Searchstore($type, $subproducttype);

        $this->renderPartial('datastockproduct', $data);
    }

    public function actionGetsubproduct() {
        $upper = Yii::app()->request->getPost('type_id');
        $data['type'] = ProductType::model()->findAll("upper = '$upper' ");
        $this->renderPartial('subproducttype', $data);
    }

    public function actionGetproductinsubtype() {
        $subproducttype = Yii::app()->request->getPost('subproducttype');
        $data['product'] = CenterStockproduct::model()->findAll("subproducttype = '$subproducttype' ");
        $this->renderPartial('comboproduct', $data);
    }

    public function actionDetailproduct() {
        $product_id = Yii::app()->request->getPost('product_id');
        $Model = CenterStockproduct::model()->find("product_id = '$product_id' ");
        //count stock
        $sql = "select IFNULL(sum(total),0) as total from clinic_storeproduct where product_id = '$product_id' and total > 0";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        $stock = number_format($rs['total']);
        $unit = $this->actionGetunit($Model['unit']);
        $json = array(
            "detail" => $Model['product_detail'],
            "costs" => $Model['costs'],
            "price" => $Model['product_price'],
            "product_id" => $Model['product_id'],
            "unit" => $unit,
            "stock" => $stock
        );

        echo json_encode($json);
    }

    public function actionGetunit($unit = null) {
        return Unit::model()->find("id = '$unit' ")['unit'];
    }

    public function actionGetimages() {
        $product_id = Yii::app()->request->getPost('product_id');
        $product = new CenterStockproduct();
        $data['images'] = $product->get_images_product($product_id);
        $this->renderPartial("getimages", $data);
    }

    public function actionSaveproduct() {

        $data = array(
            'product_id' => Yii::app()->request->getPost('product_id'),
            'lotnumber' => Yii::app()->request->getPost('lotnumber'),
            'number' => Yii::app()->request->getPost('number'),
            'total' => Yii::app()->request->getPost('number'),
            'lotnumber' => Yii::app()->request->getPost('lotnumber'),
            'generate' => Yii::app()->request->getPost('generate'),
            'expire' => Yii::app()->request->getPost('expire'),
            'd_update' => date('Y-m-d H:i:s')
        );

        Yii::app()->db->createCommand()
                ->insert('center_storeproduct', $data);
        //echo $this->redirect(array('backend/product/detail_product&product_id=' . $_POST['product_id']));
    }

    //Function ตัดสต๊อก
    public function actionCutstock() {
        $product_id = Yii::app()->request->getPost('product_id');
        $number = Yii::app()->request->getPost('number');
        $sql = "SELECT *
                FROM center_stockmix m 
                WHERE m.product_id = '$product_id'";
        $item = Yii::app()->db->createCommand($sql)->queryAll();
        //ดึงข้อมูลตารางitem

        foreach ($item as $rs):
            $totalitem = ($rs['number'] * $number);
            $this->actionCutitems($rs['itemid'], $totalitem);
        endforeach;
    }

    public function actionCutitems($itemid, $number) {
        $sql = "SELECT *
                FROM center_stockitem i
                WHERE i.itemid = '$itemid' AND i.totalcut > 0
                ORDER BY i.lotnumber,i.create_date ASC ";

        $item = Yii::app()->db->createCommand($sql)->queryAll();
        //ดึงข้อมูลตารางitem
        $numbercut = 0;
        foreach ($item as $rs):
             $id = $rs['id'];
            $totalinstock = $rs['totalcut']; //คงเหลือในสต๊อกที่ตัดได้
            if ($totalinstock > $number) { //<==กรณีสินค้าในล๊อตนั้นมีมากกว่า
                $totalstock = ($totalinstock - $number);
                $numbercut = $totalstock;
                $columns = array("totalcut" => $numbercut);
                Yii::app()->db->createCommand()->update("center_stockitem",$columns,"id = '$id' ");
                break;
            } else if ($totalinstock < $number) {//<==กรณีสินค้าในล๊อตนั้นมีน้อยกว่า
                $number = ($number - $totalinstock);
                //$numbercut = $totalstock;
                $columns = array("totalcut" => "0");
                Yii::app()->db->createCommand()->update("center_stockitem",$columns,"id = '$id' ");
            }
            
        endforeach;
    }

}
