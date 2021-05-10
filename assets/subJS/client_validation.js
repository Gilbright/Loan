$(function () {
    $('#addClientForm').validate({
        rules: {
            nameSurname: {
                required: true,
                minlength: 2
            },
            birthDate: {
                //customdate: true
                required: true,
                date : true,
                dateITA : true
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
            profession: {
                required: true
            },
            monthlyIncome: {
                required: true,
                number: true
            },
            address: {
                required: true
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
            confirmation: {
                required: true
            },
            validClass: "success",
            success: function(label) {
                label.addClass("valid").text("Ok!")
            }
        },
        messages: {
            nameSurname: {
                required: "Please a valid project name",
                minlength: jQuery.validator.format("At least {0} characters required!")
            },
            birthDate: {
                required: "Please write project details"
            },
            gender: "Please choose your gender",
            nationality: {
                required: "Please write your nationality",
                number: "Must be a valid number"
            },
            phoneNumber: {
                required: "Please write your phoneNumber",
                number: "Must be a valid number"
            } ,
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"
            } ,
            profession: "Please write your profession",
            monthlyIncome: {
                required: "Please write your monthlyIncome",
                number: "Must be a valid number"
            } ,
            address: "Please write your address" ,
            idNumber: {
                required: "Please write your idNumber",
                number: "Must be a valid number"
            } ,
            pieceIdentity: "Please choose your pieceIdentity",
            photoIdentity: "Please choose your photoIdentity",
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