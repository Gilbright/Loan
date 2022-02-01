(self["webpackChunk"] = self["webpackChunk"] || []).push([["form_validation"],{

/***/ "./assets/form_validation.js":
/*!***********************************!*\
  !*** ./assets/form_validation.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_form_validation_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/form_validation.scss */ "./assets/styles/form_validation.scss");
/* harmony import */ var admin_lte_plugins_jquery_jquery_min_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! admin-lte/plugins/jquery/jquery.min.js */ "./node_modules/admin-lte/plugins/jquery/jquery.min.js");
/* harmony import */ var admin_lte_plugins_jquery_jquery_min_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(admin_lte_plugins_jquery_jquery_min_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var admin_lte_plugins_jquery_validation_jquery_validate_min_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! admin-lte/plugins/jquery-validation/jquery.validate.min.js */ "./node_modules/admin-lte/plugins/jquery-validation/jquery.validate.min.js");
/* harmony import */ var admin_lte_plugins_jquery_validation_jquery_validate_min_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(admin_lte_plugins_jquery_validation_jquery_validate_min_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var admin_lte_plugins_jquery_validation_additional_methods_min_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! admin-lte/plugins/jquery-validation/additional-methods.min.js */ "./node_modules/admin-lte/plugins/jquery-validation/additional-methods.min.js");
/* harmony import */ var admin_lte_plugins_jquery_validation_additional_methods_min_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(admin_lte_plugins_jquery_validation_additional_methods_min_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _subJS_project_validation_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./subJS/project_validation.js */ "./assets/subJS/project_validation.js");
/* harmony import */ var _subJS_project_validation_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_subJS_project_validation_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _subJS_client_validation_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./subJS/client_validation.js */ "./assets/subJS/client_validation.js");
/* harmony import */ var _subJS_client_validation_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_subJS_client_validation_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _subJS_employee_validation_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./subJS/employee_validation.js */ "./assets/subJS/employee_validation.js");
/* harmony import */ var _subJS_employee_validation_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_subJS_employee_validation_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _subJS_login_validation_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./subJS/login_validation.js */ "./assets/subJS/login_validation.js");
/* harmony import */ var _subJS_login_validation_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_subJS_login_validation_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _subJS_saving_validation_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./subJS/saving_validation.js */ "./assets/subJS/saving_validation.js");
/* harmony import */ var _subJS_saving_validation_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_subJS_saving_validation_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _subJS_save_payment_validation_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./subJS/save_payment_validation.js */ "./assets/subJS/save_payment_validation.js");
/* harmony import */ var _subJS_save_payment_validation_js__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_subJS_save_payment_validation_js__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _input_form_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./input_form.js */ "./assets/input_form.js");


var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");












/***/ }),

/***/ "./assets/input_form.js":
/*!******************************!*\
  !*** ./assets/input_form.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.find.js */ "./node_modules/core-js/modules/es.array.find.js");
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _styles_form_validation_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./styles/form_validation.scss */ "./assets/styles/form_validation.scss");
/* harmony import */ var admin_lte_plugins_jquery_jquery_min_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! admin-lte/plugins/jquery/jquery.min.js */ "./node_modules/admin-lte/plugins/jquery/jquery.min.js");
/* harmony import */ var admin_lte_plugins_jquery_jquery_min_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(admin_lte_plugins_jquery_jquery_min_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var admin_lte_plugins_bs_custom_file_input_bs_custom_file_input_min_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js */ "./node_modules/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js");
/* harmony import */ var admin_lte_plugins_bs_custom_file_input_bs_custom_file_input_min_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(admin_lte_plugins_bs_custom_file_input_bs_custom_file_input_min_js__WEBPACK_IMPORTED_MODULE_5__);
/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");






$('.custom-file-input').on('change', function (event) {
  var inputFile = event.currentTarget;
  $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
});

/***/ }),

/***/ "./assets/subJS/client_validation.js":
/*!*******************************************!*\
  !*** ./assets/subJS/client_validation.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(function () {
  $('#addClientForm').validate({
    rules: {
      nameSurname: {
        required: true,
        minlength: 2
      },
      // birthDate: {
      //     //customdate: true
      //     required: true,
      //     date : true,
      //     dateITA : true
      // },
      gender: {
        required: true
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
      // idNumber: {
      //     required: true,
      //     number: true
      // },
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
      success: function success(label) {
        label.addClass("valid").text("Ok!");
      }
    },
    messages: {
      nameSurname: {
        required: "Please a valid project name",
        minlength: jQuery.validator.format("At least {0} characters required!")
      },
      // birthDate: {
      //     required: "Please write a valide birthday"
      // },
      gender: "Please choose your gender",
      nationality: {
        required: "Please write your nationality",
        number: "Must be a valid number"
      },
      phoneNumber: {
        required: "Please write your phoneNumber",
        number: "Must be a valid number"
      },
      email: {
        required: "We need your email address to contact you",
        email: "Your email address must be in the format of name@domain.com"
      },
      profession: "Please write your profession",
      monthlyIncome: {
        required: "Please write your monthlyIncome",
        number: "Must be a valid number"
      },
      address: "Please write your address",
      // idNumber: {
      //     required: "Please write your idNumber",
      //     number: "Must be a valid number"
      // } ,
      pieceIdentity: "Please choose your pieceIdentity",
      photoIdentity: "Please choose your photoIdentity",
      confirmation: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function errorPlacement(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

/***/ }),

/***/ "./assets/subJS/employee_validation.js":
/*!*********************************************!*\
  !*** ./assets/subJS/employee_validation.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(function () {
  $('#addEmployeeForm').validate({
    rules: {
      nameSurname: {
        required: true
      },
      gender: {
        required: true
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
        required: true
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
        required: "Please a valid project name"
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
      },
      modalityNumberOfMonths: {
        required: "Please write modalityNumberOfMonths",
        number: "Must be a valid number"
      },
      confirmation: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function errorPlacement(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

/***/ }),

/***/ "./assets/subJS/login_validation.js":
/*!******************************************!*\
  !*** ./assets/subJS/login_validation.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(function () {
  $('#loginForm').validate({
    rules: {
      emailInput: {
        required: true,
        email: true
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
    errorPlacement: function errorPlacement(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

/***/ }),

/***/ "./assets/subJS/project_validation.js":
/*!********************************************!*\
  !*** ./assets/subJS/project_validation.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(function () {
  $('#addProjectForm').validate({
    rules: {
      projectName: {
        required: true
      },
      projectDetails: {
        required: true
      },
      amountWanted: {
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
        required: "Please a valid project name"
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
      },
      modalityNumberOfMonths: {
        required: "Please write modalityNumberOfMonths",
        number: "Must be a valid number"
      },
      confirmation: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function errorPlacement(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

/***/ }),

/***/ "./assets/subJS/save_payment_validation.js":
/*!*************************************************!*\
  !*** ./assets/subJS/save_payment_validation.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(function () {
  $('#savePaymentForm').validate({
    rules: {
      dropdownName: {
        required: true
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
      success: function success(label) {
        label.addClass("valid").text("Ok!");
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
      },
      paymentDetails: {
        required: "Ajouter le detail du payment"
      }
    },
    errorElement: 'span',
    errorPlacement: function errorPlacement(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

/***/ }),

/***/ "./assets/subJS/saving_validation.js":
/*!*******************************************!*\
  !*** ./assets/subJS/saving_validation.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(function () {
  $('#addSavingForm').validate({
    rules: {
      IdNumber: {
        required: true
      },
      type: {
        required: true
      },
      month: {
        required: true
      },
      amount: {
        required: true,
        number: true
      },
      proofDocument: {
        required: true
      },
      details: {
        required: true
      },
      validClass: "success",
      success: function success(label) {
        label.addClass("valid").text("Ok!");
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
      },
      proofDocument: "Please choose your pieceIdentity",
      details: "Please enter a detail"
    },
    errorElement: 'span',
    errorPlacement: function errorPlacement(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

/***/ }),

/***/ "./assets/styles/form_validation.scss":
/*!********************************************!*\
  !*** ./assets/styles/form_validation.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_jquery_dist_jquery_js","vendors-node_modules_core-js_internals_add-to-unscopables_js-node_modules_core-js_internals_a-dd2802","vendors-node_modules_admin-lte_plugins_bs-custom-file-input_bs-custom-file-input_min_js-node_-6e5688"], () => (__webpack_exec__("./assets/form_validation.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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LEVBQUU7QUFEUCxPQUhEO0FBTU4wQyxNQUFBQSxNQUFNLEVBQUU7QUFDSjFDLFFBQUFBLFFBQVEsRUFBRSx5QkFETjtBQUVKSyxRQUFBQSxNQUFNLEVBQUU7QUFGSixPQU5GO0FBVU4yQyxNQUFBQSxhQUFhLEVBQUUsa0NBVlQ7QUFXTkMsTUFBQUEsT0FBTyxFQUFFO0FBWEgsS0ExQmU7QUF1Q3pCM0IsSUFBQUEsWUFBWSxFQUFFLE1BdkNXO0FBd0N6QkMsSUFBQUEsY0FBYyxFQUFFLHdCQUFVQyxLQUFWLEVBQWlCQyxPQUFqQixFQUEwQjtBQUN0Q0QsTUFBQUEsS0FBSyxDQUFDUixRQUFOLENBQWUsa0JBQWY7QUFDQVMsTUFBQUEsT0FBTyxDQUFDQyxPQUFSLENBQWdCLGFBQWhCLEVBQStCQyxNQUEvQixDQUFzQ0gsS0FBdEM7QUFDSCxLQTNDd0I7QUE0Q3pCSSxJQUFBQSxTQUFTLEVBQUUsbUJBQVVILE9BQVYsRUFBbUJJLFVBQW5CLEVBQStCaEIsVUFBL0IsRUFBMkM7QUFDbEQzQixNQUFBQSxDQUFDLENBQUN1QyxPQUFELENBQUQsQ0FBV1QsUUFBWCxDQUFvQixZQUFwQjtBQUNILEtBOUN3QjtBQStDekJjLElBQUFBLFdBQVcsRUFBRSxxQkFBVUwsT0FBVixFQUFtQkksVUFBbkIsRUFBK0JoQixVQUEvQixFQUEyQztBQUNwRDNCLE1BQUFBLENBQUMsQ0FBQ3VDLE9BQUQsQ0FBRCxDQUFXTSxXQUFYLENBQXVCLFlBQXZCO0FBQ0g7QUFqRHdCLEdBQTdCO0FBbURILENBcERBLENBQUQ7Ozs7Ozs7Ozs7OztBQ0FBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2Zvcm1fdmFsaWRhdGlvbi5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvaW5wdXRfZm9ybS5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3ViSlMvY2xpZW50X3ZhbGlkYXRpb24uanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3N1YkpTL2VtcGxveWVlX3ZhbGlkYXRpb24uanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3N1YkpTL2xvZ2luX3ZhbGlkYXRpb24uanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3N1YkpTL3Byb2plY3RfdmFsaWRhdGlvbi5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3ViSlMvc2F2ZV9wYXltZW50X3ZhbGlkYXRpb24uanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3N1YkpTL3NhdmluZ192YWxpZGF0aW9uLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvZm9ybV92YWxpZGF0aW9uLnNjc3MiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0ICcuL3N0eWxlcy9mb3JtX3ZhbGlkYXRpb24uc2NzcydcblxuY29uc3QgJCA9IHJlcXVpcmUoJ2pxdWVyeScpO1xuXG5pbXBvcnQgJ2FkbWluLWx0ZS9wbHVnaW5zL2pxdWVyeS9qcXVlcnkubWluLmpzJ1xuXG5pbXBvcnQgJ2FkbWluLWx0ZS9wbHVnaW5zL2pxdWVyeS12YWxpZGF0aW9uL2pxdWVyeS52YWxpZGF0ZS5taW4uanMnXG5cbmltcG9ydCAnYWRtaW4tbHRlL3BsdWdpbnMvanF1ZXJ5LXZhbGlkYXRpb24vYWRkaXRpb25hbC1tZXRob2RzLm1pbi5qcydcblxuaW1wb3J0ICcuL3N1YkpTL3Byb2plY3RfdmFsaWRhdGlvbi5qcydcblxuaW1wb3J0ICcuL3N1YkpTL2NsaWVudF92YWxpZGF0aW9uLmpzJ1xuXG5pbXBvcnQgJy4vc3ViSlMvZW1wbG95ZWVfdmFsaWRhdGlvbi5qcydcblxuaW1wb3J0ICcuL3N1YkpTL2xvZ2luX3ZhbGlkYXRpb24uanMnXG5cbmltcG9ydCAnLi9zdWJKUy9zYXZpbmdfdmFsaWRhdGlvbi5qcydcblxuaW1wb3J0ICAnLi9zdWJKUy9zYXZlX3BheW1lbnRfdmFsaWRhdGlvbi5qcydcblxuaW1wb3J0ICcuL2lucHV0X2Zvcm0uanMnIiwiaW1wb3J0ICcuL3N0eWxlcy9mb3JtX3ZhbGlkYXRpb24uc2NzcydcblxuaW1wb3J0ICdhZG1pbi1sdGUvcGx1Z2lucy9qcXVlcnkvanF1ZXJ5Lm1pbi5qcydcbmltcG9ydCAnYWRtaW4tbHRlL3BsdWdpbnMvYnMtY3VzdG9tLWZpbGUtaW5wdXQvYnMtY3VzdG9tLWZpbGUtaW5wdXQubWluLmpzJ1xuXG4kKCcuY3VzdG9tLWZpbGUtaW5wdXQnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oZXZlbnQpIHtcbiAgICB2YXIgaW5wdXRGaWxlID0gZXZlbnQuY3VycmVudFRhcmdldDtcbiAgICAkKGlucHV0RmlsZSkucGFyZW50KClcbiAgICAgICAgLmZpbmQoJy5jdXN0b20tZmlsZS1sYWJlbCcpXG4gICAgICAgIC5odG1sKGlucHV0RmlsZS5maWxlc1swXS5uYW1lKTtcbn0pO1xuIiwiJChmdW5jdGlvbiAoKSB7XG4gICAgJCgnI2FkZENsaWVudEZvcm0nKS52YWxpZGF0ZSh7XG4gICAgICAgIHJ1bGVzOiB7XG4gICAgICAgICAgICBuYW1lU3VybmFtZToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgICAgIG1pbmxlbmd0aDogMlxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIC8vIGJpcnRoRGF0ZToge1xuICAgICAgICAgICAgLy8gICAgIC8vY3VzdG9tZGF0ZTogdHJ1ZVxuICAgICAgICAgICAgLy8gICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgLy8gICAgIGRhdGUgOiB0cnVlLFxuICAgICAgICAgICAgLy8gICAgIGRhdGVJVEEgOiB0cnVlXG4gICAgICAgICAgICAvLyB9LFxuICAgICAgICAgICAgZ2VuZGVyOntcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBuYXRpb25hbGl0eToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgcGhvbmVOdW1iZXI6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgICAgICBudW1iZXI6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBlbWFpbDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgICAgIGVtYWlsOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgcHJvZmVzc2lvbjoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgbW9udGhseUluY29tZToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgICAgIG51bWJlcjogdHJ1ZVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGFkZHJlc3M6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIC8vIGlkTnVtYmVyOiB7XG4gICAgICAgICAgICAvLyAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICAvLyAgICAgbnVtYmVyOiB0cnVlXG4gICAgICAgICAgICAvLyB9LFxuICAgICAgICAgICAgcGllY2VJZGVudGl0eToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgcGhvdG9JZGVudGl0eToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgY29uZmlybWF0aW9uOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB2YWxpZENsYXNzOiBcInN1Y2Nlc3NcIixcbiAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKGxhYmVsKSB7XG4gICAgICAgICAgICAgICAgbGFiZWwuYWRkQ2xhc3MoXCJ2YWxpZFwiKS50ZXh0KFwiT2shXCIpXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIG1lc3NhZ2VzOiB7XG4gICAgICAgICAgICBuYW1lU3VybmFtZToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSBhIHZhbGlkIHByb2plY3QgbmFtZVwiLFxuICAgICAgICAgICAgICAgIG1pbmxlbmd0aDogalF1ZXJ5LnZhbGlkYXRvci5mb3JtYXQoXCJBdCBsZWFzdCB7MH0gY2hhcmFjdGVycyByZXF1aXJlZCFcIilcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgIC8vIGJpcnRoRGF0ZToge1xuICAgICAgICAgICAvLyAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIHdyaXRlIGEgdmFsaWRlIGJpcnRoZGF5XCJcbiAgICAgICAgICAgLy8gfSxcbiAgICAgICAgICAgIGdlbmRlcjogXCJQbGVhc2UgY2hvb3NlIHlvdXIgZ2VuZGVyXCIsXG4gICAgICAgICAgICBuYXRpb25hbGl0eToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSB3cml0ZSB5b3VyIG5hdGlvbmFsaXR5XCIsXG4gICAgICAgICAgICAgICAgbnVtYmVyOiBcIk11c3QgYmUgYSB2YWxpZCBudW1iZXJcIlxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIHBob25lTnVtYmVyOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIHdyaXRlIHlvdXIgcGhvbmVOdW1iZXJcIixcbiAgICAgICAgICAgICAgICBudW1iZXI6IFwiTXVzdCBiZSBhIHZhbGlkIG51bWJlclwiXG4gICAgICAgICAgICB9ICxcbiAgICAgICAgICAgIGVtYWlsOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiV2UgbmVlZCB5b3VyIGVtYWlsIGFkZHJlc3MgdG8gY29udGFjdCB5b3VcIixcbiAgICAgICAgICAgICAgICBlbWFpbDogXCJZb3VyIGVtYWlsIGFkZHJlc3MgbXVzdCBiZSBpbiB0aGUgZm9ybWF0IG9mIG5hbWVAZG9tYWluLmNvbVwiXG4gICAgICAgICAgICB9ICxcbiAgICAgICAgICAgIHByb2Zlc3Npb246IFwiUGxlYXNlIHdyaXRlIHlvdXIgcHJvZmVzc2lvblwiLFxuICAgICAgICAgICAgbW9udGhseUluY29tZToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSB3cml0ZSB5b3VyIG1vbnRobHlJbmNvbWVcIixcbiAgICAgICAgICAgICAgICBudW1iZXI6IFwiTXVzdCBiZSBhIHZhbGlkIG51bWJlclwiXG4gICAgICAgICAgICB9ICxcbiAgICAgICAgICAgIGFkZHJlc3M6IFwiUGxlYXNlIHdyaXRlIHlvdXIgYWRkcmVzc1wiICxcbiAgICAgICAgICAgIC8vIGlkTnVtYmVyOiB7XG4gICAgICAgICAgICAvLyAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIHdyaXRlIHlvdXIgaWROdW1iZXJcIixcbiAgICAgICAgICAgIC8vICAgICBudW1iZXI6IFwiTXVzdCBiZSBhIHZhbGlkIG51bWJlclwiXG4gICAgICAgICAgICAvLyB9ICxcbiAgICAgICAgICAgIHBpZWNlSWRlbnRpdHk6IFwiUGxlYXNlIGNob29zZSB5b3VyIHBpZWNlSWRlbnRpdHlcIixcbiAgICAgICAgICAgIHBob3RvSWRlbnRpdHk6IFwiUGxlYXNlIGNob29zZSB5b3VyIHBob3RvSWRlbnRpdHlcIixcbiAgICAgICAgICAgIGNvbmZpcm1hdGlvbjogXCJQbGVhc2UgYWNjZXB0IG91ciB0ZXJtc1wiXG4gICAgICAgIH0sXG4gICAgICAgIGVycm9yRWxlbWVudDogJ3NwYW4nLFxuICAgICAgICBlcnJvclBsYWNlbWVudDogZnVuY3Rpb24gKGVycm9yLCBlbGVtZW50KSB7XG4gICAgICAgICAgICBlcnJvci5hZGRDbGFzcygnaW52YWxpZC1mZWVkYmFjaycpO1xuICAgICAgICAgICAgZWxlbWVudC5jbG9zZXN0KCcuZm9ybS1ncm91cCcpLmFwcGVuZChlcnJvcik7XG4gICAgICAgIH0sXG4gICAgICAgIGhpZ2hsaWdodDogZnVuY3Rpb24gKGVsZW1lbnQsIGVycm9yQ2xhc3MsIHZhbGlkQ2xhc3MpIHtcbiAgICAgICAgICAgICQoZWxlbWVudCkuYWRkQ2xhc3MoJ2lzLWludmFsaWQnKTtcbiAgICAgICAgfSxcbiAgICAgICAgdW5oaWdobGlnaHQ6IGZ1bmN0aW9uIChlbGVtZW50LCBlcnJvckNsYXNzLCB2YWxpZENsYXNzKSB7XG4gICAgICAgICAgICAkKGVsZW1lbnQpLnJlbW92ZUNsYXNzKCdpcy1pbnZhbGlkJyk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pOyIsIiQoZnVuY3Rpb24gKCkge1xuICAgICQoJyNhZGRFbXBsb3llZUZvcm0nKS52YWxpZGF0ZSh7XG4gICAgICAgIHJ1bGVzOiB7XG4gICAgICAgICAgICBuYW1lU3VybmFtZToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgZ2VuZGVyOntcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBuYXRpb25hbGl0eToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgcGhvbmVOdW1iZXI6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgICAgICBudW1iZXI6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBlbWFpbDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgICAgIGVtYWlsOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgaWROdW1iZXI6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwaWVjZUlkZW50aXR5OiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwaG90b0lkZW50aXR5OiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBhZGRyZXNzOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBjb25maXJtYXRpb246IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZVxuICAgICAgICAgICAgfVxuICAgICAgICB9LFxuICAgICAgICBtZXNzYWdlczoge1xuICAgICAgICAgICAgcHJvamVjdE5hbWU6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogXCJQbGVhc2UgYSB2YWxpZCBwcm9qZWN0IG5hbWVcIixcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwcm9qZWN0RGV0YWlsczoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSB3cml0ZSBwcm9qZWN0IGRldGFpbHNcIlxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGFtb3VudFdhbnRlZDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSBhbW91bnRXYW50ZWRcIixcbiAgICAgICAgICAgICAgICBudW1iZXI6IFwiTXVzdCBiZSBhIHZhbGlkIG51bWJlclwiXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgbW9kYWxpdHlBbW91bnQ6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogXCJQbGVhc2UgbW9kYWxpdHlBbW91bnRcIixcbiAgICAgICAgICAgICAgICBudW1iZXI6IFwiTXVzdCBiZSBhIHZhbGlkIG51bWJlclwiXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgYnVzaW5lc3NQbGFuRG9jOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIGNob29zZSB5b3VyIGJ1c2luZXNzIHBsYW4gZG9jdW1lbnRcIlxuICAgICAgICAgICAgfSAgICAsXG4gICAgICAgICAgICBtb2RhbGl0eU51bWJlck9mTW9udGhzOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIHdyaXRlIG1vZGFsaXR5TnVtYmVyT2ZNb250aHNcIixcbiAgICAgICAgICAgICAgICBudW1iZXI6IFwiTXVzdCBiZSBhIHZhbGlkIG51bWJlclwiXG4gICAgICAgICAgICB9ICxcblxuICAgICAgICAgICAgY29uZmlybWF0aW9uOiBcIlBsZWFzZSBhY2NlcHQgb3VyIHRlcm1zXCJcbiAgICAgICAgfSxcbiAgICAgICAgZXJyb3JFbGVtZW50OiAnc3BhbicsXG4gICAgICAgIGVycm9yUGxhY2VtZW50OiBmdW5jdGlvbiAoZXJyb3IsIGVsZW1lbnQpIHtcbiAgICAgICAgICAgIGVycm9yLmFkZENsYXNzKCdpbnZhbGlkLWZlZWRiYWNrJyk7XG4gICAgICAgICAgICBlbGVtZW50LmNsb3Nlc3QoJy5mb3JtLWdyb3VwJykuYXBwZW5kKGVycm9yKTtcbiAgICAgICAgfSxcbiAgICAgICAgaGlnaGxpZ2h0OiBmdW5jdGlvbiAoZWxlbWVudCwgZXJyb3JDbGFzcywgdmFsaWRDbGFzcykge1xuICAgICAgICAgICAgJChlbGVtZW50KS5hZGRDbGFzcygnaXMtaW52YWxpZCcpO1xuICAgICAgICB9LFxuICAgICAgICB1bmhpZ2hsaWdodDogZnVuY3Rpb24gKGVsZW1lbnQsIGVycm9yQ2xhc3MsIHZhbGlkQ2xhc3MpIHtcbiAgICAgICAgICAgICQoZWxlbWVudCkucmVtb3ZlQ2xhc3MoJ2lzLWludmFsaWQnKTtcbiAgICAgICAgfVxuICAgIH0pO1xufSk7IiwiJChmdW5jdGlvbiAoKSB7XG4gICAgJCgnI2xvZ2luRm9ybScpLnZhbGlkYXRlKHtcbiAgICAgICAgcnVsZXM6IHtcbiAgICAgICAgICAgIGVtYWlsSW5wdXQ6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgICAgICBlbWFpbDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwYXNzd29yZElucHV0OiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICAgICAgbWlubGVuZ3RoOiA1XG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIG1lc3NhZ2VzOiB7XG4gICAgICAgICAgICBlbWFpbElucHV0OiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiVmV1aWxsZXogZW50cmVyIHZvdHJlIGFkZHJlc3NlIMOpbGVjdHJvbmlxdWVcIixcbiAgICAgICAgICAgICAgICBlbWFpbDogXCJWZXVpbGxleiBlbnRyZXIgdW5lIGFkZHJlc3NlIMOpbGVjdHJvbmlxdWUgdmFsaWRlXCJcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwYXNzd29yZElucHV0OiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiVmV1aWxsZXogZW50cmVyIHZvdHJlIG1vdCBkZSBwYXNzZVwiLFxuICAgICAgICAgICAgICAgIG1pbmxlbmd0aDogXCJWZXVpbGxleiBlbnRyZXIgdW4gbW90IGRlIHBhc3NlIHZhbGlkZVwiXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIGVycm9yRWxlbWVudDogJ3NwYW4nLFxuICAgICAgICBlcnJvclBsYWNlbWVudDogZnVuY3Rpb24gKGVycm9yLCBlbGVtZW50KSB7XG4gICAgICAgICAgICBlcnJvci5hZGRDbGFzcygnaW52YWxpZC1mZWVkYmFjaycpO1xuICAgICAgICAgICAgZWxlbWVudC5jbG9zZXN0KCcuZm9ybS1ncm91cCcpLmFwcGVuZChlcnJvcik7XG4gICAgICAgIH0sXG4gICAgICAgIGhpZ2hsaWdodDogZnVuY3Rpb24gKGVsZW1lbnQsIGVycm9yQ2xhc3MsIHZhbGlkQ2xhc3MpIHtcbiAgICAgICAgICAgICQoZWxlbWVudCkuYWRkQ2xhc3MoJ2lzLWludmFsaWQnKTtcbiAgICAgICAgfSxcbiAgICAgICAgdW5oaWdobGlnaHQ6IGZ1bmN0aW9uIChlbGVtZW50LCBlcnJvckNsYXNzLCB2YWxpZENsYXNzKSB7XG4gICAgICAgICAgICAkKGVsZW1lbnQpLnJlbW92ZUNsYXNzKCdpcy1pbnZhbGlkJyk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pOyIsIiQoZnVuY3Rpb24gKCkge1xuICAgICQoJyNhZGRQcm9qZWN0Rm9ybScpLnZhbGlkYXRlKHtcbiAgICAgICAgcnVsZXM6IHtcbiAgICAgICAgICAgIHByb2plY3ROYW1lOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwcm9qZWN0RGV0YWlsczoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgYW1vdW50V2FudGVkOntcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgICAgICBudW1iZXI6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBtb2RhbGl0eUFtb3VudDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgICAgIG51bWJlcjogdHJ1ZVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGJ1c2luZXNzUGxhbkRvYzoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgbW9kYWxpdHlOdW1iZXJPZk1vbnRoczoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgICAgIG51bWJlcjogdHJ1ZVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGNvbmZpcm1hdGlvbjoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIG1lc3NhZ2VzOiB7XG4gICAgICAgICAgICBwcm9qZWN0TmFtZToge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSBhIHZhbGlkIHByb2plY3QgbmFtZVwiLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIHByb2plY3REZXRhaWxzOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIHdyaXRlIHByb2plY3QgZGV0YWlsc1wiXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgYW1vdW50V2FudGVkOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiUGxlYXNlIGFtb3VudFdhbnRlZFwiLFxuICAgICAgICAgICAgICAgIG51bWJlcjogXCJNdXN0IGJlIGEgdmFsaWQgbnVtYmVyXCJcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBtb2RhbGl0eUFtb3VudDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSBtb2RhbGl0eUFtb3VudFwiLFxuICAgICAgICAgICAgICAgIG51bWJlcjogXCJNdXN0IGJlIGEgdmFsaWQgbnVtYmVyXCJcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBidXNpbmVzc1BsYW5Eb2M6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogXCJQbGVhc2UgY2hvb3NlIHlvdXIgYnVzaW5lc3MgcGxhbiBkb2N1bWVudFwiXG4gICAgICAgICAgICB9ICAgICxcbiAgICAgICAgICAgIG1vZGFsaXR5TnVtYmVyT2ZNb250aHM6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogXCJQbGVhc2Ugd3JpdGUgbW9kYWxpdHlOdW1iZXJPZk1vbnRoc1wiLFxuICAgICAgICAgICAgICAgIG51bWJlcjogXCJNdXN0IGJlIGEgdmFsaWQgbnVtYmVyXCJcbiAgICAgICAgICAgIH0gLFxuXG4gICAgICAgICAgICBjb25maXJtYXRpb246IFwiUGxlYXNlIGFjY2VwdCBvdXIgdGVybXNcIlxuICAgICAgICB9LFxuICAgICAgICBlcnJvckVsZW1lbnQ6ICdzcGFuJyxcbiAgICAgICAgZXJyb3JQbGFjZW1lbnQ6IGZ1bmN0aW9uIChlcnJvciwgZWxlbWVudCkge1xuICAgICAgICAgICAgZXJyb3IuYWRkQ2xhc3MoJ2ludmFsaWQtZmVlZGJhY2snKTtcbiAgICAgICAgICAgIGVsZW1lbnQuY2xvc2VzdCgnLmZvcm0tZ3JvdXAnKS5hcHBlbmQoZXJyb3IpO1xuICAgICAgICB9LFxuICAgICAgICBoaWdobGlnaHQ6IGZ1bmN0aW9uIChlbGVtZW50LCBlcnJvckNsYXNzLCB2YWxpZENsYXNzKSB7XG4gICAgICAgICAgICAkKGVsZW1lbnQpLmFkZENsYXNzKCdpcy1pbnZhbGlkJyk7XG4gICAgICAgIH0sXG4gICAgICAgIHVuaGlnaGxpZ2h0OiBmdW5jdGlvbiAoZWxlbWVudCwgZXJyb3JDbGFzcywgdmFsaWRDbGFzcykge1xuICAgICAgICAgICAgJChlbGVtZW50KS5yZW1vdmVDbGFzcygnaXMtaW52YWxpZCcpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTsiLCIkKGZ1bmN0aW9uICgpIHtcbiAgICAkKCcjc2F2ZVBheW1lbnRGb3JtJykudmFsaWRhdGUoe1xuICAgICAgICBydWxlczoge1xuICAgICAgICAgICAgZHJvcGRvd25OYW1lOntcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBhbW91bnQ6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgICAgICBudW1iZXI6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBmaW5hbmNlRGV0YWlsRG9jOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWVcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwYXltZW50RGV0YWlsczoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgdmFsaWRDbGFzczogXCJzdWNjZXNzXCIsXG4gICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbihsYWJlbCkge1xuICAgICAgICAgICAgICAgIGxhYmVsLmFkZENsYXNzKFwidmFsaWRcIikudGV4dChcIk9rIVwiKVxuICAgICAgICAgICAgfVxuICAgICAgICB9LFxuICAgICAgICBtZXNzYWdlczoge1xuICAgICAgICAgICAgZHJvcGRvd25OYW1lOiBcIkNob2lzaXNzZXIgbGUgdHlwZSBkZSBkZXBlbnNlXCIsXG4gICAgICAgICAgICBhbW91bnQ6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogXCJ2b3VzIGRldmV6IGFqb3V0ZXIgbGUgbW9udGFudCBhIHBheWVyXCIsXG4gICAgICAgICAgICAgICAgbnVtYmVyOiBcIk11c3QgYmUgYSB2YWxpZCBudW1iZXJcIlxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGZpbmFuY2VEZXRhaWxEb2M6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogXCJBam91dGVyIHVuIGRvY3VtZW50IGp1c3RpZmljYXRpZlwiXG4gICAgICAgICAgICB9ICxcbiAgICAgICAgICAgIHBheW1lbnREZXRhaWxzOiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IFwiQWpvdXRlciBsZSBkZXRhaWwgZHUgcGF5bWVudFwiXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIGVycm9yRWxlbWVudDogJ3NwYW4nLFxuICAgICAgICBlcnJvclBsYWNlbWVudDogZnVuY3Rpb24gKGVycm9yLCBlbGVtZW50KSB7XG4gICAgICAgICAgICBlcnJvci5hZGRDbGFzcygnaW52YWxpZC1mZWVkYmFjaycpO1xuICAgICAgICAgICAgZWxlbWVudC5jbG9zZXN0KCcuZm9ybS1ncm91cCcpLmFwcGVuZChlcnJvcik7XG4gICAgICAgIH0sXG4gICAgICAgIGhpZ2hsaWdodDogZnVuY3Rpb24gKGVsZW1lbnQsIGVycm9yQ2xhc3MsIHZhbGlkQ2xhc3MpIHtcbiAgICAgICAgICAgICQoZWxlbWVudCkuYWRkQ2xhc3MoJ2lzLWludmFsaWQnKTtcbiAgICAgICAgfSxcbiAgICAgICAgdW5oaWdobGlnaHQ6IGZ1bmN0aW9uIChlbGVtZW50LCBlcnJvckNsYXNzLCB2YWxpZENsYXNzKSB7XG4gICAgICAgICAgICAkKGVsZW1lbnQpLnJlbW92ZUNsYXNzKCdpcy1pbnZhbGlkJyk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pOyIsIiQoZnVuY3Rpb24gKCkge1xuICAgICQoJyNhZGRTYXZpbmdGb3JtJykudmFsaWRhdGUoe1xuICAgICAgICBydWxlczoge1xuICAgICAgICAgICAgSWROdW1iZXI6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB0eXBlOntcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBtb250aDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgYW1vdW50OiB7XG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICAgICAgbnVtYmVyOiB0cnVlXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgcHJvb2ZEb2N1bWVudDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGRldGFpbHM6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIHZhbGlkQ2xhc3M6IFwic3VjY2Vzc1wiLFxuICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24obGFiZWwpIHtcbiAgICAgICAgICAgICAgICBsYWJlbC5hZGRDbGFzcyhcInZhbGlkXCIpLnRleHQoXCJPayFcIilcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgICAgbWVzc2FnZXM6IHtcbiAgICAgICAgICAgIElkTnVtYmVyOiBcIlBsZWFzZSB3cml0ZSB5b3VyIGlkTnVtYmVyXCIsXG4gICAgICAgICAgICB0eXBlOiBcIlBsZWFzZSBjaG9vc2UgYSB0eXBlXCIsXG4gICAgICAgICAgICBtb250aDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSB3cml0ZSB0aGUgbW9udGhcIlxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGFtb3VudDoge1xuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlBsZWFzZSB3cml0ZSB0aGUgYW1vdW50XCIsXG4gICAgICAgICAgICAgICAgbnVtYmVyOiBcIk11c3QgYmUgYSB2YWxpZCBudW1iZXJcIlxuICAgICAgICAgICAgfSAsXG4gICAgICAgICAgICBwcm9vZkRvY3VtZW50OiBcIlBsZWFzZSBjaG9vc2UgeW91ciBwaWVjZUlkZW50aXR5XCIsXG4gICAgICAgICAgICBkZXRhaWxzOiBcIlBsZWFzZSBlbnRlciBhIGRldGFpbFwiLFxuICAgICAgICB9LFxuICAgICAgICBlcnJvckVsZW1lbnQ6ICdzcGFuJyxcbiAgICAgICAgZXJyb3JQbGFjZW1lbnQ6IGZ1bmN0aW9uIChlcnJvciwgZWxlbWVudCkge1xuICAgICAgICAgICAgZXJyb3IuYWRkQ2xhc3MoJ2ludmFsaWQtZmVlZGJhY2snKTtcbiAgICAgICAgICAgIGVsZW1lbnQuY2xvc2VzdCgnLmZvcm0tZ3JvdXAnKS5hcHBlbmQoZXJyb3IpO1xuICAgICAgICB9LFxuICAgICAgICBoaWdobGlnaHQ6IGZ1bmN0aW9uIChlbGVtZW50LCBlcnJvckNsYXNzLCB2YWxpZENsYXNzKSB7XG4gICAgICAgICAgICAkKGVsZW1lbnQpLmFkZENsYXNzKCdpcy1pbnZhbGlkJyk7XG4gICAgICAgIH0sXG4gICAgICAgIHVuaGlnaGxpZ2h0OiBmdW5jdGlvbiAoZWxlbWVudCwgZXJyb3JDbGFzcywgdmFsaWRDbGFzcykge1xuICAgICAgICAgICAgJChlbGVtZW50KS5yZW1vdmVDbGFzcygnaXMtaW52YWxpZCcpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsiJCIsInJlcXVpcmUiLCJvbiIsImV2ZW50IiwiaW5wdXRGaWxlIiwiY3VycmVudFRhcmdldCIsInBhcmVudCIsImZpbmQiLCJodG1sIiwiZmlsZXMiLCJuYW1lIiwidmFsaWRhdGUiLCJydWxlcyIsIm5hbWVTdXJuYW1lIiwicmVxdWlyZWQiLCJtaW5sZW5ndGgiLCJnZW5kZXIiLCJuYXRpb25hbGl0eSIsInBob25lTnVtYmVyIiwibnVtYmVyIiwiZW1haWwiLCJwcm9mZXNzaW9uIiwibW9udGhseUluY29tZSIsImFkZHJlc3MiLCJwaWVjZUlkZW50aXR5IiwicGhvdG9JZGVudGl0eSIsImNvbmZpcm1hdGlvbiIsInZhbGlkQ2xhc3MiLCJzdWNjZXNzIiwibGFiZWwiLCJhZGRDbGFzcyIsInRleHQiLCJtZXNzYWdlcyIsImpRdWVyeSIsInZhbGlkYXRvciIsImZvcm1hdCIsImVycm9yRWxlbWVudCIsImVycm9yUGxhY2VtZW50IiwiZXJyb3IiLCJlbGVtZW50IiwiY2xvc2VzdCIsImFwcGVuZCIsImhpZ2hsaWdodCIsImVycm9yQ2xhc3MiLCJ1bmhpZ2hsaWdodCIsInJlbW92ZUNsYXNzIiwiaWROdW1iZXIiLCJwcm9qZWN0TmFtZSIsInByb2plY3REZXRhaWxzIiwiYW1vdW50V2FudGVkIiwibW9kYWxpdHlBbW91bnQiLCJidXNpbmVzc1BsYW5Eb2MiLCJtb2RhbGl0eU51bWJlck9mTW9udGhzIiwiZW1haWxJbnB1dCIsInBhc3N3b3JkSW5wdXQiLCJkcm9wZG93bk5hbWUiLCJhbW91bnQiLCJmaW5hbmNlRGV0YWlsRG9jIiwicGF5bWVudERldGFpbHMiLCJJZE51bWJlciIsInR5cGUiLCJtb250aCIsInByb29mRG9jdW1lbnQiLCJkZXRhaWxzIl0sInNvdXJjZVJvb3QiOiIifQ==