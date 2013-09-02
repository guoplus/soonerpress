
# SoonerPress - Codex Overview

## 函数 `sp_option`

**读取 Options Panel 模块存储的 options 值**

-  格式：`<?php echo sp_option( $key, $lang = '' ); ?>`

## 函数 `sp_pm`

**读取 Post Custom Meta 模块存储的 post custom fields 值**

-  格式：`<?php echo sp_pm( $post_id, $key, $lang = '' ); ?>`

## 函数 `sp_icon_src`

**输出从 `/images/icon/*.png` 中调用的图标 HTML 代码**

-  格式：`<?php echo sp_icon_src( $name ); ?>`

## 函数 `sp_icon_font`

**输出通过 Font Awesome 插件显示的图标 HTML 代码**

-  格式：`<?php echo sp_icon_font( $name ); ?>`

## 函数 `sp_enabled_module`

**查看指定的模块是否已启用**

-  格式：`<?php echo sp_enabled_module( $module ); ?>`
-  返回：（布尔）

## 函数 `sp_nav_menu`

**输出 WordPress Nav Menu**

-  格式：`<?php sp_nav_menu( $theme_location, $menu_class, $menu_id, $depth, $args_extra = array(), $lang = '' ); ?>`

## 函数 `sp_ml_ext`

**从指定被格式化后的字符串或数组中取出指定语言的内容**

-  格式：`<?php echo sp_ml_ext( $original, $lang = '' ); ?>`
-  返回：（字符串）

## 函数 `sp_ml_lang`

**获取当前语言**

-  格式：`<?php echo sp_ml_lang(); ?>`
-  返回：（字符串）

## 函数 `sp_ml_html_selector`

**输出指定形式的语言选择器 HTML 代码（用于 Front Page）**

-  格式：`<?php echo sp_ml_html_selector( $args = array(), $echo = false ); ?>`
-  参数：
	-  `container_class`：选择器标签类，缺省为 `sp-ml-selector`
	-  `type`：选择器形式，可选值为：`select`、`text`、`img`，缺省为 `select`
	-  `separator`：` 选择器链接间分隔符，缺省为 ` | `
-  返回：（字符串）

## 函数 `sp_ml_html_languages_tabs`

**输出国旗图标形式的语言选择器 HTML 代码（用于 WordPress Dashboard）**

-  格式：`<?php echo sp_ml_html_languages_tabs( $args = array(), $echo = false ); ?>`
-  返回：（字符串）

