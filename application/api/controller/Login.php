<?php
namespace app\api\controller;

class Login extends \app\common\controller\Api{


	public function index(){
		$username = $this->request->param('username', '');
		$password = $this->request->param('password', '');

		if (!$username || !$password) {
			$this->data['code'] = 1;
			$this->data['msg'] = "账号密码不能为空！";
			return $this->data;
		}

		$user = db('Member')->where('username', $username)->find();
		if ($user && $user['status'] == 1) {
			if ($user['password'] == md5($password . $user['salt'])) {

				$info['access_token'] = authcode($user['uid'].'|'.$user['username'].'|'.$user['password'], 'ENCODE');
				$info['uid'] = $user['uid'];
				$info['username'] = $user['username'];
				$info['password'] = $user['password'];
				$info['avatar'] = (isset($user['avatar_url']) && $user['avatar_url']) ? $user['avatar_url'] : avatar($user['uid']);

				$this->data['data'] = $info;
				return $this->data;
			}else{
				$this->data['code'] = 1;
				$this->data['msg'] = "密码错误！";
				return $this->data;
			}
		}else{
			$this->data['code'] = 1;
			$this->data['msg'] = "无此账户或账户被禁用！";
			return $this->data;
		}
	}
}