<!DOCTYPE html public "-//w3c//dtd xhtml 1.0 transitional//en"
"http://www.w3c.org/tr/xhtml-transitional.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html" ; charset="utf-8" />
    <title><?php if (isset($title)) : echo $this->escape($title) . '-';
            endif; ?>社員情報管理アプリケーション</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $base_url; ?>/css/style.css" />
</head>

<body>
    <div id="header">
        <h1><a href="<?php echo $base_url; ?>/">社員情報管理アプリケーション</a></h1>
    </div>
    <div id="main">
        <?php echo $_content; ?>
    </div>
</body>

</html>