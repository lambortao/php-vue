<?php $this->load->view("include/header");?>
<div id="root"></div>
<div class="home">
  <?= createRow($gutter="20"); ?>
    <?= createCol(5, 3, false, array('xs'=>4,'md'=>18)); ?>
      <div class="layout-box"></div>
    <?= createCol();?>
  <?= createRow($close=true); ?>
</div>
<div>
  <img lay-src="https://ashley.cn/app/public/images/style/5/2.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/5/3.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/5/4.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/5/5.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/5/7.jpg">
  <img lay-src="https://ashley.cn/app/public/images/home/style-4.jpg">
  <img lay-src="https://ashley.cn/app/public/images/home/style-3.jpg"> 
  <img lay-src="https://ashley.cn/app/public/images/home/style-2.jpg">
  <img lay-src="https://ashley.cn/app/public/images/home/style-1.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/3/2.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/3/3.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/3/4.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/3/5.jpg">
  <img lay-src="https://ashley.cn/app/public/images/style/3/7.jpg">
</div>
<?php createList(array('xs'=>2,'sm'=>4, 'md'=>6, 'lg'=>12), 10);?>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
   <div class="layout-box">
     <div></div>
   </div>
 <?php createList();?>
 <!-- <?php createImg('app/public/images/icon/add.png', false, 'icon', '这是一个icon');?> -->
 <?php createIcon('add');?>
<?php insertJS(basename(__FILE__, '.php')); ?>
<?php $this->load->view("include/footer");?>