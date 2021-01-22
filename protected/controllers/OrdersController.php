<?php

class OrdersController extends Controller {

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
                'actions' => array('create', 'update', 'loaddata', 'save', 'search',
                    'deleteorder', 'confirmorder', 'cutitems', 'print', 'bill', 'updatestatus',
                    'checklistorder', 'adddistcount', 'editnumber', 'detailproduct'),
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
    public function actionViewbackup($order_id = null) {
        Yii::app()->db->createCommand()->delete("temp_item");
        $ModelMix = new CenterStockmix();
        $order = Orders::model()->find("order_id = '$order_id'");
        $branchId = $order['branch'];
        $data['BranchModel'] = Branch::model()->find("id = '$branchId'");
        $OrderModel = new Orders();
        $data['order'] = $order;
        $data['orderlist'] = $OrderModel->Getlistorder($order_id, $branchId);

        if (Yii::app()->session['status'] == '1' || Yii::app()->session['status'] == '8') {
            $ModelMix = new CenterStockmix();
            $OrderModel = new Orders();
            $productInorder = $OrderModel->GetlistorderSum($order_id);
            $data['product'] = $productInorder;
            /*
              foreach ($productInorder as $product) {
              $product_id = $product['product_id'];
              $number = $product['number'];

              $mixer = $ModelMix->GetiteminproductTotal($product_id, $number);
              foreach ($mixer as $rx):
              $columns = array(
              "itemid" => $rx['itemid'],
              "order_id" => $order_id,
              "itemcode" => $rx['itemcodes'],
              "number" => $rx['itemtotal'],
              "itemname" => $rx['itemname'],
              "unit" => $rx['unit']
              );
              Yii::app()->db->createCommand()->insert("temp_item", $columns);
              endforeach;
              }
              $sql = "SELECT t.*,SUM(t.number) AS number FROM temp_item t GROUP BY t.itemcode";
              $data['items'] = Yii::app()->db->createCommand($sql)->queryAll();
             *
             */
            $this->render('viewcenter', $data);
        } else {
            $this->render('view', $data);
        }
    }

    public function actionView($order_id = null) {
        Yii::app()->db->createCommand()->delete("temp_item");
        //$ModelMix = new CenterStockmix();
        $order = Orders::model()->find("order_id = '$order_id'");
        $branchId = $order['branch'];
        $data['BranchModel'] = Branch::model()->find("id = '$branchId'");
        $OrderModel = new Orders();
        $data['order'] = $order;
        $data['orderlist'] = $OrderModel->Getlistorder($order_id, $branchId);
        $data['supplier'] = CenterStockcompany::model()->find("id=:id",array(':id' => $order['supplier']));
        $data['vat'] = $order['vattype'];
        if (Yii::app()->session['status'] == '1' || Yii::app()->session['status'] == '2' || Yii::app()->session['status'] == '6' || Yii::app()->session['status'] == '8') {
            //$ModelMix = new CenterStockmix();
            $OrderModel = new Orders();
            $productInorder = $OrderModel->GetlistorderSum($order_id);
            $data['product'] = $productInorder;
            $this->render('viewcenter', $data);
        } else {
            $this->render('view', $data);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($branch) {

        $model = new Orders;
        $orderId = "PO-".$model->autoId("orders", "order_id", "7");
        $branchModel = Branch::model()->find($branch);
        Yii::app()->db->createCommand()->delete("listorder", "order_id = '$orderId' ");

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
            'order_id' => $orderId,
            'branch' => $branch,
            'branchModel' => $branchModel
        ));
    }

    public function actionChecklistorder() {
        $order_id = Yii::app()->request->getPost('order_id');
        $supplier = Yii::app()->request->getPost('supplier');
        $sql = "SELECT COUNT(*) AS total FROM listorder WHERE order_id = '$order_id'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs['total'] > 0) {
            $column = array("supplier" => $supplier);
            Yii::app()->db->createCommand()
                    ->update("orders", $column, "order_id = '$order_id'");
        }
        echo $rs['total'];
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($order_id = null) {
        $order = Orders::model()->find("order_id = '$order_id' ");
        $this->render('update', array(
            'order_id' => $order_id,
            'order' => $order
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
        $branch = Yii::app()->session['branch'];
        $Model = new Orders();
        $data['branchModel'] = Branch::model()->find('id=:id', array(':id' => $branch));
        $data['branch'] = $branch;
        $data['orders'] = $Model->GetorderInBranch($branch);
        if ($branch == "99") {
            $BranchList = Branch::model()->findAll();
        } else {
            $BranchList = Branch::model()->findAll("id = '$branch'");
        }
        $data['BranchList'] = $BranchList;
        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Orders $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLoaddata() {
        $orderId = Yii::app()->request->getPost('order_id');
        $branch = Yii::app()->request->getPost('branch');
        $vat = Yii::app()->request->getPost('vat');
        $order = Orders::model()->find("order_id = '$orderId'");
        $OrderModel = new Orders();
        $data['orders'] = $order;
        $data['order'] = $OrderModel->Getlistorder($orderId, $branch);
        $data['vat'] = $vat;
        //print_r($data['order']);
        $this->renderPartial('listdata', $data);
    }

    public function actionSave() {
        $branch = Yii::app()->request->getPost('branch');
        //$menager = Branch::model()->find("id = '$branch' ")['menagers'];
        $author = Yii::app()->user->id;
        $order_id = Yii::app()->request->getPost('order_id');
        $supplier = Yii::app()->request->getPost('supplier');
        $vattype = Yii::app()->request->getPost('vattype');
        $priceresult = Yii::app()->request->getPost('priceresult');
        //$price = $this->actionCaculatororder($order_id);


        //$vat = ($price * 7) / 100; //ภาษี
        //$priceresult = ($price + $vat); //ราคาสุทธิ์

        $columns = array(
            "order_id" => $order_id,
            "branch" => $branch,
            "author" => $author,
            //"price" => $price,
            //"vat" => $vat,
            "supplier" => $supplier,
            "vattype" => $vattype,
            "priceresult" => $priceresult,
            "create_date" => date("Y-m-d"),
            "d_update" => date("Y-m-d H:i:s")
        );

        Yii::app()->db->createCommand()->insert("orders", $columns);
    }

    public function actionCaculatororder($orderId) {
        $OrderModel = new Orders();
        $Model = Orders::model()->find("order_id = '$orderId'");
        $order = $OrderModel->Getlistorder($orderId, $Model['branch']);
        $sumdistcount = 0;
        $sumproduct = 0;
        foreach ($order as $rs):
            $sumrow = ($rs['costs'] * $rs['number']);
            $sumproduct = ($sumproduct + $sumrow);
        endforeach;

        //$tax = ($sumproduct * 7) / 100;//ภาษี 7%
        //$total = ($sumproduct + $tax);
        //$price = number_format($total, 2);
        return $sumproduct;
    }

    public function actionSearch() {
        $Model = new Orders();
        $datestart = Yii::app()->request->getPost('datestart');
        $dateend = Yii::app()->request->getPost('dateend');
        $status = Yii::app()->request->getPost('status');
        $branch = Yii::app()->request->getPost('branch');
        $order_id = Yii::app()->request->getPost('order_id');

        $data['order'] = $Model->SearchOrder($datestart, $dateend, $status, $branch, $order_id);
        $this->renderPartial('resultsearch', $data);
    }

    public function actionDeleteorder() {
        $order_id = Yii::app()->request->getPost('order_id');
        Yii::app()->db->createCommand()
                ->delete("orders", "order_id = '$order_id' ");
    }

    public function actionConfirmorder() {
        $order_id = Yii::app()->request->getPost('order_id');
        $columns = array("status" => '1');
        Yii::app()->db->createCommand()->update("orders", $columns, "order_id = '$order_id' ");

        $sql = "SELECT product_id,SUM(number) AS number FROM listorder WHERE order_id = '$order_id' GROUP BY product_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($result as $rs):
            $productid = $rs['product_id'];
            $number = $rs['number'];
            $this->actionCutitems($productid, $number);
        endforeach;
    }

    public function actionCutitems($productid, $number) {
        $sql = "SELECT *
                FROM clinic_storeproduct i
                WHERE i.product_id = '$productid' AND i.total > 0
                ORDER BY i.lotnumber,i.d_update ASC ";

        $item = Yii::app()->db->createCommand($sql)->queryAll();
        //ดึงข้อมูลตารางitem
        $numbercut = 0;
        foreach ($item as $rs):
            $id = $rs['id'];
            $totalinstock = $rs['total']; //คงเหลือในสต๊อกที่ตัดได้
            if ($totalinstock >= $number) { //<==กรณีสินค้าในล๊อตนั้นมีมากกว่า
                $totalstock = ($totalinstock - $number);
                $numbercut = $totalstock;
                $columns = array("total" => $numbercut);
                Yii::app()->db->createCommand()->update("clinic_storeproduct", $columns, "id = '$id' ");
                break;
            } else if ($totalinstock < $number) {//<==กรณีสินค้าในล๊อตนั้นมีน้อยกว่า
                $number = ($number - $totalinstock);
                //$numbercut = $totalstock;
                $columns = array("total" => "0");
                Yii::app()->db->createCommand()->update("clinic_storeproduct", $columns, "id = '$id' ");
            }

        endforeach;
    }

    public function actionPrint_Backup($order_id = null) {
        $order = Orders::model()->find("order_id = '$order_id'");
        $branchId = $order['branch'];
        $data['BranchModel'] = Branch::model()->find("id = '$branchId'");
        $data['logo'] = Logo::model()->find("branch='$branchId'")['logo'];
        $OrderModel = new Orders();
        $data['order'] = $order;
        $data['order_id'] = $order_id;
        $data['orderlist'] = $OrderModel->Getlistorder($order_id, $branchId);

        /* Config php7
          require_once ('lib/mpdf7/vendor/autoload.php');
          $mPDF1 = new \Mpdf\Mpdf();
         */
        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('order-' . $order_id, 'A4');

        # render (full page)
        //$mPDF1->WriteHTML($this->render('print', $data, true));
        $mPDF1->WriteHTML($this->renderPartial('print', $data, true));
        # Outputs ready PDF
        $mPDF1->Output();
    }

    public function actionPrint($order_id = null) {
        $order = Orders::model()->find("order_id = '$order_id'");
        $branchId = $order['branch'];
        $data['BranchModel'] = Branch::model()->find("id = '$branchId'");
        $data['logo'] = Logo::model()->find("branch='$branchId'")['logo'];
        $OrderModel = new Orders();
        $data['order'] = $order;
        $data['order_id'] = $order_id;
        $data['orderlist'] = $OrderModel->Getlistorder($order_id, $branchId);
        $data['supplier'] = CenterStockcompany::model()->find("id=:id",array(':id' => $order['supplier']));
        $data['vat'] = $order['vattype'];
        /* Config php7
          require_once ('lib/mpdf7/vendor/autoload.php');
          $mPDF1 = new \Mpdf\Mpdf();
         */
        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('order-' . $order_id, 'A4');

        # render (full page)
        //$mPDF1->WriteHTML($this->render('print', $data, true));
        $mPDF1->WriteHTML($this->renderPartial('print', $data, true));
        # Outputs ready PDF
        $mPDF1->Output();
    }

    public function actionBill($order_id = null) {
        $order = Orders::model()->find("order_id = '$order_id'");
        $branchId = $order['branch'];
        $data['BranchModel'] = Branch::model()->find("id = '$branchId'");
        $data['logo'] = Logo::model()->find("branch='$branchId'")['logo'];
        $OrderModel = new Orders();
        $data['order'] = $order;
        $data['order_id'] = $order_id;
        $data['orderlist'] = $OrderModel->Getlistorder($order_id, $branchId);



        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('order-' . $order_id, 'A4');

        # render (full page)
        //$mPDF1->WriteHTML($this->render('print', $data, true));
        $mPDF1->WriteHTML($this->renderPartial('bill', $data, true));
        # Outputs ready PDF
        $mPDF1->Output();
    }

    public function actionUpdatestatus() {
        $order_id = Yii::app()->request->getPost('order_id');
        $status = Yii::app()->request->getPost('status');
        $columns = array("status" => $status);
        Yii::app()->db->createCommand()
                ->update("orders", $columns, "order_id = '$order_id' ");
    }

    public function actionAdddistcount() {
        $order_id = Yii::app()->request->getPost('order_id');
        $sql = "SELECT * FROM orders WHERE order_id = '$order_id' ";
        $distcountpercent = Yii::app()->request->getPost('distcount');

        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        $distcountprice = ($rs['price'] * $distcountpercent) / 100; //ส่วนลดเป็นเงิน
        $deldistcount = ($rs['price'] - $distcountprice); //ราคาหักส่วนลด
        $vat = ($deldistcount * 7) / 100; //ราคาสุทธิ์
        $priceresult = ($deldistcount + $vat);
        $columns = array(
            "distcount" => $distcountpercent,
            "distcountprice" => $distcountprice,
            "priceresult" => $priceresult,
            "vat" => $vat,
            "pricedeldistcount" => $deldistcount
        );

        Yii::app()->db->createCommand()
                ->update("orders", $columns, "order_id = '$order_id'");
    }

    public function actionEditnumber() {
        $id = Yii::app()->request->getPost('id');
        $number = Yii::app()->request->getPost('newsnumber');
        $product_id = Yii::app()->request->getPost('product_id');
        $distcount = Yii::app()->request->getPost('distcount');
        $product = CenterStockproduct::model()->find("product_id=:product_id", array(":product_id" => $product_id));
        $costs = $product['costs'];
        $product_price = $product['product_price'];

        $pricetotal = ($costs * $number);
        $priceresult = ($pricetotal - $distcount);
        $columns = array("number" => $number, "pricetotal" => $priceresult);
        Yii::app()->db->createCommand()
                ->update("listorder", $columns, "id='$id'");
    }

    public function actionDetailproduct() {
        $product_id = Yii::app()->request->getPost('product_id');
        $sql = "SELECT u.unit
                    FROM clinic_stockproduct c INNER JOIN unit u ON c.unit = u.id
                    WHERE c.product_id = '$product_id' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        echo $rs['unit'];
    }

}
