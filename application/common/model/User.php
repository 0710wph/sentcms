<?php
namespace app\common\model;

class User extends Base {

    /**
     * 根据ID获取用户信息
     */
    public function getInfo($uid, $field = true){
        return  db('member')->where("status=1 and uid=$uid")->field('username,email,uid')->select();
    }
    /**
     * 获取用户表单列表
     */
    public function getFormList($uid, $field = true){
        return  db('form_form')->where("uid=$uid")->field('create_time,info,killtype,feiyong')->select();
    }
    /**
     * 后台修改密码
     */
    public function editpw($data){
//        $uid = session('user_auth.uid');
        $uid = session('user_auth')['uid'];
//        $user = db('member')->where(array('uid'=>$uid))->find(); $user['salt']
        $u = db('member')->where("status=1 and uid=$uid")->field('salt,password,uid')->select();
        $salt = $u[0]['salt'];
        $passwd = $u[0]['password'];
        if(md5($data['oldpassword'] . $salt) == $passwd){
            if(!empty($data['password']) && ($data['password'] == $data['repassword'])){
                /// TODO 更新了密码和salt值
                $newdata['salt'] = rand_string(6);
                $newdata['password'] = md5($data['password'] . $newdata['salt']);
                model('Member')->save($newdata, array('uid'=>$uid));
                $this->error = '密码更新成功';
                return true;
            }else{
                $this->error = '新密码和确认密码不一致';
                return false;
            }
        }else{
            $this->error = '原密码不正确';
            return false;
        }
    }

}