# hyperf-multi-env
hyperf 框架多 env 文件支持

## 安装 - install
```bash
$ composer require qbhy/hyperf-multi-env
```

## 使用
只需要启动的时候设置 APP_ENV 配置，扩展包就会自动根据 env 来查找 env 文件并且覆盖原有的 `.env` 文件配置。

比如 APP_ENV 为 `testing` 那么会加载 `.env.testing` 来替换已有的 `.env` 文件配置。
> `.env.testing` 没有的配置，还是会使用 `.env` 文件的配置来加载。


hyperf学习交流请加QQ群: 873213948  
https://github.com/qbhy/hyperf-multi-env    
qbhy0715@qq.com  