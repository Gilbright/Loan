$(function () {
    $('#savePaymentForm').validate({
        rules: {
            dropdownName:{
                required: true,
            },
            amount: {
                required: true,
                number: true
            },
            financeDetailDoc: {
                required: true
            },
            paymentDetails: {
                required: true
            },
            validClass: "success",
            success: function(label) {
                label.addClass("valid").text("Ok!")
            }
        },
        messages: {
            dropdownName: "Choisisser le type de depense",
            amount: {
                required: "vous devez ajouter le montant a payer",
                number: "Must be a valid number"
            },
            financeDetailDoc: {
                required: "Ajouter un document justificatif"
            } ,
            paymentDetails: {
                required: "Ajouter le detail du payment"
            }
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