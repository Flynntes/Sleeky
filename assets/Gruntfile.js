module.exports = function (grunt) {
    grunt.initConfig({

        // compress compiled files
        cssmin: {
            "css/base.css": ["css/base.css"],
            "css/desktop.css": ["css/desktop.css"],
            "css/tablet.css": ["css/tablet.css"],
            "css/mobile.css": ["css/mobile.css"]
        },

        // watch changes to less files
        watch: {
            styles: {
                files: ["less/*"],
                tasks: ["less", "cssmin"]
            }
        },

        // compile set less files
        less: {
            compile: {
                options: {
                    paths: ["less"]
                },
                files: {
                    "css/base.css": "less/base.less",
                    "css/desktop.css": "less/desktop.less",
                    "css/tablet.css": "less/tablet.less",
                    "css/mobile.css": "less/mobile.less"
                }
            }
        },

    });

    // Load tasks so we can use them
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-cssmin");
    grunt.loadNpmTasks("grunt-contrib-less");

    // the default task will show the usage
    grunt.registerTask("default", "Prints usage", function () {
        grunt.log.writeln("");
        grunt.log.writeln("Using Base");
        grunt.log.writeln("------------------------");
        grunt.log.writeln("");
        grunt.log.writeln("* run 'grunt --help' to get an overview of all commands.");
        grunt.log.writeln("* run 'grunt dev' to start watching and compiling LESS changes.");
    });

    grunt.registerTask("dev", ["less:compile", "watch:styles"]);
};
