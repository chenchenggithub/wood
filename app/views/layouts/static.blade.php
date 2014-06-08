<?php
$version = ResourceSpall::getResourceVersion();
?>
@section('common_css')
<link href="/resource/css/lib/bootstrap.min.css?v=<?php echo $version; ?>" type="text/css" rel="stylesheet"/>
<link href="/resource/css/lib/font-awesome.min.css?=<?php echo $version;?>" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/resource/css/lib/jquery.mCustomScrollbar.css?v=<?php echo $version;?>" />
<link rel="stylesheet" href="/resource/css/lib/bootstrap-switch.min.css?v=<?php echo $version;?>">
<link rel="stylesheet" href="/resource/css/lib/jquery-ui/jquery-ui-1.10.4.custom.min.css?v=<?php echo $version;?>">
<link href="/resource/css/lib/main.css?v=<?php echo $version; ?>" type="text/css" rel="stylesheet" />
@stop


@section('common_js_header')
<script type="text/javascript" src="/resource/js/lib/jquery.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/lib/jquery.mCustomScrollbar.concat.min.js?v=<?php echo $version; ?>"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="/resource/js/lib/html5shiv.min.js"></script>
<script type="text/javascript" src="/resource/js/lib/respond.min.js"></script>
<![endif]-->
@stop

@section('common_js_footer')
<script type="text/javascript" src="/resource/js/lib/bootstrap.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/lib/bootstrap-switch.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/lib/jquery-ui/jquery-ui-1.10.4.custom.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/lib/jquery-ui/jquery-ui-1.10.4.custom.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/lib/TSB.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/config.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/lib/main.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/resource/js/user/ucenter.js?v=<?php echo $version; ?>"></script>
@stop

@section('common_meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="透视宝是一个牛B的产品">
<meta name="author" content="toushibao@jiankongbao">
@stop

@section('common_js_config')
<script>
    var APPCONFIG = <?php echo isset($json_config) ? json_encode($json_config) : json_encode(array());?>;
</script>
@stop
