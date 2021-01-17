<?php

class LogController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'template_backend';

    
    public function actionLoglogin() {
        $sql = "SELECT l.*,m.username,e.alias,e.`name`,e.lname,s.`status`,b.branchname
                FROM loglogin l INNER JOIN masuser m ON l.user_id = m.user_id
                INNER JOIN employee e ON m.user_id = e.id
                INNER JOIN status_user s ON m.`status` = s.id
                INNER JOIN branch b ON l.branch = b.id ORDER BY l.date DESC";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $data['datas'] = $result;
        $this->render('loglogin',$data);
    }

   

}
