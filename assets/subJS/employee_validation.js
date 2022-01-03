$(function () {
    $('#addEmployeeForm').validate({
        rules: {
            nameSurname: {
                required: true
            },
            gender:{
                required: true,
            },
            nationality: {
                required: true
            },
            phoneNumber: {
                required: true,
                number: true
            },
            email: {
                required: true,
                email: true
            },
            idNumber: {
                required: true,
                number: true
            },
            pieceIdentity: {
                required: true
            },
            photoIdentity: {
                required: true
            },
            address: {
                required: true
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