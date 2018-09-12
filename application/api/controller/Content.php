<?php
namespace app\api\controller;

class Content extends \app\common\controller\Api{

	public function lists($page = 1, $pagesize = 25){
		$list = db('Article')->page($page . ',' . $pagesize)->order('id desc')->select();
		foreach($list as $key => $value){
			$list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
			$list[$key]['cover'] = 'https://www.tensent.cn' . get_cover($value['cover_id'], 'path');
		}
		$this->data['list'] = $list;
		return $this->data;
	}

	public function detail($id = 0){
		$info = db('Article')->where('id', $id)->find();
		$info['create_time'] = date('Y-m-d H:i:s', $info['create_time']);
		$info['content'] = str_replace('/uploads/', 'https://www.tensent.cn/uploads/', $info['content']);
		$info['cover'] = 'https://www.tensent.cn' . get_cover($info['cover_id'], 'path');

		$this->data['info'] = $info;
		return $this->data;
	}
}
