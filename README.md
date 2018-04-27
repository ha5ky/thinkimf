# ThinkIMF是什么
## 一款基于PHP7+ SWOOLE + MariaDb/Mysql 的物联网设备管理框架
为物联网3.0进行驱动的软件,跨平台，开放源代码

##ThinkIMF有哪些功能？
* 登录注册
* 用户管理
* 扫码登录[特色功能]
* 权限管理
* 物联网设备管理 
* 物联网设备通信 
* 物联网设备地理位置 
* 文章管理 TODO
* 数据地图 TODO
* 服务首页 TODO
* 合伙人招募 TODO
* 推送服务 TODO
* 即使新闻 TODO
* Auto Install模块 TODO
* 网页版客户端 [特色功能] TODO
* 安卓客户端   [特色功能] TODO
* IOS客户端    [特色功能] TODO 


##有问题反馈或者加入我们
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(unnnnn#foxmail.com, 把#换成@)
* QQ: 1367784103
##关于作者
* [Doung Master](https://dyoung.unnnnn.com)

* ThinkIMF Powered By PHP7.X  and Dyoung Chen


##docker使用

可以使用当前目录下的Dockerfile进行构建
```
 docker build -t registry.cn-hangzhou.aliyuncs.com/thinkimf/iot:thinkimf .
```

```
或者 docker pull registry.cn-hangzhou.aliyuncs.com/thinkimf/iot:thinkimf
```

```
启动 docker run -i -t -d -P -p 80:80 -p 3306:3306 -p 2110:22 --hostname thinimf registry.cn-hangzhou.aliyuncs.com/thinkimf/iot:thinkimf
```

```
启动后 使用 docker exec -i -t 容器ID /bin/bash/
```

```
进入后 执行 open_service (开启nginx,mysql,php-fpm,ssh)
```

```
之后可以远程访问  ssh -p 2110 root@ip   用户名:root,密码thinkimf
```

```php
<?php
    
  print 'PHP是世界上最便捷的web开发语言';
  
```
