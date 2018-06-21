<?php
namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\User as UserModel;
use app\common\model\Flight as FlightModel;


class User extends Base
{
    /**
     * @return array|\think\response\View
     * 渲染index视图的方法
     */
    public function index()
    {
        $this->checkUserLoged();
        return view();
    }

    /**
     * @return array|\think\response\View
     * 渲染注册视图
     */
    public function reg(){
        return view();
    }

    /**
     * @return array|\think\response\View
     * 用户登录界面
     */
    public function login(){
        $this->checkLoginStatus();
        return view();
    }

    /**
     * @return array|\think\response\View
     * 用户点击预定航班后的界面的渲染
     */
    public function select(){
        $this->checkUserLoged();
//        flightid
        return view();
    }
    /**
     * @return array
     *           注册用户的方法
     */
    public function add(){
        if(request()->isAjax()){
            $user = new UserModel();
            if($user->allowField(true)->validate(true)->save(input('post.'))){
                return ['status' => 1 , 'msg'=>'新用户注册成功！'];
            }else{
                return ['status' => 0 , 'msg'=>$user->getError()];
            }
        }
        return ['status' => 0 , 'msg'=>'未知错误'];
    }

    /**
     * @return array
     * 用户登录操作界面
     */
    public function doLogin()
    {

        if(request()->isAjax())
        {
            $user = new UserModel();
            return $user->checkUserLogin(input('param.'));
        }
        return ['status' => 0];
    }

    /**
     * 用户退出登陆操作
     */
    public function logout()
    {
        // 清空session值
        session('user_id' , null);
        session('user_info' , null);
        $this->success('退出登录成功!',url('index/user/login'));
    }


    /**
     * 用户查询航班的方法
     */
    public function usersearchFlight()
    {
        if(request()->isAjax()) {
            $flight = new FlightModel();
            $map = input('post.');
            //将传来的数据
            $str = strtotime($map['fly_time']);
//            dump($str);
            $map['fly_time'] = $str;
            $nowtime = strtotime("now");
//            dump($nowtime);
//            dump(($map['fly_time']));
            foreach ($map as $k => $v) {
                if ($k == "fly_time" )
                {
                    unset($map[$k]);
                }
            }
//            dump($map);
            if ($data = $flight->where('fly_time','>',$str)->where('fly_time','<',$str+2682000)->where($map)->select())
            {
//                dump($data);
                return $data;
            }else{
                return ['status'=>0,'msg'=>'填写信息不完整，或者暂时没有您查询的航班'];
            }
        }
    }

    public function bookingbut()
    {
        if(request()->isAjax()) {

            $flight = new FlightModel();
            $map = input('post.');
            $data=$flight->where($map)->select();
            return $data;
        }
    }
}
