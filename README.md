# 一个简单的PHP Mongodb单文件操作类

## 依赖
- php7
- php7-mongodb扩展

## 安装
1. composer 安装 ``` composer require ninvfeng/mongodb ```
2. 引入/vendor目录下的autoload.php ``` require 'vendor/autoload.php'; ```

## 初始化
```
//配置
$config=[
    'host'=>'127.0.0.1',
    'port'=>27017,
    'name'=>'test'
]

//推荐使用函数进行实例化,后续操作更加方便
function mongodb($table='null') use $config{
    static $_mongodb;
    if(!$_mongodb){
        $_mongodb=new \ninvfeng\mysql($config);
    }
    return $_mongodb->table($table);
}
```
### 增
```
mongodb('user')->add(['user'=>'ninvfeng','pass'=>'password']);
mongodb('user')->add(['user'=>'lvlv','pass'=>'password']);
```
### 删
```
mongodb('user')->where(['user'=>'ninvfeng'])->delete();
```

### 改
```
mongodb('user')->where(['user'=>'lvlv'])->save(['pass'=>'password2']);
```

### 查找一条
```
mongodb('user')->where(['user'=>'lvlv'])->find();
```

### 查找&&分页
```
mongodb('user')->page(1)->select();
```

### 查找并删除 原子操作
```
mongodb('user')->where(['user'=>'lvlv'])->findAndRemove();
```

### 统计
```
mongodb('user')->count();
```

### 调用函数
```
mongodb('user')->func();
```

### 返回原生对象
```
mongodb('user')->mongodb();
```
