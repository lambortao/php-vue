/**
 * 瀑布流插件
 * fatherEl: 瀑布流元素的父级盒子，为必须项，子元素必须为DIV
 * bottomMargin: 瀑布流元素的下边距，非必须项，单位是像素，默认是10px
 * columns: 瀑布流元素列数，非必须项，默认是3列
 * sonWidth: 瀑布流元素的宽度，非必须项，单位是百分比，默认是32%
 * 瀑布流元素列数 * 瀑布流元素的宽度不能超过100
 */
const waterfallsFlow = function (e) {
  if (!e.fatherEl) {
    console.log('父级目录未定义！');
    return
  }
  if (e.columns * e.sonWidth > 100) {
    console.log('子元素的列数和宽度不合理！');
    return;
  }
  /**
   * 设置计算会使用到的变量
   * height存放的是每个子元素的高度
   * top存放的是每个子元素的top值
   * nowRow是当前循环到第几行了
   * maxHeight是父元素的最大高度
   * nowIndex是循环到哪个元素了
   * columns是列数
   * sonW是子元素的宽度，单位为百分比
   */
  let calcData = {
    height: [],
    top: [],
    nowRow: 0,
    maxHeight: 0,
    nowIndex: 0,
    columns: e.columns || 3,
    sonW: e.sonWidth || 32,
  }
  /**
   * 元素数据
   * sonMarginRight为子元素的右边距
   * sonMarginBottom为子元素的下边距
   */
  let eventData = {
    sonMarginRight: (100 - (calcData.columns * calcData.sonW)) / (calcData.columns - 1),
    sonMarginBottom: e.bottomMargin || 10
  }
  // 获取父级元素
  this.fatherEl = e.fatherEl;
  // 获取子元素及数量
  this.sonEls = this.fatherEl.childNodes;
  this.sonElNumber = this.fatherEl.children.length;
  
  // 给父级元素和子元素设置css属性
  this.fatherEl.style.position = 'relative';
  this.sonEls.forEach(element => {
    // 筛选 div 元素
    if (element.nodeName === 'DIV') {
      // 设置当前元素的css
      element.setAttribute('style', `position: absolute; width: ${calcData.sonW}%`)
      // 将当前元素的高度存入子元素高度数组
      calcData.height.push(element.offsetHeight);
      // 用余数来判断当前是第几列，从0开始
      let nowColumns = calcData.nowIndex % calcData.columns;
      // 给当前元素设置left，值为当前列乘以右边距加上当前列乘以子元素宽度
      element.style.left = `${(nowColumns * eventData.sonMarginRight) + (nowColumns * calcData.sonW)}%`; 

      /**
       * nowElTop是当前元素的top值
       * prevBorderElIndex是当前元素的上面一个兄弟元素的index值
       */
      let nowElTop;
      let prevBorderElIndex = calcData.nowIndex - calcData.columns;
      // 判断当前是是不是第一行，如果当前元素的上面一个兄弟元素的index值为负数说明还在第一行
      if (prevBorderElIndex < 0) {
        // 是第一行的元素，top值为0
        nowElTop = 0;
      } else {
        // 不是第一行元素，top上面一个兄弟元素的高度 + 上面一个兄弟元素的top值 + 行间距
        nowElTop = calcData.height[prevBorderElIndex] + calcData.top[prevBorderElIndex] + eventData.sonMarginBottom;
      }
      // 设置当前元素的top值
      element.style.top = `${nowElTop}px`;
      // 将当前元素的top值存入数组
      calcData.top.push(nowElTop);
      /**
       * 计算父级元素的最大高度
       * 判断当前元素的top加上当前元素的高度是否大于预存的父级元素的最大高度，如果大于则更新该值
       */
      let nowElTopHeight = nowElTop + element.offsetHeight;
      if (nowElTopHeight > calcData.maxHeight) {
        calcData.maxHeight = nowElTopHeight;
      }
      // 循环元素加一
      calcData.nowIndex ++;
    }
  });
  // 设置让父元素显示出来并且设置高度
  this.fatherEl.setAttribute('style', `opacity: 1; height: ${calcData.maxHeight}px`);
}