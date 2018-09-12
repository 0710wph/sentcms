<?php
// +----------------------------------------------------------------------
// | SentCMS [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.tensent.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: molong <molong@tensent.cn> <http://www.tensent.cn>
// +----------------------------------------------------------------------

namespace app\user\controller;
use app\common\controller\User;

class Index extends User {

	public function index() {
        $this->setSeo('会员首页-'.config('web_site_title'), config('web_site_keyword'), config('web_site_description'));

		return $this->fetch('user/index');
	}
}
