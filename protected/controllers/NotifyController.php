<?php

//TokenAddmin XcZFZUQqDz8rN8scyWCjNVD1HlqlRJzGTUx1xBudM8w
class NotifyController extends Controller {

    public $TakAdmin = "XcZFZUQqDz8rN8scyWCjNVD1HlqlRJzGTUx1xBudM8w";
    public $TokenTak = "7nRzXHrTeGD6eIeg2kuiw7dJvDrqy1eYJsjQURhZF6C";
    public $TokenMaesot = "xoScxQ3GdkQnrVB5xP9KhdyvzPmmI9cj6OLtUUWpSVX";

    public function actionProcess() {

        //แจ้งเตือนวันนีด
        $this->Appoint($this->TokenTak, 1); //สาขาตาก
        $this->Appoint($this->TokenMaesot, 2); //สาขาแม่สอด
        //แจ้งเตือนสินค้าใกล้หมด
        $this->Stock($this->TokenTak, 1);
        $this->Stock($this->TokenMaesot, 2);
    }

    public function Notify($token, $msg, $typelog) {
        $sToken = $token;
        $sMessage = $msg;

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '');
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
            $columns = array(
                "status" => $result_['status'],
                "message" => $result_['message'],
                "typelog" => $typelog,
                "date" => date("Y-m-d H:i:s"),
            );

            Yii::app()->db->createCommand()
                    ->insert("lognotify", $columns);

            $this->NotifyProcess($typelog);
        }
        curl_close($chOne);
    }

    //แจ้งเตือนวันนัด
    public function Appoint($token, $branch) {
        $Config = new Configweb_model();
        $Alert = new Alert();
        $alam = $Alert->Getalert()['alert_appoint'];
        $sql = "SELECT a.`appoint`,p.`name`,p.`lname`,p.tel,a.type
                    FROM appoint a inner join patient p on a.patient_id = p.id
                    WHERE DATEDIFF(a.appoint,NOW()) <= $alam AND a.status = '0' AND a.branch = '$branch'  LIMIT 10";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $sToken = $token;
        $msg = "";
        $msg = "ลูกค้าใกล้ถึงวันนัด" . "\n";
        $i = 0;
        foreach ($result as $rs):
            $i++;
            $msg .= $Config->thaidate($rs['appoint']) . "\n" . "คุณ:" . $rs['name'] . ' ' . $rs['lname'] . "\n" . "โทร:" . $rs['tel'] . "\n";
        endforeach;
        $msg .= "\n" . "คลิกลิงค์เพื่อดูทั้งหมด" . "\n";
        $msg .= "http://122.154.239.66/clinic";
        $total = $i;
        if ($total > 0) {
            $this->Notify($sToken, $msg, "ลูกค้าใกล้ถึงวันนัด");
        }
    }

    //NotifyStock
    public function Stock($token, $branch) {
        $sql = "SELECT *
                    FROM(
                    SELECT s.product_id,
                            c.product_nameclinic,
                            c.product_price,
                            c.costs,
                            u.unit,
                            c.type_id,
                            c.subproducttype,
                            t.type_name AS category,
                            pt.type_name,
                            SUM(st.total) AS total
                    FROM clinic_stockproduct s
                    INNER JOIN center_stockproduct c ON s.product_id = c.product_id
                    LEFT JOIN unit u ON c.unit = u.id
                    INNER JOIN product_type t ON c.type_id = t.id
                    INNER JOIN product_type pt ON c.subproducttype = pt.id
                    INNER JOIN clinic_storeproduct st ON s.product_id = st.product_id
                    WHERE s.branch = '$branch' AND st.flag = '0'
                    GROUP BY s.product_id
                    ) Q
                    WHERE Q.total < (SELECT alert_product FROM alert LIMIT 1) LIMIT 10";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $sToken = $token;
        $msg = "";
        $msg = "สินค้าใกล้หมด" . "\n";
        $i = 0;
        foreach ($result as $rs):
            $i++;
            $msg .= "รหัส:" . $rs['product_id'] . "\n";
            $msg .= "สินค้า:" . $rs['product_nameclinic'] . "\n";
            $msg .= "คงเหลือ: " . $rs['total'] . " " . $rs['unit'] . "\n";
        endforeach;
        $msg .= "\n" . "คลิกลิงค์เพื่อดูทั้งหมด" . "\n";
        $msg .= "http://122.154.239.66/clinic";
        if ($i > 0) {
            $this->Notify($sToken, $msg, "สินค้าใกล้หมด");
        }
    }

    function NotifyProcess($typelog) {
        $sToken = $this->TakAdmin;
        $msg = date("Y-m-d H:i:s") . "\n";
        $msg .= "Log => " . "\n";
        $msg .= "ส่งแจ้งเตือน:" . $typelog;
        $sMessage = $msg;
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '');
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
        }
        curl_close($chOne);
    }

}

?>