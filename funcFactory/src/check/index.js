import Valid from '../valid';
/**
 * 各类基础的验证
 */

class Check {
  constructor() {
    // 正则库
    this.regular = {
      phone: /(^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$)|(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/,
      mail: /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
      url: /^(\w+:\/\/)?\w+(\.\w+)+.*$/
    },
    this.url = window.location.href
  }


  /**
   * 验证手机号
   * @param {string || number} number 需要验证的手机号
   * @return { null } 输入的内容为空 
   * @return { boolean } 输入的手机号码格式是否有误
   */
  isPhoneNumber (number) {
    return valid(number, this.regular.phone);
  }

  /**
   * 验证邮箱
   * @param {string} mail 需要验证的邮箱
   * @return { null } 输入的内容为空 
   * @return { boolean } 输入的邮箱格式是否有误
   */
  isEmail (mail) {
    return valid(mail, this.regular.mail);
  }

  /**
   * 验证密码格式
   * @param {string} pwd 需要验证的密码
   * @param {number} min 最小长度
   * @param {number} max 最大长度
   * @return {boolean}
   */
  password (pwd = null, min = 6, max = 16) {
    if (!pwd) return null;
    pwd = pwd.toString();
    if (pwd.length < min || pwd.length > max) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * 检查当前是否是测试环境
   * @param {string} rely 判断域名的依据
   * @return {boolean}
   */
  isDemo (rely = 'demo-') {
    if (this.url.indexOf(rely) > -1) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * 检查当前是否是本地开发环境
   * @return {boolean}
   */
  isDev () {
    if (this.url.indexOf('192.168') > -1 || this.url.indexOf('localhost') > -1 || this.url.indexOf('127.0.0.1') > -1) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * 检查当前是否为生产环境
   * @param {string} rely 判断依据，此项为必传项
   * @param {boolean} 
   */
  isProd (rely = null) {
    if (rely && this.url.indexOf(rely) > -1) {
      return true;
    } else {
      return false;
    }
  }
}

export default Check;