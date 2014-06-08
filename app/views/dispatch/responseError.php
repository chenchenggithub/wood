<html>
<head>
    <title><?php echo ErrorService::instance()->getErrorCode(); ?></title>
</head>
<body>
<center>
    <h2><?php echo ErrorService::instance()->getErrorMsg(); ?></h2>
    <img src="/resource/img/404.jpg">
</center>

</body>
</html>


