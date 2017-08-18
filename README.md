# 企业内部图书馆管理系统

## 可以做什么？

- 浏览企业内部所有书籍和可借书籍
- 方便查看某本书籍在谁手上
- 统计书籍借阅情况

## 如何使用？


```
$ git clone https://github.com/simuhui/library.git
$ cd library
$ composer install
$ php init
```

*关于 Composer 使用请参考[官网文档](https://getcomposer.org/)

手动新建一个数据库，然后修改 `common\config\main-local.php` 文件内容，修改数据库配置。
还可以添加 `name` 替换系统默认值，代码示例如下：

```php
<?php
return [
    'name' => '云端私募会图书管理系统',
    'components' => [
    // ...       
    ]
];
```

继续回到终端执行命令

```
$ php yii migrate
$ php yii migrate --migrationPath=@yiier/inviteCode/migrations/
```

**关于后台登录问题**

需要手动修改数据库 user 表的 `role` 字段值为30，才可以登录后台。

然后就可以配置 nginx 信息了。参考连接 [Configuring Web Servers](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#configuring-web-servers)


**注册码功能说明**

默认开启此功能，注册时必须输入注册码才能注册。

如果想关闭此功能，修改 `common\config\params-local.php` 文件，添加如下代码：

```php
<?php
return [
    'enableInviteCode' => false, // 关闭邀请码注册
];

```

如何生成注册码？

先进入项目根目录，执行以下命令：

```
$ php yii gcode 100
```

查看数据库，然后就会在注册码表（`invite_code` ）看到100个注册码。

## 截图

![详情页面](https://i.loli.net/2017/08/17/59955d24908cb.png)
![首页](https://i.loli.net/2017/08/17/59955d2493420.png)
![列表页面](https://i.loli.net/2017/08/17/59955d24a2422.png)


## TODO

- [ ] 同事分享自己的书籍
- [ ] 后台完善 && 美化
- [ ] 找回密码功能
