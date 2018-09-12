<?php
// +----------------------------------------------------------------------
// | SentCMS [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.tensent.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: molong <molong@tensent.cn> <http://www.tensent.cn>
// +----------------------------------------------------------------------

namespace app\index\controller;
use app\common\controller\Front;

class Index extends Front {

	//网站首页
	public function index() {
        if(is_login()) {
            $user = model('User')->getInfo(session('user_auth.uid'));
            $this->assign('user', $user);
        }
		$this->setSeo(config('web_site_title'), config('web_site_keyword'), config('web_site_description'));
        return $this->fetch('index');
	}

    //记账表单
    public function bill(){
        if (!is_login()) {
            return $this->redirect('user/login/index');
        } elseif (is_login()) {
            $user = model('User')->getInfo(session('user_auth.uid'));
            $this->assign('user', $user);
        }
        $this->setSeo('我要记账-'.config('web_site_title'), config('web_site_keyword'), config('web_site_description'));
        return $this->fetch();
    }
    /**
     * 记账列表 表单form的列表
     */
    public function listbill(){
        if (!is_login()) {
            return $this->redirect('user/login/index');
        } elseif (is_login()) {
            $user = model('User')->getInfo(session('user_auth.uid'));
            $this->assign('user', $user);
        }
        //搜索 传参是数组
        $param = $this->request->param();
        $map['uid'] = array('egt', session('user_auth.uid'));
        if (isset($param['start_time']) && $param['start_time'] && isset($param['end_time']) && $param['end_time']){
            if($param['end_time'] < $param['start_time']){

            }elseif ($param['end_time'] == $param['start_time']){
                $end = $param['end_time'] ." 23:59:59";
                $map['create_time'] = array('BETWEEN', array(strtotime($param['start_time']), strtotime($end)));
            }else{
                $end = $param['end_time'] ." 23:59:59";
                $map['create_time'] = array('BETWEEN', array(strtotime($param['start_time']), strtotime($end)));
            }
        }
        //$billList = model('User')->getFormList(session('user_auth.uid'));
        //$this->assign('list', $billList);
        $order           = "id desc";
        $list = db('form_form')->where($map)->order($order)->paginate(15, false, array(
            'param'  => $param
        ));
        //总支出
        $where['uid'] = session('user_auth.uid');
        $where['killtype'] = 1;
        $feiyongs_in = db('form_form')->field('SUM(feiyong)')->where($where)->select();
        //总收入
        $where2['uid'] = session('user_auth.uid');
        $where2['killtype'] = 2;
        $feiyongs_out = db('form_form')->field('SUM(feiyong)')->where($where2)->select();
        $data = array(
            'uid'   => session('user_auth.uid'),
            'list' => $list,
            'page' => $list->render(),
            'out'   => $feiyongs_in[0]['SUM(feiyong)'],
            'in'  => $feiyongs_out[0]['SUM(feiyong)'],
        );
        $this->assign($data);
        $this->setSeo('我的账单列表-'.config('web_site_title'), config('web_site_keyword'), config('web_site_description'));
        return $this->fetch();
    }
}
