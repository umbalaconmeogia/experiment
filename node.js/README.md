# Node.js memo

## Two way to export a module

1. Use exports command (Export Object)
  ```javascript
  exports.log = {
      console: function(msg) {
          console.log(msg);
      },
      file: function(msg) {
          // log to file here
        }
  }
  ```
2. Use module.exports (Export Literals)
  ```javascript
  // Log.js module
  var log = {
      info: function (info) { 
          console.log('Info: ' + info);
      },
      warning:function (warning) { 
          console.log('Warning: ' + warning);
      },
      error:function (error) { 
          console.log('Error: ' + error);
      }
  };

  module.exports = log
  
  // Usage
  var myLogModule = require('./Log.js');
  myLogModule.info('Node.js started');
  ```