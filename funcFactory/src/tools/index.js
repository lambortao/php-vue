/**
 * 各类方法类函数集合
 */

class Tools {
  constructor() {
    
  }

  /**
   * 计时
   * @param {number} start 开始时间
   * @param {number} end 结束时间
   * @param {number} time 间隔的时间
   * @param {boolean} type 是递增还是递减，默认为递减
   * @param {function} every 每一次间隔时间结束后的回调
   * @param {function} callback 倒计时结束后的回调
   */
  countDown(start = 60, end = 0, time = 1000, type = false, every = function(){}, callback = function(){}) {
    if (start === end) {
      console.error('开始时间和结束时间相同');
      return;
    }
    // 如果是递减的话，那么开始数字一定要大于结束数字
    if (!type) {
      if (start <= end) {
        console.error('递减操作时，开始时间必须要大于结束时间');
        return;
      }
    } else if (type) {
      if (start >= end) {
        console.error('递增操作时，结束时间必须要大于开始时间');
        return;
      }
    }
    const timeFunc = (start) => {
      every(start);
      setTimeout(() => {
        if (type) {
          start ++;
        } else {
          start --;
        }
        if (start === end) {
          callback();
        } else {
          timeFunc(start);
        }
      }, time)
    }
    timeFunc(start);
  }
}

export default Tools;