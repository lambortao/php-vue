import Valid from '../valid';
// 判断设备

class Device {
  constructor() {
    this.ua = navigator.userAgent.toLowerCase(),
    // 设备和浏览器标识
    this.deviceRegular = {
      isAnroid: /Android/,
      isIos: /iPhone|iPad|iPod|iOS/,
      isIpad: /iPad/,
      isXiaomi: /mi\s+/,
      isHuawei: '',
      isUC: /ucbrowser/,
      isWx: /micromessenger/,
      isChrome: /chrome/,
      isSafari: /safari/,
      isFirefox: /firefox/,
      isIe: /msie/,
      isEdge: /msie/
    }
    for (const key in this.deviceRegular) {
      if (this.deviceRegular.hasOwnProperty(key)) {
        this[key] = () => Valid(this.ua, this.deviceRegular[key]);
      }
    }
  }
}

export default Device;