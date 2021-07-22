// 该文件为生产环境
const path = require('path');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const merge = require('webpack-merge');
const commonConfig = require('./webpack.common');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

const prodConfig = {
  mode: 'production',
  // devtool: 'inline-cheap-module-source-map',
  plugins: [
    // 压缩图片的，但是加载了这个东西之后打包会变得非常慢
    new ImageminPlugin({
      test: 'images/**',
      pngquant: {
        quality: '98'
      }
    })
  ],
  optimization: {
    minimizer: [
      new OptimizeCSSAssetsPlugin({})
    ]
  },
  output: {
    filename: '[name].[contenthash:8].js',
    chunkFilename: '[name].chunk.js',
    path: path.resolve(__dirname, '../dist')
  }
}

// 融合公共的配置文件和当前文件
module.exports = merge(commonConfig, prodConfig);