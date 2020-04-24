/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  setTimeout(function () {
    $('#alertMessage').slideUp("slow");
  }, 5000);
  $('#userTable').DataTable();
  $('#dailyDiscountRedeemedForm #discount').on('change', function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#dailyDiscountRedeemedForm #saveForm').html('Searching..');
    $.ajax({
      url: $('#dailyDiscountRedeemedForm #discountUserSearchUrl').text(),
      type: 'GET',
      data: $('#dailyDiscountRedeemedForm').serialize(),
      success: function success(response) {
        // console.log(response);
        $('#dailyDiscountRedeemedForm #saveForm').html('Save');
        $('#dailyDiscountRedeemedForm #response').show();
        $('#dailyDiscountRedeemedForm #alert').show();
        $('#dailyDiscountRedeemedForm #response').html(response.message);
        $('#dailyDiscountRedeemedForm #alert').removeClass('d-none');

        if (response.status === true) {
          $('#dailyDiscountRedeemedForm #alert').addClass('alert-success');
          $('#dailyDiscountRedeemedForm #lastname').val(response.data);
        } else {
          $('#dailyDiscountRedeemedForm #alert').addClass('alert-danger');
          $('#dailyDiscountRedeemedForm #lastname').val('');
        }

        setTimeout(function () {
          //document.getElementById("dailyDiscountRedeemedForm").reset();
          $('#dailyDiscountRedeemedForm #response').hide();
          $('#dailyDiscountRedeemedForm #alert').hide();
          $('#dailyDiscountRedeemedForm #alert').addClass('d-none');
          $('#dailyDiscountRedeemedForm #alert').removeClass('alert-success');
          $('#dailyDiscountRedeemedForm #alert').removeClass('alert-danger');
        }, 3000);
      }
    });
  });
  jQuery.validator.addMethod("emailCustom", function (value, element, params) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(value);
  }, "Please enter a valid email address.");
  $("#memberSignupForm").validate({
    rules: {
      first_name: "required",
      last_name: "required",
      "package": "required",
      email: {
        required: true,
        email: true,
        emailCustom: true
      },
      confirm_email: {
        required: true,
        equalTo: "#email"
      }
    },
    messages: {
      first_name: "Please enter your first name",
      last_name: "Please enter your last name",
      "package": "Please select a package first",
      email: "Please enter a valid email address",
      confirm_email: {
        required: "Please enter a valid email address",
        equalTo: "Please enter the same email as above"
      }
    }
  });
  $("#userCreateForm").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true,
        emailCustom: true
      },
      password: {
        required: true,
        minlength: 5
      },
      confirm_password: {
        required: true,
        minlength: 5,
        equalTo: "#password"
      },
      role: "required"
    },
    messages: {
      name: "Please enter a name",
      email: "Please enter a valid email address",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      password_confirmation: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long",
        equalTo: "Please enter the same password as above"
      },
      role: "Please select a role"
    }
  });
  $("#reprintForm").validate({
    rules: {
      discount: "required",
      email: {
        required: true,
        email: true,
        emailCustom: true
      }
    },
    messages: {
      discount: "Please enter your Discount ID",
      email: "Please enter a valid email address"
    }
  });
  $("#dailyDiscountRedeemedForm").validate({
    rules: {
      date: "required",
      discount: {
        required: true,
        digits: true
      },
      phone: {
        required: false
      },
      lastname: "required"
    },
    messages: {
      date: "Please select a date first",
      discount: "Please enter customer Discount ID",
      phone: "Please check this if device is phone",
      lastname: "Please enter customer Last Name"
    },
    submitHandler: function submitHandler(form) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#dailyDiscountRedeemedForm #saveForm').html('Sending..');
      $.ajax({
        url: $('#dailyDiscountRedeemedForm #discountUrl').text(),
        type: "POST",
        data: $('#dailyDiscountRedeemedForm').serialize(),
        success: function success(response) {
          // console.log(response);
          //document.getElementById("dailyDiscountRedeemedForm").reset();
          $('#dailyDiscountRedeemedForm #saveForm').html('Save');
          $('#dailyDiscountRedeemedForm #response').show();
          $('#dailyDiscountRedeemedForm #alert').show();

          if (response.message === "Validation error") {
            var output = '<ul class="error-list">';
            $.each(response.data, function (index, element) {
              output += '<li>';
              output += element;
              output += '</li>';
            });
            $('#dailyDiscountRedeemedForm #response').html(output);
          } else {
            $('#dailyDiscountRedeemedForm #response').html(response.message);
          }

          $('#dailyDiscountRedeemedForm #alert').removeClass('d-none');

          if (response.status === true) {
            $('#dailyDiscountRedeemedForm #alert').addClass('alert-success');
          } else {
            $('#dailyDiscountRedeemedForm #alert').addClass('alert-danger');
          }

          setTimeout(function () {
            //document.getElementById("dailyDiscountRedeemedForm").reset();
            $('#dailyDiscountRedeemedForm #response').hide();
            $('#dailyDiscountRedeemedForm #alert').hide();
            $('#dailyDiscountRedeemedForm #alert').addClass('d-none');
            $('#dailyDiscountRedeemedForm #alert').removeClass('alert-success');
            $('#dailyDiscountRedeemedForm #alert').removeClass('alert-danger');
          }, 5000);
        }
      });
    }
  });
  $("#customerRecordInquiryForm").validate({
    rules: {
      type: {
        required: false
      },
      discount: {
        required: false,
        digits: true
      }
    },
    messages: {
      // type: "Please enter a type first",
      discount: "Please enter customer Discount ID"
    },
    submitHandler: function submitHandler(form) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); // Search Start //

      $('#search').click(function (e) {
        e.preventDefault();
        $('#search').html('Searching..');
        $.ajax({
          url: $('#customerRecordUrl').text(),
          type: "POST",
          data: $('#customerRecordInquiryForm').serialize() + '&button_type=search',
          success: function success(response) {
            // console.log(response);
            $('#customerRecordInquiryForm #search').html('Search');
            $('#customerRecordInquiryForm #response').show();
            $('#customerRecordInquiryForm #alert').show();

            if (response.message === "Validation error") {
              var output = '<ul class="error-list">';
              $.each(response.data, function (index, element) {
                output += '<li>';
                output += element;
                output += '</li>';
              });
              $('#customerRecordInquiryForm #response').html(output);
            } else {
              $('#customerRecordInquiryForm #response').html(response.message);
            }

            $('#customerRecordInquiryForm #alert').removeClass('d-none');

            if (response.status === true) {
              $('#customerRecordInquiryForm #alert').addClass('alert-success'); // console.log(response.data.member_data);

              $('#firstName').val(response.data.member_data.first_name);
              $('#lastName').val(response.data.member_data.last_name);
              $('#emailAddress').val(response.data.member_data.email);
              $('#memeberId').val(response.data.member_data.id);
              $('#type').val(response.data.membership_type);
            } else {
              $('#customerRecordInquiryForm #alert').addClass('alert-danger');
              document.getElementById("customerRecordInquiryForm").reset();
            }

            setTimeout(function () {
              $('#customerRecordInquiryForm #response').hide();
              $('#customerRecordInquiryForm #alert').hide();
              $('#customerRecordInquiryForm #alert').addClass('d-none');
              $('#customerRecordInquiryForm #alert').removeClass('alert-success');
              $('#customerRecordInquiryForm #alert').removeClass('alert-danger');
            }, 5000);
            setTimeout(function () {
              document.getElementById("customerRecordInquiryForm").reset();
            }, 60000);
          }
        });
      }); // Search End //
      // Save Start //

      $('#customerRecordInquiryForm #save').click(function (e) {
        e.preventDefault();
        $('#customerRecordInquiryForm #save').html('Saving...');
        $.ajax({
          url: $('#customerRecordUrl').text(),
          type: "POST",
          data: $('#customerRecordInquiryForm').serialize() + '&button_type=save',
          success: function success(response) {
            //console.log(response);
            $('#customerRecordInquiryForm #save').html('Save');
            $('#customerRecordInquiryForm #response').show();
            $('#customerRecordInquiryForm #alert').show();

            if (response.message === "Validation error") {
              var output = '<ul class="error-list">';
              $.each(response.data, function (index, element) {
                output += '<li>';
                output += element;
                output += '</li>';
              });
              $('#customerRecordInquiryForm #response').html(output);
            } else {
              $('#customerRecordInquiryForm #response').html(response.message);
            }

            $('#customerRecordInquiryForm #alert').removeClass('d-none');

            if (response.status === true) {
              $('#customerRecordInquiryForm #alert').addClass('alert-success');
              console.log(response);
            } else {
              $('#customerRecordInquiryForm #alert').addClass('alert-danger');
              document.getElementById("customerRecordInquiryForm").reset();
            }

            setTimeout(function () {
              document.getElementById("customerRecordInquiryForm").reset();
              $('#customerRecordInquiryForm #response').hide();
              $('#customerRecordInquiryForm #alert').hide();
              $('#customerRecordInquiryForm #alert').addClass('d-none');
              $('#customerRecordInquiryForm #alert').removeClass('alert-success');
              $('#customerRecordInquiryForm #alert').removeClass('alert-danger');
            }, 5000);
          }
        });
      }); // Save End //
      // Delete Start //

      $('#customerRecordInquiryForm #delete').click(function (e) {
        e.preventDefault();
        swal({
          title: "Are you sure?",
          text: "Please confirm that you wish to delete this record by pressing Delete again!",
          icon: "warning",
          buttons: true,
          dangerMode: true
        }).then(function (willDelete) {
          $('#customerRecordInquiryForm #delete').html('Deleting...');
          $.ajax({
            url: $('#customerRecordUrl').text(),
            type: "POST",
            data: $('#customerRecordInquiryForm').serialize() + '&button_type=delete',
            success: function success(response) {
              // console.log(response);
              $('#customerRecordInquiryForm #delete').html('Delete');

              if (response.status === true) {
                if (willDelete) {
                  swal("Deleted!", {
                    icon: "success"
                  });
                  document.getElementById("customerRecordInquiryForm").reset();
                }
              } else {
                swal("Discount number is not deleted!", {
                  icon: "error"
                });
                $('#customerRecordInquiryForm #response').show();
                $('#customerRecordInquiryForm #alert').show();

                if (response.message === "Validation error") {
                  var output = '<ul class="error-list">';
                  $.each(response.data, function (index, element) {
                    output += '<li>';
                    output += element;
                    output += '</li>';
                  });
                  $('#customerRecordInquiryForm #response').html(output);
                } else {
                  $('#customerRecordInquiryForm #response').html(response.message);
                }

                $('#customerRecordInquiryForm #alert').removeClass('d-none');
                $('#customerRecordInquiryForm #alert').addClass('alert-danger');
                setTimeout(function () {
                  document.getElementById("customerRecordInquiryForm").reset();
                  $('#customerRecordInquiryForm #response').hide();
                  $('#customerRecordInquiryForm #alert').hide();
                  $('#customerRecordInquiryForm #alert').addClass('d-none');
                  $('#customerRecordInquiryForm #alert').removeClass('alert-success');
                  $('#customerRecordInquiryForm #alert').removeClass('alert-danger');
                }, 5000);
              }
            }
          });
        });
      });
    }
  });
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
  $('#dateused').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd',
    disableDates: function disableDates(date) {
      var currentDate = new Date();
      return date < currentDate ? true : false;
    }
  });
  $('#dailyDate').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd',
    disableDates: function disableDates(date) {
      var currentDate = new Date();
      return date < currentDate ? true : false;
    }
  });
  $('#fromDate').datepicker({
    uiLibrary: 'bootstrap4',
    // iconsLibrary: 'fontawesome',
    format: 'yyyy-mm-dd',
    // minDate: today,
    maxDate: function maxDate() {
      return $('#toDate').val();
    },
    disableDates: function disableDates(date) {
      var currentDate = new Date();
      return date < currentDate ? true : false;
    }
  });
  $('#toDate').datepicker({
    uiLibrary: 'bootstrap4',
    // iconsLibrary: 'fontawesome',
    format: 'yyyy-mm-dd',
    // maxDate: function () {
    //     return $('#fromDate').val();
    // },
    minDate: function minDate() {
      return $('#fromDate').val();
    },
    disableDates: function disableDates(date) {
      var currentDate = new Date();
      return date < currentDate ? true : false;
    }
  });
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! E:\Projects\bergundi.com\bergundi\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! E:\Projects\bergundi.com\bergundi\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });