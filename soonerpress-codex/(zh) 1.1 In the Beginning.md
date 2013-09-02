
# SoonerPress - In the beginning

## 开发步骤

1. 从 SoonerPress 官方网站下载最新版 SoonerPress，并解压缩模板文件至 WordPress 模板目录
-  修改 SoonerPress 模板目录名称、`style.css` 文件参数、`screenshot.png` 文件等
-  增删、修改 `/*.php`、`/config/*.php` 以开始服务器端开发
-  删除未被使用到的 `/includes/*`、`/plugins/*` 以及其他 `/*`
-  完成！

## 代码文件布置

-  常见模板参数（如加载 JS/CSS、翻译、功能支持等）在 `/config/theme-setup.php` 中设置
-  自有功能可在 `/functions.php` 中编程（通常 `/includes/*.php` 不被编辑）
-  通常情况下，JS 目录为 `/assets/js/`，CSS 目录为 `/assets/css/`，字体文件目录为 `/assets/fonts/`，图片目录为 `/images/`
-  通常情况下，前端 JS 为 `/assets/js/web.front-end.js`，服务器端 JS 为 `/assets/js/web.back-end.js`
-  通常情况下，前端 CSS 为 `/style.css`，服务器端 CSS 为 `/assets/js/web.back-end.css`、`/assets/js/web.wp-login.css`
