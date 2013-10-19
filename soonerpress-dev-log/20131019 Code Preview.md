
## 20131019 更新

### 此版本状态

- 可内测
- 不可发布

### 此版本完成功能

- Core
	- 增加多个 Useful Functions
	- `SP_Module` 模板类
	- Msg 机制，用于缓冲式输出消息到前台（Dashboard or Front-page），该机制类似于 WooCommerce 的 woocommerce_messages
- Multilingual
	- 新增后台菜单，可随意增删和排序语言，可选择缺省语言，可选择对哪个/哪些 Post Types、Taxonomies 启用多语言
	- 已登录状态下选择语言（前台或控制板）将作为 User Meta 记住
	- 在控制板选择 UI 语言，若当前 WordPress 不存在语言本地化文件，将自动从 WordPress I18N SVN 下载保存并启用
- Post Re-order
	- 支持按指定的 Taxonomy Term 筛选
	- 支持多级 Post 排序（类似 WordPress Navigation Menu Items 排序方法）
- Taxonomy Re-order
	- 支持多级 Term 排序（排序方法同上）
- Breadcrumbs
	- 支持几乎所有 WordPress 前台可能出现的页面
	- 支持 Post Type 按指定的 Taxonomy 输出面包屑路径

### 此版本已知问题

- Module Configuration 的 `gettext()` 语言本地化无法使用
- Post Re-order、Taxonomy Re-order 模块 embedded 排序模式暂未完成
- Taxonomy Re-order 的排序数据不能应用到控制板的 Terms edit 页面中
- Multilingual 功能有待加强
- User Custom Meta 功能暂不可用
- adjacent post link 功能暂使用第三方代码

### 开发手记

- 代码封装
	- 已封装类模块有：Multilingual、Post Re-order、Taxonomy Re-order、Options Panel、Breadcrumbs、Post Custom Fields、Taxonomy Custom Fields、User Custom Fields、Pagination、Dashboard
- Multilingual
	- 为了能让最终用户自由切换默认语言，因此去除上一版本的 `main_stored` 机制
