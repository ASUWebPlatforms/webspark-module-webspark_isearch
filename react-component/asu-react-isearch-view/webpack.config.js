// ./webpack.config.js
const HtmlWebPackPlugin = require( 'html-webpack-plugin' );
const path = require( 'path' );

module.exports = {
  mode: "development",
  entry: {
    drupalIsearchViewer: "./src/indexDrupal.js",
    wpIsearchViewer: "./src/indexWordpress.js",
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: '[name].js',
    publicPath: '/',
  },
  devServer: {
    historyApiFallback: true,
    hot: true
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: "babel-loader"
      },
      {
        test: /\.css$/,
        use: [
          'style-loader',
          'css-loader'
        ]
      }
    ]
  },
  plugins: [
    new HtmlWebPackPlugin({
      template: path.resolve( __dirname, 'public/drupal.html' ),
      filename: 'drupal.html',
      inject: false,
      hash: true,
    }),
    new HtmlWebPackPlugin({
      template: path.resolve( __dirname, 'public/wordpress.html' ),
      filename: 'wordpress.html',
      inject: false,
    })
  ],
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/](react|react-dom)[\\/]/,
          name: 'vendor',
          chunks: 'all',
        },
      },
    },
  },
};