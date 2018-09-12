<?php
/**
 * Created by PhpStorm.
 * User: gdcm2016
 * Date: 2018/9/5
 * Time: 11:19
 */

namespace app\index\controller;
use app\common\controller\Front;

class Bill extends Front {
    public function _initialize() {
        parent::_initialize();
        if (!is_login()) {
            return $this->redirect('user/login/index');
        } elseif (is_login()) {
            $user = model('User')->getInfo(session('user_auth.uid'));
            $this->assign('user', $user);
        }
    }

    public function index(){
        $this->setSeo('表单-'.config('web_site_title'), config('web_site_keyword'), config('web_site_description'));
        return $this->fetch();
    }


}