import Stepper from "bs-stepper";

const $ = require('jquery');

require('bootstrap');

import './adminlte'
import './styles/adminlte.scss';
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

require('jquery/dist/jquery.min.js')
require('jquery-validation/dist/jquery.validate.min.js')

require('jquery-validation/dist/additional-methods.min.js')

require('jquery-knob/dist/jquery.knob.min.js')
//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
$('[data-mask]').inputmask();

//bs-custom input file for upload
module.exports = function () {
    bsCustomFileInput.init();
};

$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            alert( "Form successful submitted!" );
        }
    });
    $('#projectForm').validate({
        rules: {
            projectName: {
                required: true
            },
            projectDetails: {
                required: true
            },
            amountWanted:{
                required: true
            },
            modalityAmount:{
                required: true
            },
            modalityNumberOfMonths:{
                required: true
            },
            confirmation: {
                required: true
            },
        },
        messages: {
            confirmation: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});