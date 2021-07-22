// 基础函数

// 防抖函数
var throttle = function(fn, delay){
  var timer = null;
  return function(){
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function(){
      fn.apply(context, args);
    }, delay);
  };
};

// 回到顶部
var BackTop = function(option) {
  option = option || {};
  // 回到顶部的时间
  this.time = option.time || 500;
  // 定义显示的 icon
  this.icon = (!option.icon || option.icon > 4 || option.icon <= 0) ? 1 : option.icon;
  // 获取 dom 元素
  this.el = option.el || $('.backtop')
  // 获取窗口
  this.elBody = document.documentElement;
  // 距离顶部多少开始显示
  var topShow = option.topShow || 200;
  var thanEl = this.el;

  // 定义icon
  this.setIcon = function() {
    var iconTheme = [
      './app/public/images/components/backtop/1.png',
      './app/public/images/components/backtop/2.png',
      './app/public/images/components/backtop/3.png',
      './app/public/images/components/backtop/4.png'
    ]
    // 自定义icon的优先级优于默认主题
    var iconBg = option.bgUrl ? option.bgUrl : iconTheme[this.icon - 1];
    this.el.css('backgroundImage', 'url('+iconBg+')');
  }
  // 检测到顶部的距离
  this.onTopBool = function() {
    var scrollTop = document.documentElement.scrollTop;
    scrollTop >= topShow ? thanEl.addClass('visible') : thanEl.removeClass('visible');
  }
  // 监听滑动
  this.onScroll = function() {
    this.throttledScrollHandler = throttle(this.onTopBool, 300);
    document.addEventListener('scroll', this.throttledScrollHandler);
  }
  // 显示或隐藏返回顶部的按钮
  this.domShow = function(bool) {
    bool ? this.el.addClass('visible') : this.el.removeClass('visible');
  }
  // 回到顶部
  this.go = function() {
    var cubic = function(value) {
      return Math.pow(value, 3);
    }
    var easeInOutCubic = function(value) {
      if (value < 0.5) {
        return cubic(value * 2) / 2;
      } else {
        return 1 - cubic((1 - value) * 2) / 2;
      }
    }
    var goTopTime = this.time;
    var elBody = this.elBody;
    this.el.on('click', () => {
      var beginTime = Date.now();
      var beginValue = elBody.scrollTop;
      var rAF = window.requestAnimationFrame || function(func){return setTimeout(func, 16)};
      var frameFunc = function() {
        var progress = (Date.now() - beginTime) / goTopTime;
        if (progress < 1) {
          elBody.scrollTop = beginValue * (1 - easeInOutCubic(progress));
          rAF(frameFunc);
        } else {
          elBody.scrollTop = 0;
        }
      };
      rAF(frameFunc);
    })
  }
  this.init = function() {
    this.onScroll()
    this.setIcon()
    this.go()
  }
  this.init()
}