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

//实例化
$mongo=new mongodb($table,$config);
```
### 增
```
$mongo->add(['user'=>'ninvfeng','pass'=>'password']);
$mongo->add(['user'=>'lvlv','pass'=>'password']);
```
### 删
```
$mongo->where(['user'=>'ninvfeng'])->delete();
```

### 改
```
$mongo->where(['user'=>'lvlv'])->save(['pass'=>'password2']);
```

### 查找一条
```
$mongo->where(['user'=>'lvlv'])->find();
```

### 查找&&分页
```
$mongo->page(1)->select();
```

### 查找并删除 原子操作
```
$mongo->where(['user'=>'lvlv'])->findAndRemove();
```

### 统计
```
$mongo->count();
```

### 调用函数
```
$mongo->func();
```

### 返回原生对象
```
$mongo->mongodb();
```
