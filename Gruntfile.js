module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-cssnano');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({
        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer')({
                        browsers: ['last 2 versions']
                    }),
                    require('postcss-rtl')({
                    })
                ]
            },
            dist: {
              files: [{
                  expand: true,
                  flatten: true,
                  src: './css/src/*.*',
                  dest: './css/dist/'
              }]
            }
        },
        cssnano: {
            options: {
                safe: true,
                sourcemap: false
            },
            dist: {
                files: {
                    './css/colornews.print.min.less': './css/dist/colornews.print.css'
                }
            }
        },
        watch: {
            css: {
                files: './css/src/*.*',
                tasks: ['postcss','cssnano'],
            }
        }
    });

    grunt.registerTask('default', ['postcss','cssnano','watch']);
};
