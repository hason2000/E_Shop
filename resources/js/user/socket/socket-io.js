window._ = require('lodash');

try {
    io = require("socket.io-client")
} catch (error) {
    console.log(error);
}
