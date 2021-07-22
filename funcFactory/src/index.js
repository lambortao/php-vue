import './index.scss';
import "regenerator-runtime/runtime";
import Check from './check'
import Get from './get';
import Device from './device'
import Tools from './tools'
// import isMobile from 'ismobilejs';
// const obile = new isMobile();
// console.log(obile);
let tools = new Tools;
let get = new Get;
let device = new Device;
console.log(get.random());
// 倒计时
// tools.countDown(100, 0, 100, false, function(e) {
//   console.log(e);
// }, function() {
//   console.log('done');
// });

// console.log(device.isSafari());