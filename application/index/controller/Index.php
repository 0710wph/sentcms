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
        // select sum(feiyong) from form_form where uid=2 group by killtype
        $where['uid'] = session('user_auth.uid');
        //$where['killtype'] = 1;
        $uid = 2;
        //$sql = "SELECT SUM( feiyong ) , killtype FROM sent_form_form  WHERE uid ={$uid} GROUP BY killtype";
        //select max(creat_time) as maxtime,min(creat_time) as mintime from sent_form_form where uid = 2
        $feiyong_count = db('form_form')
            ->field('SUM(feiyong) as money,killtype')
            ->where($map)
            ->group('killtype')
            ->select();
        $dates = db('form_form')
            ->field('max(create_time) as maxtime,min(create_time) as mintime')
            ->where($map)
            ->find();
        $data = array(
            'uid'    => session('user_auth.uid'),
            'list'   => $list,
            'page'   => $list->render(),
            'feiyong'=> $feiyong_count,
            'dates'  => $dates,
            'param'  => $param
        );
        $this->assign($data);
        $this->setSeo('我的账单列表-'.config('web_site_title'), config('web_site_keyword'), config('web_site_description'));
        return $this->fetch();
    }
}
