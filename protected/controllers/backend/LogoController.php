<?php

class LogoController extends Controller {

    public $layout = "template_backend";

    public function actionIndex($branch = null) {
        $model = new Backend_logo();
        $data['branch'] = $branch;
        $data['logo'] = $model->get_logo($branch);
        $this->render('//backend/logo/index', $data);
    }

    public function actionSaveupload($branch = null) {
        // Define a destination
        $targetFolder = Yii::app()->baseUrl . '/uploads/logo'; // Relative to the root
        $sql = "SELECT * FROM logo WHERE branch = '$branch'";
        $row = Yii::app()->db->createCommand($sql)->queryRow();

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $FileName = time() . $_FILES['Filedata']['name'];
            $targetFile = rtrim($targetPath, '/') . '/' . $FileName;

            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                if (empty($row['logo'])) {
                    move_uploaded_file($tempFile, $targetFile);
                    //สั่งอัพเดท
                    $columns = array(
                        "logo" => $FileName,
                        "branch" => $branch,
                        "d_update" => date('Y-m-d H:i:s')
                    );

                    Yii::app()->db->createCommand()
                            ->insert("logo", $columns);
                } else {
                    $filename = './uploads/logo/' . $row['logo'];
                    if (file_exists($filename)) {
                        unlink($filename);
                    }
                    move_uploaded_file($tempFile, $targetFile);
                    //สั่งอัพเดท
                    $columns = array(
                        "logo" => $FileName,
                        "d_update" => date('Y-m-d H:i:s')
                    );

                    Yii::app()->db->createCommand()
                            ->update("logo", $columns, "branch = '$branch'");
                }
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function actionSaveuploads() {
        $branch = $_GET['branch'];
        $sql = "SELECT * FROM logo WHERE branch = '$branch'";
        $row = Yii::app()->db->createCommand($sql)->queryRow();

// A list of permitted file extensions
        $allowed = array('jpg', 'jpeg','png');

        if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {

            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
            

            $filename = $_FILES["upl"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
            $file_ext = substr($filename, strripos($filename, '.')); // get file name
            $newfilename = md5($file_basename) . $file_ext;

            if (!in_array(strtolower($extension), $allowed)) {
                echo 'error';
                exit;
            }

            if (empty($row['logo'])) {
                    //สั่งอัพเดท
                    $columns = array(
                        "logo" => $newfilename,
                        "branch" => $branch,
                        "d_update" => date('Y-m-d H:i:s')
                    );

                    Yii::app()->db->createCommand()
                            ->insert("logo", $columns);
                } else {
                    $pfilename = './uploads/logo/' . $row['logo'];
                    if (file_exists($pfilename)) {
                        unlink($pfilename);
                    }
                    //สั่งอัพเดท
                    $columns = array(
                        "logo" => $newfilename,
                        "d_update" => date('Y-m-d H:i:s')
                    );

                    Yii::app()->db->createCommand()
                            ->update("logo", $columns, "branch = '$branch'");
                }

            //$images = $_FILES["upl"]["tmp_name"];
            //copy($_FILES["upl"]["tmp_name"],$Path.$newfilename);
            /*
            $width = 300; 
            $size = GetimageSize($images);
            $height = round($width * $size[1] / $size[0]);
            $images_orig = ImageCreateFromJPEG($images);
            $photoX = ImagesX($images_orig);
            $photoY = ImagesY($images_orig);
            $images_fin = ImageCreateTrueColor($width, $height);
            ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
            ImageJPEG($images_fin, "uploads/logo/" . $newfilename);
            ImageDestroy($images_orig);
            ImageDestroy($images_fin);
            */
            $Path = "uploads/logo/";
            if(move_uploaded_file($_FILES['upl']['tmp_name'],$Path.$newfilename)){
                echo 'success';
                exit;
            }
        }

        echo 'error';
        exit;
    }

    public function actionSet_active() {
        $id = $_POST['id'];
        //Clean 
        $columns_clean = array(
            "active" => '0',
            "d_update" => date('Y-m-d H:i:s')
        );
        Yii::app()->db->createCommand()
                ->update("logo", $columns_clean, "1 = 1");

        $columns = array(
            "active" => '1',
            "d_update" => date('Y-m-d H:i:s')
        );
        Yii::app()->db->createCommand()
                ->update("logo", $columns, "id = '$id' ");
    }

    public function actionDelete() {
        $id = $_POST['id'];
        $model = new Backend_logo();
        $rs = $model->get_logo_by_id($id);
        $images = $rs['logo'];
        if (isset($images)) {
            $filename = './uploads/logo/' . $images;

            if (file_exists($filename)) {
                unlink($filename);
            }
        }

        Yii::app()->db->createCommand()
                ->delete('logo', "id = '$id' ");
    }

}
