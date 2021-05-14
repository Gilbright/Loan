import './styles/form_validation.scss'

import 'admin-lte/plugins/jquery/jquery.min.js'
import 'admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js'

$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});
