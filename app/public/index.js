/**
 * 此文件是 webpack 的入口打包文件，请勿删除
 * 引入的第一个 index.scss 是 scss 文件的入口文件，请勿删除
 */
import './scss/index.scss'
// 如果需要兼容低版本浏览器的话（IE8），则需要引入下面的包，文件会被打包到 vendors~**~.chunk.js 中
import "core-js/stable";
import "regenerator-runtime/runtime";
// 插件的总入口
import './js/components'