/**
 * 基础验证函数
 * @param {string || number} event 需要验证的内容
 * @param {regular} regular 需要匹配的正则式
 */

 const Valid = (event, regular) => {
  if (event) {
    if (regular.test(event)) {
      return true;
    } else {
      return false;
    }
  } else {
    return null;
  }
}
export default Valid