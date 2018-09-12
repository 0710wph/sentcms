<?php
namespace app\api\controller;

class User extends \app\common\controller\Api{
	
	public function login() {
		return $this->data;
	}
}