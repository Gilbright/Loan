/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/phenix_base.scss';

// start the Stimulus application
import './bootstrap';

import 'bootstrap-select-country/dist/js/bootstrap-select-country.min.js'
import 'admin-lte/dist/js/adminlte.min.js'
import 'admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');


/*
//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
$('[data-mask]').inputmask();

//bs-custom input file for upload
module.exports = function () {
    bsCustomFileInput.init();
};
*/

