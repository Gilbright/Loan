
import 'jquery/dist/jquery.min.js'
import 'admin-lte/plugins/datatables/jquery.dataTables.min.js'
import 'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'
import 'admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js'
import 'admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'
import 'admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js'
import 'admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'
import 'admin-lte/plugins/jszip/jszip.min.js'
import 'admin-lte/plugins/pdfmake/pdfmake.min.js'
import 'admin-lte/plugins/pdfmake/vfs_fonts.js'
import 'admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js'
import 'admin-lte/plugins/datatables-buttons/js/buttons.print.min.js'
import 'admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js'

import './styles/datatable.scss'

$(function () {
    $('#projectTableId').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});

$(function () {
    $('#financialReportTableId').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});