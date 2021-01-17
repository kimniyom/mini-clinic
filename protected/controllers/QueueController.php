<?php

class QueueController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $enableCsrfValidation = false;
    public $layout = 'template_backend';

    public function actionIndex() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        $Model = new Service();
        $branch = Yii::app()->session['branch'];
        $data['seq'] = $Model->Getseq($branch);

        if (Yii::app()->session['status'] == '2') {
            //$this->layout = "dortor";
            $this->render('index', $data);
        } else {
            $this->actionSeqemployee();
        }
    }

    public function actionSeqdoctor() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        $Model = new Service();
        $branch = 1;
        $data['seq'] = $Model->Getseq($branch);
        /*
          if (Yii::app()->session['status'] == '2') {
          $this->renderPartial('seqdoctor', $data);
          } else {
          $this->renderPartial('seqdoctoremployee', $data);
          }
         *
         */
        $this->renderPartial('seqdoctoremployee', $data);
    }

    public function actionSeqdoctorSea() {
        $Model = new Service();
        $branch = Yii::app()->session['branch'];
        $data['seq'] = $Model->Getseq($branch);
        /*
          if (Yii::app()->session['status'] == '2') {
          $this->renderPartial('seqdoctor', $data);
          } else {
          $this->renderPartial('seqdoctoremployee', $data);
          }
         *
         */
        $this->renderPartial('seqdoctoremployeeseq', $data);
    }

    public function actionSeqemployee() {
        $Model = new Service();
        $Patient = new Patient();
        $branch = Yii::app()->session['branch'];
        $data['PatientList'] = $Patient->GetPatient();
        $data['seq'] = $Model->GetseqEmployee($branch);

        $this->render('seqemployee', $data);
    }

    public function actionSaveseq() {
        $patient = Yii::app()->request->getPost('patient');
        $promotion = Yii::app()->request->getPost('promotion');
        $date_service = Yii::app()->request->getPost('date_service');
        $branch = Yii::app()->session['branch'];
        //ดึงข้อมูลวันนัดล่าสุดมาอัพเดท5้ามีการนัด

        $sql = "SELECT * FROM appoint WHERE patient_id = '$patient' AND status = '0' LIMIT 1";
        $appoint = Yii::app()->db->createCommand($sql)->queryRow();
        if ($appoint['appoint']) {
            $id = $appoint['id'];
            $status = array("status" => '1');
            Yii::app()->db->createCommand()
                    ->update("appoint", $status, "id = '$id'");
        }

        $columns = array(
            "patient_id" => $patient,
            "promotion" => $promotion,
            "branch" => $branch,
            "user_id" => $user_id = Yii::app()->user->id,
            "service_date" => $date_service,
        );

        Yii::app()->db->createCommand()
                ->insert("service", $columns);

        //รหัสบริการมากสุด
        $sqlMaxservice = "SELECT MAX(id) AS id FROM service ";
        $rsService = Yii::app()->db->createCommand($sqlMaxservice)->queryRow();
        $ServiceId = $rsService['id'];

        //ตรวจร่างกาย
        $btemp = Yii::app()->request->getPost('btemp');
        $pr = Yii::app()->request->getPost('pr');
        $rr = Yii::app()->request->getPost('rr');
        $weight = Yii::app()->request->getPost('weight');
        $height = Yii::app()->request->getPost('height');
        $ht = Yii::app()->request->getPost('ht');
        $waistline = Yii::app()->request->getPost('waistline');
        $cc = Yii::app()->request->getPost('cc');
        $user_id = Masuser::model()->find("id=:id", array(":id" => Yii::app()->user->id))['user_id'];
        $columnsbody = array(
            "patient_id" => $patient,
            "btemp" => $btemp,
            "pr" => $pr,
            "rr" => $rr,
            "weight" => $weight,
            "height" => $height,
            "ht" => $ht,
            "waistline" => $waistline,
            "cc" => $cc,
            "date_serv" => $date_service,
            "user_id" => $user_id,
            "service_id" => $ServiceId,
        );

        Yii::app()->db->createCommand()
                ->insert("checkbody", $columnsbody);

        //$this->LinrNotify($patient);//Update 20200113
    }

    function LinrNotify($patient) {
        $sql = "select * from patient where id = '$patient' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        //$message = "test";
        //$token = "tTB2872QNBu50i3FXUWsN1IKEZgqVHU9QdV0zLNTbst";
        $token = "KlUQGDiGhLxFzpNrMmKMzajA2kjcPH07q9gKgpXo1ja";
        //echo send_line_notify($message, $token);
        //function send_line_notify($message, $token) {

        $message = "";
        if ($rs) {
            //return; //ถ้าข้อความแจ้งเตือนเป็นค่าว่าง ไม่มีการแจ้งเตือนในไลน์

            $message .= "มีคิวคนไข้ " . $rs['name'] . " " . $rs['lname'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$message");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token",);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
        //}
    }

    public function actionGetlastservice() {
        $WebConfig = new Configweb_model();
        $patient = Yii::app()->request->getPost('patient');
        //ดึงข้อมูลวันนัดล่าสุดมาอัพเดท
        $sql = "SELECT * FROM appoint WHERE patient_id = '$patient' AND status = '0' ORDER BY id DESC LIMIT 1";
        $appoint = Yii::app()->db->createCommand($sql)->queryRow();
        $type = $this->Gettype($appoint['type']);
        $json = array(
            "appoint_id" => $appoint['id'],
            "comment" => $type,
            "appoint" => $WebConfig->thaidate($appoint['appoint']),
        );

        echo json_encode($json);
    }

    public function actionSaveseqformappoint() {
        $patient = Yii::app()->request->getPost('patient');
        $comment = Yii::app()->request->getPost('comment');
        $appoint_id = Yii::app()->request->getPost('appoint_id');
        $branch = Yii::app()->session['branch'];
        //ดึงข้อมูลวันนัดล่าสุดมาอัพเดท
        //$sql = "SELECT * FROM appoint WHERE patient_id = '$patient' AND status = '0' LIMIT 1";
        //$appoint = Yii::app()->db->createCommand($sql)->queryRow();
        $id = $appoint_id;
        $status = array("status" => '1');
        Yii::app()->db->createCommand()
                ->update("appoint", $status, "id = '$id'");

        $columns = array(
            "patient_id" => $patient,
            "comment" => $comment,
            "branch" => $branch,
            "service_date" => date("Y-m-d"),
        );

        Yii::app()->db->createCommand()
                ->insert("service", $columns);
    }

    public function Gettype($type) {
        //$Type = array("1" => "นัดหัตถการ","2" => "นัดพบแพทย์","3" => "ทรีทเม็นท์");
        if ($type == '1') {
            $types = "นัดหัตถการ";
        } else if ($type == '2') {
            $types = "นัดพบแพทย์";
        } else if ($type == '3') {
            $types = "ทรีทเม็นท์";
        }

        return $types;
    }

    public function actionGetdata() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        $branch = 1;
        $Model = new Service();
        $data['seq'] = $Model->GetseqEmployee($branch);
        $this->renderPartial('table', $data);
    }

    public function actionGetservicesuccess() {
        $branch = 1;
        $Model = new Service();
        $data['seq'] = $Model->GetseqSuccess($branch);
        $this->renderPartial('servicesuccess', $data);
    }

    public function actionDeleteservice() {
        $id = Yii::app()->request->getPost('id');
        Yii::app()->db->createCommand()
                ->delete("service", "id = '$id'");
    }

    public function actionGetpatient() {
        $id = Yii::app()->request->getPost('id');
        /*
          $sql = "SELECT p.*,g.grad,g.distcount,g.distcountsell
          FROM patient p INNER JOIN gradcustomer g ON p.type = g.id
          WHERE p.id = '$id' ";
          $rs = Yii::app()->db->createCommand($sql)->queryRow();
         *
         */
        $WebConfig = new Configweb_model();
        $Model = new Patient();
        $rs = $Model->GetpatientId($id);


        $sqlDrug = "SELECT IFNULL(GROUP_CONCAT(drug),'-') AS drug FROM patient_drug WHERE patient_id = '$id'";
        $rsDrug = Yii::app()->db->createCommand($sqlDrug)->queryRow();

        $sqlDisease = "SELECT IFNULL(GROUP_CONCAT(disease),'-') AS disease FROM patient_disease WHERE patient_id = '$id'";
        $rsDisease = Yii::app()->db->createCommand($sqlDisease)->queryRow();


        $str = "<div class='patient-detail'>";
        if (!empty($rs['images'])) {
            $str .= "<img src='" . Yii::app()->baseUrl . "/uploads/profile/" . $rs['images'] . "' class='img img-responsive' style='height:80px;'/>";
        } else {
            $str .= "<img src='" . Yii::app()->baseUrl . "/images/use-icon.png' class='img img-responsive' style='height:48px;'/>";
        }
        $str .= "<hr/><label>CN : </label> " . $rs['cn'];
        //$str .= "<br/><label>บัตรประชาชน : </label> " . $rs['card'];
        $str .= "<br/><label>คุณ : </label> " . $rs['name'] . " " . $rs['lname'] . "&nbsp;(อายุ: " . $WebConfig->get_age($rs['birth']) . " ปี)";
        $str .= "<br/> <label>ที่อยู่ : </label> " . $rs['contact'];
        $str .= "<br/><label>เบอร์โทรศัพท์ : </label> " . $rs['tel'];
        $str .= "<hr/><label>โรคประจำตัว : </label> ".$rsDisease['disease'];
        $str .= "<br/><label>แพ้ยา : </label> ".$rsDrug['drug'];
        //$str .= "<br/><label>ประเภทลูกค้า : </label> " . $rs['grad'];
        //$str .= "<hr/><button class='btn btn-default btn-sm' onclick='linkdetail(" . $id . ")'>ข้อมูลลูกค้า</button>";
        //$str .= "<br/>คอร์สที่ลงทะเบียน";
        //$str .= $this->Getpromotion($rs['pid']);

        $str .= "</div>";
        if ($rs) {
            echo $str;
        }
    }

    public function Getpromotion($pid) {
        $Patient = new Patient();
        $result = $Patient->GetlistpromotionRegister($pid);
        $count = count($result);
        $str = "";
        if ($count > 0) {
            $unAll = '<input type="radio" name="pro" id="pro" checked="checked" onclick="setcc()" style="position:absolute;top:10px; right:10px;"/>';
            $str .= "<ul class='list-group' style='margin-bottom:0px;color:orange;'>";
            $str .= '<li class="list-group-item">ไม่เลือก' . $unAll . '</li>';
            foreach ($result as $rs):
                $settext = "'" . $rs['promotion'] . "','" . $rs['diagname'] . " " . $rs['number'] . " ครั้ง" . "'";
                $str .= '<li class="list-group-item">';
                $str .= $rs['diagname'] . " " . $rs['number'] . " ครั้ง " . number_format($rs['pricepromotion']) . " บาท";
                $str .= '<input type="radio" name="pro" id="pro" onclick="setcc(' . $settext . ')" style="position:absolute;top:10px; right:10px;"/>';
                $str .= "</li>";
            endforeach;
            $str .= "</ul>";
        } else {
            $str .= "<br/>ไม่มี";
        }

        return $str;
    }

}
