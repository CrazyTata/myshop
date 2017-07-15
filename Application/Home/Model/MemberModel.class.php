<?php
namespace Home\Model;
use \Think\Model;
class MemberModel extends Model{
    protected $pk = "mem_id";
    protected $fields = array('mem_id','mem_name','mem_password','mem_salt','mem_create_time','mem_tel','mem_email','mem_active');
    protected $_map = array(
        'id'        => 'mem_id',
        'name'      => 'mem_name',
        'pwd'       => 'mem_password',
        'salt'      => 'mem_salt',
        'tel'       => 'mem_tel',
        'email'     => 'mem_email'
    );
//    protected $_auto = array(
//        array('mem_create_time',time(),1,'function')
//    );
    protected $_validate = array(
        array('mem_name','require','用户名必须填写',1,'regex',1),
        array('mem_name','','用户名已存在',1,'unique'),
        array('mem_password','require','密码必须填写','regex',1),
//        array('mem_password',)
    );
}