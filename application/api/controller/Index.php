<?php
namespace app\api\controller;

class Index extends \app\common\controller\Api{

	public $mustToken = false;

	public function usercount(){
		$this->data['data'] = array('team_num'=>100,'coustomer_num'=>10000);
		return $this->data;
	}

	public function getlive(){
		$fp = fopen(ROOT_PATH . DS . 'live.txt', 'r');
		$info = fread($fp, filesize(ROOT_PATH . DS . 'live.txt'));
		fclose($fp);
		$res = explode("\n", $info);
		foreach ($res as $value) {
			$val = explode(",", $value);
			$data[] = array('name'=>$val[0],'src'=>$val[1]);
		}

		$this->data['data'] = $data;
		return $this->data;
	}
}