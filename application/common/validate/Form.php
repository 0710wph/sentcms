<?php
// +----------------------------------------------------------------------
// | SentCMS [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.tensent.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: molong <molong@tensent.cn> <http://www.tensent.cn>
// +----------------------------------------------------------------------

namespace app\common\validate;

/**
 * 设置模型
 */
class Form extends Base {
	protected $rule = array(
		'title'   => 'require',
		'name'   => 'require|checkTable|unique:form|/^[a-zA-Z]\w{0,39}$/',
        'leave_hours' => 'require',
        'feiyong' => 'require|float',
	);

	protected $message = array(
		'title.require'   => '字段标题不能为空！',
        'feiyong.require'   => '金额不能为空！',
		'name.checkTable' => '数据库中有此表',
        'leave_hours.require'=>'时长不能为空',
        'feiyong.float'   =>  '请填写正确的金额',
	);

	protected $scene = array(
		'add'   => 'title, name, leave_hours',
		'edit'   => 'title',
        'addeditform'=> 'feiyong',//在控制器进行验证可以调用form.addeditform
	);

	protected function checkTable($value, $rule, $data){
		$tablename = 'form_' . strtolower($value);
		$db = new \com\Datatable();
		if (!$db->CheckTable($tablename)) {
			return true;
		}else{
			return false;
		}
	}
}