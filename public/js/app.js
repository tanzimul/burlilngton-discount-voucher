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

  function successMessage(response, selector, button) {
    console.log('Success message');
    console.log('Response : ' + response);
    console.log('Selector : ' + selector);
    console.log('Button : ' + button);
    var alertHtml = '<div class="alert alert-success alert-dismissible mt-4">';
    alertHtml += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    alertHtml += '<strong>' + response.message + '</strong>';
    alertHtml += '</div>';
    $(selector + ' #message').html(alertHtml);
    $(button).attr('disabled', false);
  }

  function errorMessage(response, selector, button) {
    console.log('Error message');
    console.log('Response : ' + response.message);
    console.log('Selector : ' + selector);
    console.log('Button : ' + button);
    var alertHtml = '<div class="alert alert-danger alert-dismissible mt-4">';
    alertHtml += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

    if (response.message === "Validation error") {
      var output = '<ol>';
      $.each(response.data, function (index, element) {
        output += '<li>';
        output += element;
        output += '</li>';
      });
      output += '</ol>';
      alertHtml += '<strong>' + output + '</strong>';
    } else {
      alertHtml += '<strong>' + response.message + '</strong>';
    }

    alertHtml += '</div>';
    $(selector + ' #message').html(alertHtml);
    $(button).attr('disabled', false);
  }

  $('#dailyDiscountRedeemedForm #discount').on('change', function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#dailyDiscountRedeemedForm #saveForm').html('Searching..');
    $('#dailyDiscountRedeemedForm #saveForm').attr('disabled', true);
    $.ajax({
      url: $('#dailyDiscountRedeemedForm #discountUserSearchUrl').text(),
      type: 'GET',
      data: $('#dailyDiscountRedeemedForm').serialize(),
      success: function success(response) {
        $('#dailyDiscountRedeemedForm #saveForm').html('Save');
        var selector = '#dailyDiscountRedeemedForm';
        var button = '#dailyDiscountRedeemedForm #saveForm';

        if (response.status === true) {
          successMessage(response, selector, button);
          $('#dailyDiscountRedeemedForm #lastname').val(response.data);
        } else {
          errorMessage(response, selector, button);
        }
      }
    });
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
      lastname: {
        required: false
      }
    },
    messages: {
      date: "Please select a date first",
      discount: "Please enter Discount ID",
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
          $('#dailyDiscountRedeemedForm #saveForm').html('Save');
          var selector = '#dailyDiscountRedeemedForm';
          var button = '#dailyDiscountRedeemedForm #saveForm';

          if (response.status === true) {
            successMessage(response, selector, button);
            $('#dailyDiscountRedeemedForm #discount').val('');
            $('#dailyDiscountRedeemedForm #lastname').val('');
            $('#dailyDiscountRedeemedForm #phone').prop('checked', false);
          } else {
            errorMessage(response, selector, button);
          }
        }
      });
    }
  });
  jQuery.validator.addMethod("emailCustom", function (value, element, params) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(value);
  }, "Please enter a valid email address.");
  $("#memberSignupForm").validate({
    rules: {
      first_name: {
        required: true,
        minlength: 2
      },
      last_name: {
        required: true,
        minlength: 2
      },
      "package": "required",
      email: {
        required: true,
        email: true,
        emailCustom: true
      },
      confirm_email: {
        required: true,
        equalTo: "#email"
      },
      newsletter: "required"
    },
    messages: {
      first_name: {
        required: "Please enter your first name",
        minlength: "Length at least two character long"
      },
      last_name: {
        required: "Please enter your last name",
        minlength: "Length at least two character long"
      },
      "package": "Please select a package first",
      email: "Please enter a valid email address",
      confirm_email: {
        required: "Please enter a valid email address",
        equalTo: "Please enter the same email as above"
      },
      newsletter: "Please check newsletter option"
    },
    submitHandler: function submitHandler(form) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#memberSignupForm #signUpButton').html('Submitting..');
      $('#memberSignupForm #signUpButton').attr('disabled', true);
      $.ajax({
        url: $('#memberSignupForm #memberSignUpUrl').text(),
        type: "POST",
        data: $('#memberSignupForm').serialize(),
        success: function success(response) {
          $('#memberSignupForm #signUpButton').html('Submit');
          var selector = '#memberSignupForm';
          var button = '#memberSignupForm #signUpButton';

          if (response.status === true) {
            successMessage(response, selector, button);
            document.getElementById('memberSignupForm').reset();
          } else {
            errorMessage(response, selector, button);
          }
        }
      });
    }
  });
  jQuery.validator.addMethod("passwordCustom", function (value, element, params) {
    var re = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/;
    return re.test(value);
  }, "Please fullfill the password criteria.");
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
        minlength: 5,
        passwordCustom: true
      },
      confirm_password: {
        required: true,
        minlength: 5,
        equalTo: "#password",
        passwordCustom: true
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
  $("#passwordResetForm").validate({
    rules: {
      email: {
        required: true,
        email: true,
        emailCustom: true
      },
      password: {
        required: true,
        minlength: 5,
        passwordCustom: true
      },
      confirm_password: {
        required: true,
        minlength: 5,
        equalTo: "#password",
        passwordCustom: true
      }
    },
    messages: {
      email: "Please enter a valid email address",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      password_confirmation: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long",
        equalTo: "Please enter the same password as above"
      }
    }
  });
  $("#reprintForm").validate({
    rules: {
      discount: {
        required: "#email:blank",
        digits: true
      },
      email: {
        required: "#discount:blank" // email: true,
        // emailCustom: true

      }
    },
    messages: {
      discount: "Please enter your Discount ID",
      email: "Please enter a valid email address"
    },
    submitHandler: function submitHandler(form) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#reprintForm #sendButton').html('Sending..');
      $("#reprintForm #sendButton").attr("disabled", true);
      $.ajax({
        url: $('#reprintForm #reprintUrl').text(),
        type: "POST",
        data: $('#reprintForm').serialize(),
        success: function success(response) {
          $('#reprintForm #sendButton').html('Send'); //new work

          var selector = '#reprintForm';
          var button = '#reprintForm #sendButton';

          if (response.status === true) {
            successMessage(response, selector, button);
            document.getElementById('reprintForm').reset();
          } else {
            errorMessage(response, selector, button);
          }
        }
      });
    }
  }); // $("#report2").click(function() {
  //     $("#fromDate").prop("required", true);
  //     $("#fromDate").focus();
  //     $("#toDate").prop("required", true);
  // });
  // $("#report3").click(function() {
  //     $("#dailyDate").prop("required", true);
  //     $("#dailyDate").focus();
  // });
  // $("#exportReportForm").validate({
  //     rules: {
  //         report: {
  //             required: true,
  //         },
  //     },
  //     messages: {
  //         report: "Select",
  //     }
  // });

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
            $('#customerRecordInquiryForm #search').html('Search');
            var selector = '#customerRecordInquiryForm';
            var button = '#customerRecordInquiryForm #search';

            if (response.status === true) {
              successMessage(response, selector, button);
              $('#customerRecordInquiryForm #firstName').val(response.data.first_name);
              $('#customerRecordInquiryForm #lastName').val(response.data.last_name);
              $('#customerRecordInquiryForm #emailAddress').val(response.data.email);
              $('#customerRecordInquiryForm #memeberId').val(response.data.id);
              $('#customerRecordInquiryForm #type').val(response.data.membership_type);
              var discount_id = response.data.discount_id.toString();

              if (discount_id.length < 4) {
                discount_id = '0' + discount_id;
              }

              $('#customerRecordInquiryForm #discount').val(discount_id);
            } else {
              errorMessage(response, selector, button);
            }
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
            $('#customerRecordInquiryForm #save').html('Save');
            var selector = '#customerRecordInquiryForm';
            var button = '#customerRecordInquiryForm #save';

            if (response.status === true) {
              successMessage(response, selector, button);
            } else {
              errorMessage(response, selector, button);
            }
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
              $('#customerRecordInquiryForm #delete').html('Delete');
              var selector = '#customerRecordInquiryForm';
              var button = '#customerRecordInquiryForm #save';

              if (response.status === true) {
                successMessage(response, selector, button);

                if (willDelete) {
                  swal('Deleted!', {
                    icon: 'success'
                  });
                  document.getElementById("customerRecordInquiryForm").reset();
                }
              } else {
                errorMessage(response, selector, button);
                swal('Discount number is not deleted!', {
                  icon: 'error'
                });
              }
            }
          });
        });
      });
    }
  });
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
  var getDateToday = new Date(); //var dateToday = String(getDateToday.getMonth() + 1).padStart(2, '0') + '/' + String(getDateToday.getDate()).padStart(2, '0') + '/' + getDateToday.getFullYear(); // mm/dd/yyyy format

  var dateToday = getDateToday.getFullYear() + '-' + String(getDateToday.getMonth() + 1).padStart(2, '0') + '-' + String(getDateToday.getDate()).padStart(2, '0');
  $('#dateused').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd',
    value: dateToday,
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