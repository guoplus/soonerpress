
## 20130908 更新

### 此版本状态

- 不可内测
- 不可发布

### 此版本完成功能

- Post Custom Meta：支持对整个 meta box 设置是否开启多语言，便于用户使用
- Term Meta 基本 API
- Taxonomy Custom Meta：支持多语言，支持设置是否对整个“Box”开启多语言
- 所有 Custom Meta 新增 field type：`posts`、`taxonomy`、`timepicker`、`datetimepicker`
- 所有 Custom Meta 对可用的 input field（如 text、email、datepicker、textarea 等）添加 `placeholder` 参数
- 增强了 Custom Meta Fields Group 功能：row title、row name refer field、default expanded 等
- 框架预置的 scripts 和 stylesheets 仅作为 WordPress 内置的 JS & CSS 库的补充，因此较前一版本删除少部分与 WordPress 内置的重复的 scripts & stylesheets
- Multilanguage 新增支持 terms（term 的 `name` 和 `description` 属性）
- Multilanguage 可在配置文件中选择对哪些 post-types、taxonomies 开启多语言（但不覆盖 Post Custom Meta、Taxonomy Custom Meta 是否启用多语言的设置）

### 此版本已知问题

- 后台元素样式有待改进

### 开发手记

- Multilanguage 对 meta value 存储方式较上一版本重写，多种语言分开存储数据表行，以下以 enabled 为 (en, zh, de) 且 main_stored 为 en 为例
	- Options Panel：`wp_option` → `sp_sitename`（英文）、`sp_sitename__zh`（中文）、`sp_sitename__de`（德文）
	- Post Custom Meta：'wp_postmeta' `_event_title`（英文）、`_event_title__zh`（中文）、`_event_title__de`（德文）
	- Term Custom Meta 和 User Custom Meta 同 Post Custom Meta 存储结构
- 所有 Custom Meta Field 输出整合到 core 的子模块中，并对代码结构进行封装，便于代码结构管理和性能优化
- 敲定文件夹名称为 `config`、`includes`、`library`、`assets`、`images`、`languages`
- Term Meta API 采用普遍流行的 `wp_option` 存储方式（例 Term ID 为 21 的 meta 存储结构为：`wp_option` → `_termmeta_21` = `{string|SERIALIZED_DATA}`）
- WordPress 初始化时本身已对 `$_POST`、`$_GET` 加上反斜杠（即使 PHP 环境设置 magic quotes 关闭），因此 SoonerPress 自有底层功能（如 Term Meta API）时，将无条件使用 WordPress 自带的 `wp_unslash()` 函数对数据处理
- SoonerPress Docs 敲定全局内容存储采用 Markdown 格式，应用框架暂使用 Daux.io，以后考虑自主开发此类框架，Daux.io 本身功能不足、缺陷不少，同时也将考虑将 Docs 整合到 SoonerPress.com 中（类似 WordPress.org 的应用结构）
