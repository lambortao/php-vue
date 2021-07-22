class Get {
  constructor() {
    
  }

  /**
   * 获取随机数
   * @param {number} min 最小数
   * @param {number} max 最大数
   * @return {number} 生成的随机数
   */
  random(min = 0, max = 10) {
    return Math.round(Math.random() * (max - min)) + min;
  }

  /**
   * 获取URL参数
   * @param {srting} name 需要获取的URL参数
   * @return {string} 获取到的URL参数
   */
  GetQueryString(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r !== null)return  unescape(r[2]); return null;
  }
}

export default Get;