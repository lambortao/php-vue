const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const PhpWebpackPlugin = require('./plugins/php-webapck-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const webpack = require('webpack');
const entry = require('./tools/getPages');

module.exports = { 
  entry,
  module : {
    rules: [
      {
        test: /\.(jpg|png|gif)$/,
        use: {
          loader: 'url-loader',
          options: {
            name: '[name].[contenthash:8].[ext]',
            outputPath: 'images',
            limit: 20480
          }
        }
      },{
        test: /\.vue$/,
        loader: 'vue-loader'
      }, {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              modules: false
            }
          },
          'postcss-loader',
          'sass-loader',
        ],
      }, {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader'
        }
      }, {
        test: /\.(eot|ttf|svg)$/,
        use: {
          loader: 'file-loader'
        }
      }
    ]
  },
  optimization: {
    // 代码分割 - 其实 splitChunks 里面只需要配置一个 chunks 为 all 就行了，别的使用默认配置没什么问题
    splitChunks: {
      // 不管是异步还是同步的引入都分割代码
      chunks: 'all',
      cacheGroups: {
        vendors: {
          test: /[\\/]node_modules[\\/]/,
          priority: -10
        }
      }
    },
    usedExports: true,
    // 这里是把 webpack 的依赖运行环境提取到公共的文件
    // runtimeChunk: {
    //   name: 'runtime'
    // }
  },
  // 不显示打包过程的性能问题
  performance: false,
  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: 'style.[contenthash:8].css',
      chunkFilename: '[name].chunk.css'
    }),
    new VueLoaderPlugin(),
    new PhpWebpackPlugin({
      assetsMapPath: path.resolve(__dirname, '../views/config/map.php')
    }),
    // 如果在第三方库（node_module）里面发现了 $ 字符串，则自动加载 jQuery，否则如果第三方库如果是对jQuery有依赖的话会报错
    new webpack.ProvidePlugin({
      $: 'jquery'
    })
  ],
  performance: false
}