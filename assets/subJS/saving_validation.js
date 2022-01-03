$(function () {
    $('#addSavingForm').validate({
        rules: {
            IdNumber: {
                required: true,
            },
            type:{
                required: true,
            },
            month: {
                required: true
            },
            amount: {
                required: true,
                number: true
            },
            proofDocument: {
                required: true,
            },
            details: {
                required: true
            },
            validClass: "success",
            success: function(label) {
                label.addClass("valid").text("Ok!")
            }
        },
        messages: {
            IdNumber: "Please write your idNumber",
            type: "Please choose a type",
            month: {
                required: "Please write the month"
            },
            amount: {
                required: "Please write the amount",
                number: "Must be a valid number"
            } ,
            proofDocument: "Please choose your pieceIdentity",
            details: "Please enter a detail",
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