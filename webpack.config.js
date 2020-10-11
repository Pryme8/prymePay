const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');

module.exports = {
    mode: 'development',
    entry: './src/index.ts',
    devtool: 'inline-source-map',
    output: {
        filename: 'pay.js',
        path: path.resolve(__dirname, 'dist/public/js'),
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                exclude: /node_modules/,
            },
        ]
    },
    optimization: {
        concatenateModules: true,
        minimize: false
    },
    plugins: [
        new CleanWebpackPlugin({            
            dry:false,
            protectWebpackAssets: false,
            cleanOnceBeforeBuildPatterns: ['../../**/*', '!static-files*'],
            dangerouslyAllowCleanPatternsOutsideProject: true
        }),
        new CopyPlugin({
            patterns: [
                {
                    from: 'src/public/**',
                    to: '../public',
                    transformPath(targetPath){                        
                        return Promise.resolve('../'+targetPath.substr(20, targetPath.length));
                    }
                },
                {
                    from: 'src/private/**',
                    to: '../../',
                    transformPath(targetPath){                        
                        return Promise.resolve('../../'+targetPath.substr(17, targetPath.length));
                    }
                }
            ]
        })   
    ],
    resolve: {
        extensions: [".tsx", ".ts", ".js"]
    },
};