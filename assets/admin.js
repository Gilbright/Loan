import Stepper from "bs-stepper";

const $ = require('jquery');

require('bootstrap');

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
require('bs-stepper')

document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
});

import './styles/adminlte.scss';


