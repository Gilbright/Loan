$(function () {
    $('#addProjectForm').validate({
        rules: {
            projectName: {
                required: true
            },
            projectDetails: {
                required: true
            },
            amountWanted:{
                required: true,
                number: true
            },
            modalityAmount: {
                required: true,
                number: true
            },
            businessPlanDoc: {
                required: true
            },
            modalityNumberOfMonths: {
                required: true,
                number: true
            },
            confirmation: {
                required: true
            }
        },
        messages: {
            projectName: {
                required: "Please a valid project name",
            },
            projectDetails: {
                required: "Please write project details"
            },
            amountWanted: {
                required: "Please amountWanted",
                number: "Must be a valid number"
            },
            modalityAmount: {
                required: "Please modalityAmount",
                number: "Must be a valid number"
            },
            businessPlanDoc: {
                required: "Please choose your business plan document"
            }    ,
            modalityNumberOfMonths: {
                required: "Please write modalityNumberOfMonths",
                number: "Must be a valid number"
            } ,

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