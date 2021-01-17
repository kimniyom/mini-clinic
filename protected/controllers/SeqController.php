<?php

class SeqController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $enableCsrfValidation = false;
	public $layout = 'template_seq';

	/**
	 * @return array action filters
	 */

	public function actionIndex() {
		$this->render("index");
	}

	public function actionGetseq() {
		if (isset($_POST['txt'])) {
			$txt = $_POST['txt'];
			$txt = htmlspecialchars($txt);
			$txt = rawurlencode($txt);
			$html = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=' . $txt . '&tl=th-IN');
			$player = "<audio autoplay><source src='data:audio/mpeg;base64," . base64_encode($html) . "'></audio>";
			echo $player;
		}
	}

	public function actionSeqauto() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
		$Model = new Service();
		$branch = '1';
		$data['seq'] = $Model->Getseq($branch);
		$this->render('seq', $data);
	}

	public function actionSmartcardseq(){
		$this->render('smartcardseq');
	}

}
