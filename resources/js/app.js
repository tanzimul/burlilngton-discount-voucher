// require('./bootstrap');
//import '~bootstrap/dist/js/bootstrap';
// import 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle';
$(document).ready(function () {

    jQuery.validator.addMethod("emailCustom", function (value, element, params) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(value);
    }, "Please enter a valid email address.");
    $("#memberSignupForm").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            package: "required",
            email: {
                required: true,
                email: true,
                emailCustom: true
            },
            confirm_email: {
                required: true,
                equalTo: "#email"
            },
        },
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            package: "Please select a package first",
            email: "Please enter a valid email address",
            confirm_email: {
                required: "Please enter a valid email address",
                equalTo: "Please enter the same email as above"
            },
            
        }
    });

    $("#reprintForm").validate({
        rules: {
            discount: "required",
            email: {
                required: true,
                email: true,
                emailCustom: true
            },
        },
        messages: {
            discount: "Please enter your Discount ID",
            email: "Please enter a valid email address",
        }
    });
});