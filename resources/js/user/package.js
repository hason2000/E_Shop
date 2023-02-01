window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
    require("bootstrap3");
    require("owl.carousel");
    Swal = require('sweetalert2');
    require("sweetalert2");
    require("select2");
} catch (error) {
    console.log(error);
}
