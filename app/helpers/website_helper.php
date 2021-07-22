<?php
  /**
   * 变量值对应的分辨率
   * xs <  768px
   * sm >= 768px
   * md >= 992px
   * lg >= 1200px
   * xl >= 1920px
   * @param String $how 
   */
  function responsive($how = 'xs') {
    return array(
      "xs" => 768,
      "sm" => 992,
      "lg" => 1200,
      "xl" => 1920
    )[$how];
  }

  /**
   * 生成栅格行，一般用来包裹栅格列
   * @param number $gutter 槽，即设置在被包裹的列上的外边距，从 1～30
   */
  function createRow($gutter = 0) {
    
  }

  /**
   * 验证数字是否符合规范，如果超过规定值则返回最小或最大值
   * @param number $number 接受的数字
   * @param number $min 最小值，如果小于该值则返回该值
   * @param number $max 最大值，如果大于该值则返回该值
   * @return number 验证后的数字
   */
  function checkNumber($number = null, $min = null, $max = null) {
    $number = $number < $min ? $min : $number;
    $number = $number > $max ? $max : $number;
    return $number;
  }

  /**
   * 生成栅格列，一般是包裹在栅格行内
   * @param number $span 当前元素的占宽，从1～24
   * @param number $offset 当前元素对于左侧的位移，从0～24
   * @param String $hide 在哪种分辨率下，隐藏当前元素，具体参数详见第二行注释
   * @param Array $responsive 响应式的布局，接受一个数组，里面需以 xs,sm,md,lg,xl 为key 设置五种的占比
   * @return String 输出的都是HTML标签对
   */
  function createCol($span = 0, $offset = 0, $hide = false, $responsive = array()) {
    // 因为所有的参数都是可选的，如果没有传入参数的话，默认返回 div 的闭合标签
    $funcNumber = func_num_args();
    if ($funcNumber == 0) {
      return '</div>';
    } else {
      // 要验证参数的正确性
      $span = checkNumber($span, 1, 24);
      $spanClassName = '';
      $offset = checkNumber($offset, 0, 24);
      $offsetClassName = '';
      // 生成隐藏的内容
      if ($hide && isset($hideArr[$hide])) {
        $hideArr = array(
          '==xs' => 'hidden-xs-only',
          '==sm' => 'hidden-sm-only',
          '<=sm' => 'hidden-sm-and-down',
          '>=sm' => 'hidden-sm-and-up',
          '==md' => 'hidden-md-only',
          '<=md' => 'hidden-md-and-down',
          '>=md' => 'hidden-md-and-up',
          '==lg' => 'hidden-lg-only',
          '<=lg' => 'hidden-lg-and-down',
          '>=lg' => 'hidden-lg-and-up',
          '==xl' => 'hidden-xl-only'
        );
        $hideClassName = $hideArr[$hide];
      } else {
        $hideClassName = '';
      }
      // 检查响应式数组是否为空，并且验证数组的 key 值
      if (is_array($responsive) && count($responsive) > 0) {
        $responsiveClassName = '';
      } else {
        $responsiveClassName = false;
      }

      // 生成 span 的类名
      $spanClassName = 'el-col el-col-'.$span;
      // 生成 offset 的类名
      $offsetClassName = 'el-col-offset-'.$offset;
      // 生成响应式的类名
      // TODO: 这里碰到一个情况，就是饿了么官方在这里默认添加了 el-col-24,但是我们这里是不是不需要添加这个类名？如果不需要加这个类名的话，则需要强制要求 $span 参数不能为空
      $responKeyArr = array('xs', 'sm', 'md', 'lg', 'xl');
      if (!$responsiveClassName) {
        foreach ($responsive as $key => $value) {
          if (in_array($key, $responKeyArr)) {
            $responsiveClassName .= 'el-col-'.$key.'-'.$value.' ';
          }
        }
      }

      $endLabel = '<div class="'.$spanClassName.' '.$offsetClassName.' '.$hideClassName.' '.$responsiveClassName.'">';
      return $endLabel;
    }
  }

  /**
   * 生成随机字符串
   */
  function generateRandomString($length = 10) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
    for ($i = 0; $i < $length; $i++) { 
        $randomString .= $characters[rand(0, strlen($characters) - 1)]; 
    } 
    return $randomString; 
  }

  /**
   * 快速生成响应式的列表结构
   * @param Array $structure 在指定的分辨率下，列表一行展示几列
   * @param number $margin 子元素的相隔边距
   * @param String $hide 在哪种分辨率下，隐藏当前元素，具体参数详见第二行注释
   */
  function createList($structure = array(), $padding = 20, $hide = false) {
    $funcNumber = func_num_args();
    if ($funcNumber == 0) {
      return '</div>';
    } else {
      if (is_array($structure) && count($structure) > 0) {
        // 生成一个新的唯一的类名
        $newClassName = 'create-list-'.generateRandomString();
        // 根据传入的自适应内容来生成对应的类名
        $responKeyArr = array('xs', 'sm', 'md', 'lg', 'xl');
        $responsiveClassName = '';
        $errorData = false;
        foreach ($structure as $key => $value) {
          if (in_array($key, $responKeyArr)) {
            $columnYu = 24 % $value;
            if ($columnYu === 0) {
              $column = 24 / $value;
              $responsiveClassName .= 'el-col-'.$key.'-'.$column.' ';
            } else {
              $errorData = true;
              echo '<script>console.error("列表生成 -> 一行不能生成'.$value.'列，请填写能被24整除的数字！")</script>';
            }
          }
        }
        if ($errorData) {
          return;
        }
        // 生成隐藏的内容
        $hideArr = array(
          '==xs' => 'hidden-xs-only',
          '==sm' => 'hidden-sm-only',
          '<=sm' => 'hidden-sm-and-down',
          '>=sm' => 'hidden-sm-and-up',
          '==md' => 'hidden-md-only',
          '<=md' => 'hidden-md-and-down',
          '>=md' => 'hidden-md-and-up',
          '==lg' => 'hidden-lg-only',
          '<=lg' => 'hidden-lg-and-down',
          '>=lg' => 'hidden-lg-and-up',
          '==xl' => 'hidden-xl-only'
        );
        if ($hide && isset($hideArr[$hide])) {
          $hideClassName = $hideArr[$hide];
        } else {
          $hideClassName = '';
        }
        $paddingDom = '';
        if ($padding !== false && $padding !== null && $padding !== 0) {
          $newPadding = $padding / 2;
          $paddingDom = '
            $(".'.$newClassName.'").css({
              "margin-left": "-'.$newPadding.'px",
              "margin-right": "-'.$newPadding.'px"
            });
            createLayoutBox.css({
              "padding-left": "'.$newPadding.'px",
              "padding-right": "'.$newPadding.'px",
              "opacity": 1
            });
          ';
        }
        echo '
          <script>
            window.onload = function() {
              var createLayoutBox = $(".'.$newClassName.'").children("div.layout-box");
              createLayoutBox.addClass("'.$responsiveClassName.'");
              '.$paddingDom.'
            }
          </script>
          <div class="'.$hideClassName.' '.$newClassName.' clear-both">
        ';
      } else {
        echo '<script>console.error("列表生成 -> 分列的数组不能为空")</script>';
      }
    }
  }

  /**
   * 快捷加载已经集成的第三方库
   * @param array $libs 需要加载的第三方库
   * @return string 输出的是 link 或者 script 标签对
   */
  function createLibs($libs = null) {
    /**
     * 现在要加载的有
     * jQuery
     * loadsh
     * swiper
     * qrcode
     */
    if ($libs == null) return;
    $rootPath = 'app/public/libs/';
    $libsArr = array(
      'jquery' => array(
        'js' => base_url($rootPath."js/jquery-1.11.3.min.js")
      ),
      'lodash' => array(
        'js' => base_url($rootPath."js/lodash-1.8.3.min.js")
      ),
      'lazyload' => array(
        'js' => base_url($rootPath."js/lazyload.min.js")
      ),
      'layui' => array(
        'js' => base_url($rootPath."js/layui/layui.all.js")
      ),
      'swiper3' => array(
        'js' => base_url($rootPath."js/swiper-3.4.0.min.js"),
        'css' => base_url($rootPath."css/swiper-3.4.0.min.css")
      ),
      'swiper4' => array(
        'js' => base_url($rootPath."js/swiper-4.5.1.min.js"),
        'css' => base_url($rootPath."css/swiper-4.5.1.min.css")
      )
    );
    // 循环传入的关键字数组
    $output = null;
    for ($i=0; $i < count($libs); $i++) {
      // 强制转小写
      $libs[$i] = strtolower($libs[$i]);
      // 模糊筛选
      $libs[$i] = $libs[$i] == 'swiper' ? 'swiper3' : $libs[$i];
      if (array_key_exists($libs[$i], $libsArr)) {
        $nowArray = $libsArr[$libs[$i]];
        foreach($nowArray as $key => $value) {
          if ($key == 'js') {
            $output .= "<script src='{$value}'></script>";
          } else if ($key == 'css') {
            $output .= "<link rel='stylesheet' href='{$value}'></link>";
          }
        }
      }
    }
    echo $output;
  }

  /**
   * 微信分享库
   * @param string $shareTitle 分享标题
   * @param string $shareImg 分享图片
   * @param string $shareContent 分享主题内容
   * @param array $share 分享的权限列表 
   * @return 微信 jssdk 库和 config 基础配置
   * 
   * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/JS-SDK.html#10
   * 微信 jssdk 从1.4.0开始支持以下接口
   * updateAppMessageShareData => “分享给朋友”及“分享到QQ”
   * updateTimelineShareData => “分享到朋友圈”及“分享到QQ空间”
   * 原有的 onMenuShareTimeline、onMenuShareAppMessage、onMenuShareQQ、onMenuShareWeibo 即将废弃
   */
  function wxShare($shareTitle = null, $shareImg = null, $shareContent = null, $share = null) {
    // echo "<script>".$pyq."()</script>";
  }

  /**
   * 快速生成行内样式的背景图
   * @param string $path 图片的路径
   * @return string 行内样式的背景图
   */
  function createBg($path = null) {
    if ($path != null) {
      $imgPath = base_url($path);
      echo 'style="background-image: url('.$imgPath.');"';
    }
  }

  /**
   * 快速生成 img 标签对
   * @param string $path 图片的路径
   * @param string $className 需要添加的类名，如果有多个类名则使用空格分割
   * @param string $alt 图片的占位信息
   * @return string img 标签对
   */
  function createImg($path = null, $loading = true, $className = null, $alt = false) {
    $okClass = null;
    if ($className != null) {
      $okClass = 'class="'.$className.'"';
    }
    $alt = $alt ? 'alt="'.$alt.'"' : null;
    if ($path != null) {
      $imgPath = base_url($path);
      if ($loading) {
        $src = 'lay-src';
      } else {
        $src = 'src';
      }
      echo '<img '.$alt.' '.$okClass.' '.$src.'="'.$imgPath.'">';
    }
  }

  /**
   * 快速生成懒加载图片的 js 函数
   */
  function createImgFunc() {
    echo '
      <script>
        window.onload = function() {
          layui.use("flow", function() {
            var flow = layui.flow;
            flow.lazyimg();
          });
        }
      </script>
    ';
  }

  /**
   * 快速生成 a 标签
   * @param string $link 链接地址，如果是外链则需要加 https 或 http 或 www
   * @param string $content 链接名
   * @param string $className 需要添加的类名，如果有多个类名则使用空格分割
   * @param boolean $target 是否新建标签页，默认否
   * @return string a 标签
   */
  function createLink($link = null, $content = null, $className = null, $target = false) {
    $okClass = null;
    if ($className != null) {
      $okClass = 'class="'.$className.'"';
    }
    $target = $target ? 'target="_black"' : null;
    if ($link != null) {
      // 判断传入的链接是否是外部链接
      $linkPath = null;
      if (strstr($link, 'http') || strstr($link, 'www')) {
        $linkPath = $link;
      } else {
        $linkPath = site_url($link);
      }
      echo '<a '.$okClass.' href="'.$linkPath.'" '.$target.' >'.$content.'</a>';
    }
  }

  /**
   * 快速生成 icon 
   * 会自动检查 app/public/image/icon 这个目录下的所有icon
   * @param string $icon icon的名称
   * @param number $width icon的宽度
   * @param number $height icon的高度
   * @param string $className 需要添加上的class
   * @return string i 标签
   */
  function createIcon($icon = null, $className = null, $width = 20, $height = 20) {
    $iconFile = false;
    // 检查 icon 参数
    if ($icon != null || $icon != false) {
      // 现在已有的 icon 列表
      $file = scandir(substr(dirname(__FILE__), 0, (strlen(dirname(__FILE__)) - 8)).'/public/images/icon');
      foreach ($file as $key => $value) {
        if (preg_match('/.jpg|.png|.gif/', $value)) {
          if (strpos($value, $icon) !== false) {
            $iconFile = base_url('app/public/images/icon/').$value;
            break;
          }
        }
      }
    }
    // 检查 class 参数
    $okClass = null;
    if ($className != null) {
      $okClass = 'class="'.$className.'"';
    }
    // 生成结果
    if ($iconFile) {
      echo '
        <i '.$okClass.' style="display: inline-block; width: '.$width.'px; height: '.$height.'px">
          <img width="100%" height="100%" src="'.$iconFile .'" />
        </i>
      ';
    } else {
      echo '<script>console.error("icon生成 - 传入的 '.$icon.' 参数有误")</script>';
    }
  }
?>