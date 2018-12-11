const express = require('express');
const express_app = express();
const bodyParser = require('body-parser');
setup_8080();

// Functions ++++++++++++++++++++++++++++++
function setup_8080() {
    const mod_http = require('http');

    //Set static base url for all inline refs (stylesheets, js)
    express_app.use(express.static("frontend"));
    //enable json data body parsing
    express_app.use(bodyParser.json());
    express_app.use(bodyParser.urlencoded({
        extended: true
    }));

    //Render engine
    express_app.engine('html',require('ejs').renderFile);
    express_app.set('view engine','html');
    express_app.set('views', require('path').join(__dirname, '../frontend/html'));

    /*file mgr setup
    let dir = process.cwd();
    express_app.use(express.static(dir)); //current working dir
    express_app.use(express.static(__dirname)); //module dir

    express_app.get('/component/file_mgr', function (req, res) {
        var currentDir =  dir;
        var query = req.query.path || '';
        if (query) currentDir = path.join(dir, query);
        console.log("browsing ", currentDir);
        fs.readdir(currentDir, function (err, files) {
            if (err) {
                throw err;
            }
            var data = [];
            files
                .forEach(function (file) {
                    try {
                        //console.log("processingile);
                        var isDirectory = fs.statSync(path.join(currentDir,file)).isDirectory();
                        if (isDirectory) {
                            data.push({ Name : file, IsDirectory: true, Path : path.join(query, file)  });
                        } else {
                            var ext = path.extname(file);
                            if(program.exclude && _.contains(program.exclude, ext)) {
                                console.log("excluding file ", file);
                                return;
                            }
                            data.push({ Name : file, Ext : ext, IsDirectory: false, Path : path.join(query, file) });
                        }

                    } catch(e) {
                        console.log(e);
                    }

                });
            data = _.sortBy(data, function(f) { return f.Name });
            res.json(data);
        });
    });
    //file mgr setup end*/

    console.log('server.js:setup_8080: Port 8080 setup done.');
    return mod_http.createServer(express_app).listen(8080);
}




// Export to other files (to export multiple see: https://stackoverflow.com/questions/8595509/how-do-you-share-constants-in-nodejs-modules)
module.exports = express_app;
