<?php
namespace app\common\model;

use think\Model;




class Flight extends Model{

    //数据库表的确定
    protected $name='flight';



//    protected $auto = ['fly_time',];

    //修改器，更改fly_time
    public function setFlyTimeAttr($value , $data){
        if($data['fly_time']){
            return strtotime($data['fly_time']);
        }
        return '';
    }
//    protected function setFlyTimeAttr($value){
//        return strtotime($value);
//    }

    //修改器，更改fly_timeall
    public function setFlyTimeallAttr($value , $data){
        if($data['fly_timeall']){
            return strtotime($data['fly_timeall']);
        }
        return '';
    }

    //获取器 直接获取FlyTime
    public function getFlyTimeallAttr($value){
        return date('Y-m-d H:i:s',$value);
    }
}