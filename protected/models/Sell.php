<?php

class Sell {

    function Getlistorder($sell_id = null) {
        $sql = "SELECT p.product_id,c.product_nameclinic AS product_name,SUM(s.number) AS total,p.product_price,s.branch
                        FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id AND s.branch = p.branch
                        INNER JOIN center_stockproduct c ON p.product_id = c.product_id
                        WHERE s.sell_id = '$sell_id' AND s.typeproduct = '1'
                        GROUP BY p.product_id";

        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    function Detailorder($sell_id = null) {
        $sql = "SELECT s.*
                FROM logsell s
                WHERE s.sell_id = '$sell_id' LIMIT 1";

        $data = Yii::app()->db->createCommand($sql)->queryRow();
        return $data;
    }

    function Getordersell($sell_id = null, $branch = null) {
        /*
          $sql = "SELECT Q.*
          FROM
          (
          (SELECT s.id,p.product_id,c.product_nameclinic AS product_name,SUM(s.number) AS total,s.price AS product_price,s.promotion
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          INNER JOIN center_stockproduct c ON p.product_id = c.product_id
          WHERE s.sell_id = '$sell_id'  AND s.promotion = '' AND p.branch = '$branch'
          GROUP BY p.product_id
          )
          UNION ALL
          (SELECT s.id,p.product_id,CONCAT('โปร ',c.product_nameclinic,' ',s.promotion,' ปกติหน่วยละ ',p.product_price,'.-') AS product_name,s.number AS total,s.price AS product_price,s.promotion
          FROM sell s INNER JOIN clinic_stockproduct p ON s.product_id = p.product_id
          INNER JOIN center_stockproduct c ON p.product_id = c.product_id
          WHERE s.sell_id = '$sell_id'  AND s.promotion != '' AND p.branch = '$branch'
          )
          ) Q ";
         */
        $sql = "SELECT s.id,s.product_id,s.productname AS product_name,s.number AS total,s.price AS product_price,s.date_sell
                   FROM sell s WHERE sell_id = '$sell_id'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

}
