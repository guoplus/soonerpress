
## 20130901 更新

状态：不可内测，不可发布

已完成自有功能：

-  Options Panel
-  Post Custom Meta
-  Pagination
-  Navigation Menus

已部分完成自有功能：

-  Multilanguage（此版本仅支持 `post_title`、`post_content`、`post_excerpt` 以及 SoonerPress 自有功能）
-  SEO（此版本不支持 Multilanguage 模块）

已集成第三方功能（使用后不可升级 SoonerPress，将在以后版本重构自有）

-  Post Order
-  Taxonomy Order
-  Taxonomy Custom Meta
-  Adjacent Post Link

已知问题：

-  Post Custom Meta 模块在 WordPress 后台中，有关支持 `multiple` 的条目以及类型为 `group` 的条目，排序 JavaScript 有问题
-  部分代码可读性不够，且注释有待增加

开发手记：

-  代码文件布置
	-  `assets` 为 JS、CSS、Fonts 专用文件夹，为用户开发文件放置，可随意编辑
	-  `images` 为图片文件夹（未放至 `assets` 文件夹中是因为方便 `style.css` 书写方便、前端开发的方便），可随意编辑
	-  `config` 为 SoonerPress 自有模块的配置文件夹，可随意编辑，用户可自行配置一份并保留作为私有的日常开发配置文件模板
	-  `includes` 为 SoonerPress 自由模块程序代码，通常情况下不被编辑
	-  `plugins` 为第三方前端程序（如 Bootstrap、Font Awesome 等）文件夹
	-  `languages` 为模板翻译文件文件夹
	-  模板根目录下的文件亦均可供用户随意编辑（除了 `functions.php` 中引用 `/includes/soonerpress.php` 的 PHP 代码）
-  所有 Custom Meta 的 field input 部分的 HTML 整合到函数 `__sp_custom_meta_do_entry_html_field` 中统一输出，可辨别 field type、is multiple 等属性
-  模板自带的 JS、CSS，部分通过函数 `wp_register_script` 初始化，部分通过自有函数（如 `sp_enqueue_bootstrap_js`、`sp_enqueue_jquery_own` 等）整合并由用户在 `wp_enqueue_scripts` action 中调用
-  Options Panel 模块采取一项条目一项 `wp_option` 行存储，通过 WordPress `register_setting` 函数初始化，数组（包括 multiple field、multi-language field 等）采用 PHP `serialize` 函数格式化后存储
-  Post Custom Meta 模块采取一项一级条目一项 `wp_postmeta` 行存储，数组（包括 multiple field、multiple group field、multi-language field 等）采用 PHP `serialize` 函数格式化后存储
-  Navigation Menus 模块多语言采取不同语言不同菜单分别向 WordPress 的形式（例 'main-menu' 'foot-menu' 配上 'zh' 'en' 则注册菜单为：'main-menu-zh' 'foot-menu-zh' 'main-menu-en' 'foot-menu-en'）
-  Multi Languages 模块
	-  对各 Custom Meta 模块的多语言化均通过 WordPress API（action/filter hook）处理，代码文件可独立拆分使用
	-  post edit 的多语言化，`post_title`、`post_content`、`post_excerpt` 存储在 `wp_posts` 表的数据为 multi-language configuration 中 `main_stored` 定义的语种，除此之外的语种均存储在 `wp_postmeta` 表中（此举是为了方便日后配合 WordPress 升级、与其他 WordPress 插件的兼容性以及吸取现有同类多语言插件的经验所得）
