<?php

class Configweb_model {

    function get_webname() {
        $sql = "SELECT * FROM webname";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs) {
            $webname = $rs['webname'];
        } else {
            $webname = "KimniyomClinic";
        }
        return $webname;
    }

    function get_logoweb() {
        $branch = Yii::app()->session['branch'];
        $sql = "SELECT * FROM logo WHERE branch = '$branch' ";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if ($rs) {
            $logo = $rs['logo'];
        } else {
            $logo = "System-icon.png";
        }
        return $logo;
    }

    function _get_banner() {
        $sql = "SELECT *
                FROM banner
                ORDER BY banner_id ASC";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    function _get_banner_show() {
        $sql = "SELECT *
                FROM banner
                WHERE status = '1'
                ORDER BY banner_id ASC";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    function pername() {
        $sql = "SELECT oid,pername FROM pername";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        return $rs;
    }

    ///	///	///	/ end ///	///
    function autoId($table, $value, $number) {
        $rs = Yii::app()->db->createCommand("Select Max($value)+1 as MaxID from  $table")->queryRow();
        //เ		ลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
        $new_id = $rs['MaxID'];
        if ($new_id == '') {
            // 			ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
            $std_id = sprintf("%0" . $number . "d", 1);
            //ถ			้าไม่ใช่ค่าว่าง
        } else {
            $std_id = sprintf("%0" . $number . "d", $new_id);
            //ถ			้าไม่ใช่ค่าว่าง
        }

        return $std_id;
    }

    function thaidate($dateformat = "") {
        if (!empty($dateformat)) {
            $year = substr($dateformat, 0, 4);
            $month = substr($dateformat, 5, 2);
            $day = substr($dateformat, 8, 2);
            $thai = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

            if (strlen($dateformat) <= 10) {
                return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543);
            } else {
                return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543) . " " . substr($dateformat, 10);
            }
        }
    }

    function thaidatefull($dateformat = "") {
        if (!empty($dateformat)) {
            $year = substr($dateformat, 0, 4);
            $month = substr($dateformat, 5, 2);
            $day = substr($dateformat, 8, 2);
            $thai = Array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

            if (strlen($dateformat) <= 10) {
                return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543);
            } else {
                return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543) . " " . substr($dateformat, 10);
            }
        }
    }

    function Monthval() {
        $month = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        return $month;
    }

    function MonthFull() {
        $thai_month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        return $thai_month;
    }

    function MonthShot() {
        $thai = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        return $thai;
    }

    function MonthFullArray() {
        $thai_month = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        return $thai_month;
    }

    function MonthFullArrays() {
        $thai_month = array(
            "01" => "มกราคม",
            "02" => "กุมภาพันธ์",
            "03" => "มีนาคม",
            "04" => "เมษายน",
            "05" => "พฤษภาคม",
            "06" => "มิถุนายน",
            "07" => "กรกฏาคม",
            "08" => "สิงหาคม",
            "09" => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        );
        return $thai_month;
    }

    function get_age($birthday = '') {
        $then = strtotime($birthday);
        return (floor((time() - $then) / 31556926));
    }

    function url_encode($url = null) {
        return base64_encode(base64_encode(base64_encode($url)));
    }

    function url_decode($url = null) {
        return base64_decode(base64_decode(base64_decode($url)));
    }

    function Datediff($strDate1 = null, $strDate2 = null) {
        return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24);
        // 		1 day = 60*60*24
    }

    function GetBgWeb($color = null) {
        if (empty($color)) {
            $colors = "#eeeeee";
        } else {
            $colors = $color;
        }
        $str = "style='background:$colors' ";
        return $str;
    }

    function Randstrgen($Number = null) {
        if (empty($Number)) {
            $Numbers = 10;
        } else {
            $Numbers = $Number;
        }
        $len = $Numbers;
        $result = "";
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $charArray = str_split($chars);
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }
        return $result;
    }

    function RandstrgenNumber($Number = null) {
        if (empty($Number)) {
            $Numbers = 10;
        } else {
            $Numbers = $Number;
        }
        $len = $Numbers;
        $result = "";
        $chars = "0123456789";
        $charArray = str_split($chars);
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }
        return $result;
    }

    function Barcode($itemid) {
        $optionsArray = array(
            'elementId' => 'showBarcode',
            /* id of div or canvas */
            'value' => $itemid,
            /* value for EAN 13 be careful to set right values for each barcode type */
            'type' => 'code93',
            /* supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix */
            'settings' => array(
                'output' => 'css'
                /* css, bmp, canvas note- bmp and canvas incompatible wtih IE */
                ,
                /* if the output setting canvas */
                'posX' => 10,
                'posY' => 20,
                /* */
                'bgColor' => '#FFFFFF',
                /* background color */
                'color' => '#000000',
                /* "1" Bars color */
                'barWidth' => 1,
                'barHeight' => 30,
                /* -----------below settings only for datamatrix-------------------- */
                'moduleSize' => 5,
                'addQuietZone' => 0,
            /* Quiet Zone Modules */
            ),
        );
        return $optionsArray;
    }

    function Convert($amount_number) {
        $amount_number = number_format($amount_number, 2, ".", "");
        $pt = strpos($amount_number, ".");
        $number = $fraction = "";
        if ($pt === false) {
            $number = $amount_number;
        } else {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        $ret = "";
        $baht = $this->ReadNumber($number);
        if ($baht != "") {
            $ret .= $baht . "บาท";
        }

        $satang = $this->ReadNumber($fraction);
        if ($satang != "") {
            $ret .= $satang . "สตางค์";
        } else {
            $ret .= "ถ้วน";
        }

        if ($ret == "ถ้วน") {
            $ret = "ศูนย์บาทถ้วน";
        }

        return $ret;
    }

    function ReadNumber($number) {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0) {
            return $ret;
        }

        if ($number > 1000000) {
            $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }

        $divider = 100000;
        $pos = 0;
        while ($number > 0) {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
                    ((($divider == 10) && ($d == 1)) ? "" :
                    ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }

    function LinkNode() {
        //return "http://172.17.3.74:3000";
        return "http://172.17.3.19:5000";
        //return "http://www.tako.moph.go.th:8080";
    }

    function userExportPatient($userId) {
        $sqlExport = "select COUNT(*) AS total  from role_export where user_id = '$userId'";
        $rs = Yii::app()->db->createCommand($sqlExport)->queryRow();
        return $rs['total'];
    }

    function seqemployeedoctor() {
        return "seqemployeedoctorramet";
    }

    function seqemployee() {
        return "seqemployeeramet";
    }

    function seqseqsuccess() {
        return "seqseqsuccessramet";
    }

}
