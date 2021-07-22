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
	<link rel="stylesheet" href="<?php echo base_url('app/public/css/reset.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('app/public/css/col.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('app/public/css/global.css');?>">
	<?php createLibs(['jquery', 'swiper', 'layui']);?>
	<?php insertJS('main'); ?>
	<?php insertCSS('main'); ?>
</head>
<body>