import Stepper from "bs-stepper";

const $ = require('jquery');

require('bootstrap');

import './css/admin.scss';
import bsCustomFileInput from "bs-custom-file-input";
require('bootstrap/js/dist/popover');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('summernote');
require('icheck-bootstrap');
require('overlayscrollbars');
require('daterangepicker');
require('jquery-ui');
require('chart.js');
require('moment');
require('ionicons')

require('inputmask/dist/jquery.inputmask.min.js')

require('bs-custom-file-input/dist/bs-custom-file-input.min.js');

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
$('[data-mask]').inputmask();

//bs-custom input file for upload
module.exports = function () {
    bsCustomFileInput.init();
};

