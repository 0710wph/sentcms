<?php
namespace app\common\controller;

class Front extends Base{

	public function _initialize(){
		parent::_initialize();

		//设置主题信息
		$this->setThemes();
	}


	public function setThemes(){
		$themes['mobile'] = config('mobile_themes') ? config('mobile_themes') : 'mobile';
		$themes['pc']     = config('pc_themes') ? config('pc_themes') : 'default';
		
		$theme = ($this->isMobile() && config('open_mobile_site') == '1') ? $themes['mobile'] : $themes['pc'];
		
		$module = $this->request->module();
		if ($module == 'index' || $module == 'user' ) {
			$view_path   = '/template/' . $theme . '/' ;
		}else{
			$view_path   = '/template/' . $theme . '/' . $module . '/';
		}
		$tpl_replace = array(
			'__TPL__' => $view_path,
			'__CSS__' => $view_path . 'static/css',
			'__JS__' =>  $view_path . 'static/js',
			'__IMG__' => $view_path . 'static/images',
		);
		$tpl_conf = array(
			'view_path'   => '.' . $view_path,
			'tpl_replace_string' => $tpl_replace
		);
		$this->view->config($tpl_conf);
	}
}