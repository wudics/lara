# easyweb

#### 项目介绍
easyweb是一个简单易用的php框架，实现了路由、容错、过滤器等处理，集成composer代码生态，可快速创建中小型网站应用。

#### 软件架构
easyweb采用单一入口解决方案，所有非静态文件均指向Public目录下的index.php文件，由该文件加载启动。

Core目录的Controller.php、Model.php和View.php文件，分别定义了控制器、模型和视图的基类，实现了过滤器功能，由子类继承。另外Error.php和Router.php分别用于处理错误和路由，由入口文件index.php加载。

App目录下有Config.php文件，由入口文件index.php加载，以及Controllers、Models和Views目录，分别用于存放控制器、模型和视图的代码。

easyweb以目录结构作为命名空间规则，对类进行自动加载。

#### 安装教程

1. 下载源码解压
2. 配置.htaccess文件，使其指向Public/index.php，其中?$1表示请求参数，将由index.php处理，注意在$_SERVER['QUERY_STRING']中，第一个问号，即?$1的?，将会被转换为&，即与符。
```
RewriteEngine On
RewriteBase /Public
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)$ index.php?$1 [QSA,L]
```
3. 完成安装

#### 使用说明

1. 在App\Controllers中的Home.php为示例文件，在网址上输入localhost/?age=30&female=false和localhost/home/index?age=30&female=false测试。
2. 在App中编写代码，控制器类名首字母为大写，如Home，控制器方法首字母为小写并在其后加上Action，如indexAction，另外，可以使用/my-home/hello-world的链接方式，对应的控制器类名和控制器方法的命名分别为MyHome和helloWorldAction，即Router.php会把-连接的字符拆分，具体可看Router.php对-的处理方法。
3. App\Config.php文件是全局配置文件，通常在此配置数据库连接、模板路径等。
4. Pulbic文件可以创建css、image、js等文件夹，用于存放公共静态文件。
5. 框架集成Composer，通过Composer安装Smarty、catfan等开源项目来创建网站。




