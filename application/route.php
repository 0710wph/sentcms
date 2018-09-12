<?php
// +----------------------------------------------------------------------
// | SentCMS [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.tensent.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: molong <molong@tensent.cn> <http://www.tensent.cn>
// +----------------------------------------------------------------------

return array(
	'__pattern__'    => array(
		'name' => '\w+',
	),

	'/'              => 'index/index/index', // 首页访问路由 第一个index是指app里面的index文件夹，第二index是指控制器index.php第三个index是指index方法函数
	'search'         => 'index/search/index', // 首页访问路由

//    我的记账 首页模块属于
    'bill'           => 'index/bill/index',
    'bill/list'       => 'index/bill/listbill',

	'cart/index'     => 'index/cart/index',
	'cart/add'       => 'index/cart/add',
	'cart/count'     => 'index/cart/count',

	'login'          => 'user/login/index',
	'register'       => 'user/login/register',
	'logout'         => 'user/login/logout',
	'uc'             => 'user/index/index',

	'order/index'    => 'user/order/index',
	'order/list'     => 'user/order/lists',

	'admin/login'    => 'admin/index/login',
	'admin/logout'   => 'admin/index/logout',

	// 变量传入index模块的控制器和操作方法
	'plugs/:mc/:ac' => 'index/addons/execute', // 静态地址和动态地址结合
	'user/plugs/:mc/:ac'  => 'user/addons/execute', // 静态地址和动态地址结合
	'admin/plugs/:mc/:ac' => 'admin/addons/execute', // 静态地址和动态地址结合
);