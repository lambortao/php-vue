<?php 
  $dir = substr(dirname(__FILE__), 0, (strlen(dirname(__FILE__)) - 8));
  require($dir . '/config/map.php');
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>测试</title>
	<!-- 这个是栅格排版的css文件 -->
	<link rel="stylesheet" href="<?php echo base_url('app/public/css/bootstrap.css');?>">
	<?php mountLibs(['jquery', 'swiper', 'lazyload']);?>
	<!-- 这个是插件库的css文件 -->
	<!-- <script src="<?php echo base_url('app/public/libs/bundle.f8ffb2a00e2e8d1bbf28.js');?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('app/public/libs/style.f8ffb2a00e2e8d1bbf28.css');?>"> -->
	<?php insertJS('main'); ?>
	<?php insertCSS('main'); ?>
</head>
<body>