module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      dist: {
        files: {
          'public/css/main.css' : 'app/sass/main.scss',
          'public/css/plugins.css' : 'app/sass/plugins.scss'
        }
      }
    },
    concat: {
      plugins: {
        src: [
          'app/scripts/plugins/modernizr/modernizr.js',
          'app/scripts/plugins/foundation/js/foundation.js',
        ],
        dest: 'public/js/plugins.js'
      },
      main: {
        src: [
          'app/scripts/app.js',
          'app/scripts/votes.js',
          'app/scripts/follow.js',
        ],
        dest: 'public/js/main.js'
      }
    },
    uglify: {
      main: {
          files: { 
              'public/js/plugins.min.js': ['public/js/plugins.js'],
              'public/js/main.min.js': ['public/js/main.js']
          }
      }
    },
    watch: {
      css: {
        files: ['app/sass/**/*.scss'],
        tasks: ['sass'],
        options: {
          livereload: true
        }
      },
      js: {
        files: ['app/scripts/**/*.js'],
        tasks: ['concat', 'uglify'],
        options: {
          livereload: true
        }
      },
      php: {
        files: ['app/**/**/**/**/*.php'],
        tasks: [],
        options: {
          livereload: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default',['watch']);
}