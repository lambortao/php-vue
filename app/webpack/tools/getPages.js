// 获取pages下的子文件
const fs = require('fs');
let entry = {
  main: './public/index.js'
};
const staticPath = './public/js/pages';

if (fs.existsSync(staticPath)) {
  const readDir = fs.readdirSync(staticPath);
  readDir.forEach(element => {
    let pagesKey = element.split('.pages.js')[0];
    if (/.*\.pages.js/.test(element)) {
      entry[pagesKey] = `${staticPath}/${element}`
    }
  });
}

module.exports = entry;