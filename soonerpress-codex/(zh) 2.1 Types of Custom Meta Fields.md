
# SoonerPress - Defination of fields in custom meta moudules

## 公共参数

-  参数：`id`（字符串，必需）存储 ID
-  参数：`title`（字符串，必需）条目标题
-  参数：`type`（字符串，必需）条目类型
-  参数：`desc`（字符串，可选）条目说明
-  参数：`std`（字符串，可选）条目初始值
-  参数：`multiple`（布尔，可选）是否为可重复条目（仅当 `type` 为 `text`、`email`、`password`、`textarea`、`file`、`image` 之一时可用；当 `type` 为 `group` 时可省略设置 `multiple` 为 `true`）
-  参数：`ml`（布尔，可选）是否支持多语言（仅在多语言模块启用时可用）
-  参数：`single_title`（字符串，必需）可重复的分组条目单个分组标题（仅当 `type` 为 `group` 可用）
-  参数：`fields`（数组，可选）可重复的分组条目单个分组条目数据，子条目格式同一般条目（仅当 `type` 为 `group` 可用）

## 参数 `type` 取值

### title

标题

### info

段落文字

### text

单行文本框

### textarea

多行文本框

### wysiwyg

富文本多行文本框

### file

媒体库上传选择

### image

媒体库上传选择（图片版）

### select

下拉菜单

-  参数：`choices`（数组，必需）选项

### select_multi

多选菜单

-  参数：`choices`（数组，必需）选项

### checkbox

多选框

-  参数：`choices`（数组，必需）选项

### radio

单选框

-  参数：`choices`（数组，必需）选项

### email

邮件格式单行文本框

### password

密文格式单行文本框

### pages

页面选择（下拉菜单式），返回页面ID值

### datepicker

date 拾取器

### datetimepicker

datetime 拾取器

### colorpicker

颜色拾取器

### colorpicker

颜色下拉菜单

-  参数：`choices`（数组，必需）选项

### group

可重复组条目
