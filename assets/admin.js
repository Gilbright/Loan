import Stepper from "bs-stepper";

const $ = require('jquery');

require('bootstrap');

import './css/admin.scss';
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

require('datatables/media/js/jquery.dataTables.min.js')
require('datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')
require('datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')

require('inputmask/dist/jquery.inputmask.min.js')
require('datatables.net-dt')();

require('bs-custom-file-input/dist/bs-custom-file-input.min.js');

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
$('[data-mask]').inputmask();

//bs-custom input file for upload
module.exports = function () {
    bsCustomFileInput.init();
};

import './styles/adminlte.scss';

$(function () {
    $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});