#一个简单的php7 mongodb数据库操作类 需要安装php mongodb 扩展才能正常使用

//初始化
$table = "user";
$db    = "app";
$host  = "127.0.0.1";
$port  = "27017";
$mongo=new mongodb($table,$db,$host,$port);

//增
$mongo->add(['user'=>'ninvfeng','pass'=>'password']);
$mongo->add(['user'=>'lvlv','pass'=>'password']);

//删
$mongo->where(['user'=>'ninvfeng'])->delete();

//改
$mongo->where(['user'=>'lvlv'])->save(['pass'=>'password2']);

//查找一条
$mongo->where(['user'=>'lvlv'])->find();

//查找全部
$mongo->select();

//查找并删除 原子操作
$mongo->where(['user'=>'lvlv'])->findAndRemove();

//统计
$mongo->count();

//调用函数
$mongo->func();
