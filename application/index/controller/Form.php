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

class Form extends Front {

	public function _initialize() {
		parent::_initialize();
		$model_name = $this->request->param('model');
		$this->form = db('Form')->where('name', $model_name)->find();
		$this->model = M($model_name, 'form');
	}

	/**
	 * 表单首页
	 */
	public function index(){
		return $this->fetch();
	}

	/**
	 * 表单列表
	 */
	public function lists(){
		$list = $this->model->order('id desc')->paginate('20');

		$data = array(
			'list'   => $list,
			'page'   => $list->render()
		);
		$this->assign($data);
		return $this->fetch();
	}


	/**
	 * 表单数据提交
	 */
	public function add(\think\Request $request){
        $map['form_id'] = $this->form['id'];
        $attr = model('FormAttr')->getFieldlist($map);
		if ($request->isPost()) {
			$data = $request->param();
            $result = $this->model->saveFront($data);
			if ('1' == $result) {
				return $this->success('提交成功！');
			}else{
                return $this->error($result,'index/index/bill');
			}
		}else{
			$map['form_id'] = $this->form['id'];
			$attr = model('FormAttr')->getFieldlist($map);
			$data = array(
				'attr'    => $attr
			);
            $this->setSeo('表单-'.config('web_site_title'), config('web_site_keyword'), config('web_site_description'));
            $this->assign('title',"表单");
			$this->assign($data);
			return $this->fetch();
		}
	}
}