<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'itshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀

    'MODULE_ALLOW_LIST'     => array('Admin','Home','Api'),
    //错误追踪机制
    'SHOW_PAGE_TRACE'       => true,
    //设置I方法使用过滤函数
    'DEFAULT_FILTER'        => 'filterXSS',
    'UPLOAD_IMG'            =>  array(
        'rootPath'      =>  './Upload/',
        'maxSize'       =>  3000000,
        'exts'          =>  array('jpg','png','gif'),
    ),
    'IMAGE_THUMB_SCALE'     =>   1 ,

);