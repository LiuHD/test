'use strict';
var hello = function() {
	console.log('hello module');
	console.log(module);
};

module.exports.hello = hello;