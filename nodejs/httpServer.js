'use strict';
var http = require('http');
var fs = require('fs');
var url = require('url');
var path= require('path');
var $ = require('./hello');
var root = path.resolve(process.argv[2] || '.');
$.hello();
var server = http.createServer(function(request, response) {
	var filePath = path.join(root, url.parse(request.url).pathname);
	fs.stat(filePath, function(err, stats) {
		if(!err) {
			if(stats.isFile()) {
				response.writeHead(200);
				fs.createReadStream(filePath).pipe(response);
				console.log('200 ' + request.url);	
			} else {
				var newPath = path.join(filePath, 'index.html');
				fs.stat(newPath, function(err, stats) {
					fs.createReadStream(newPath).pipe(response);
					console.log('200 ' + request.url);	
				});
			}
		} else{
			response.writeHead(404);
			console.log('404 ' + request.url);
		}
	});
});
server.listen('80');