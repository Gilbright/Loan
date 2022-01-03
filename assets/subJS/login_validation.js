$(function () {
    $('#loginForm').validate({
        rules: {
            emailInput: {
                required: true,
                email: true,
            },
            passwordInput: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            emailInput: {
                required: "Veuillez entrer votre addresse électronique",
                email: "Veuillez entrer une addresse électronique valide"
            },
            passwordInput: {
                required: "Veuillez entrer votre mot de passe",
                minlength: "Veuillez entrer un mot de passe valide"
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