// 该文件为开发环境
const path = require('path');
const merge = require('webpack-merge');
const commonConfig = require('./webpack.common');

const devConfig = {
  mode: 'development',
  devtool: 'cheap-module-eval-source-map',
  // 本地服务
  devServer: {
    contentBase: '../dist',
    // hot: true
  },
  output: {
    filename: '[name].[hash:8].js',
    chunkFilename: '[name].js',
    path: path.resolve(__dirname, '../dist')
  }
}

module.exports = merge(commonConfig, devConfig);