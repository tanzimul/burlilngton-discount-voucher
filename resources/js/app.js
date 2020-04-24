$(document).ready(function () {

    setTimeout(function() {
        $('#alertMessage').slideUp("slow");
    }, 5000);

    $('#userTable').DataTable();



    $('#dailyDiscountRedeemedForm #discount').on('change', function(e) {
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
            success: function (response) {
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

    })


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
            role: "required",
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
            },
        },
        messages: {
            discount: "Please enter your Discount ID",
            email: "Please enter a valid email address",
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
        submitHandler: function (form) {
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
                success: function (response) {
                    // console.log(response);
                    //document.getElementById("dailyDiscountRedeemedForm").reset();
                    $('#dailyDiscountRedeemedForm #saveForm').html('Save');
                    $('#dailyDiscountRedeemedForm #response').show();
                    $('#dailyDiscountRedeemedForm #alert').show();
                    if (response.message === "Validation error") {
                        
                        var output = '<ul class="error-list">';
                        $.each(response.data, function(index, element) {
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
            },
        },
        messages: {
            // type: "Please enter a type first",
            discount: "Please enter customer Discount ID",
        },
        submitHandler: function (form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            // Search Start //

            $('#search').click(function (e) {
                e.preventDefault();
                $('#search').html('Searching..');
                $.ajax({
                    url: $('#customerRecordUrl').text(),
                    type: "POST",
                    data: $('#customerRecordInquiryForm').serialize() + '&button_type=search',
                    success: function (response) {
                        // console.log(response);
                        $('#customerRecordInquiryForm #search').html('Search');
                        $('#customerRecordInquiryForm #response').show();
                        $('#customerRecordInquiryForm #alert').show();

                        if (response.message === "Validation error") {
                            var output = '<ul class="error-list">';
                            $.each(response.data, function(index, element) {
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
                            // console.log(response.data.member_data);
                            $('#firstName').val(response.data.member_data.first_name);
                            $('#lastName').val(response.data.member_data.last_name);
                            $('#emailAddress').val(response.data.member_data.email);
                            $('#memeberId').val(response.data.member_data.id);
                            $('#type').val(response.data.membership_type)
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
            });

            // Search End //

            // Save Start //

            $('#customerRecordInquiryForm #save').click(function (e) {
                e.preventDefault();
                $('#customerRecordInquiryForm #save').html('Saving...');
                $.ajax({
                    url: $('#customerRecordUrl').text(),
                    type: "POST",
                    data: $('#customerRecordInquiryForm').serialize() + '&button_type=save',
                    success: function (response) {
                        //console.log(response);
                        $('#customerRecordInquiryForm #save').html('Save');
                        $('#customerRecordInquiryForm #response').show();
                        $('#customerRecordInquiryForm #alert').show();

                        if (response.message === "Validation error") {
                            var output = '<ul class="error-list">';
                            $.each(response.data, function(index, element) {
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
            });


            // Save End //


            // Delete Start //


            $('#customerRecordInquiryForm #delete').click(function (e) {
                e.preventDefault();

                swal({
                    title: "Are you sure?",
                    text: "Please confirm that you wish to delete this record by pressing Delete again!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                        $('#customerRecordInquiryForm #delete').html('Deleting...');
                        $.ajax({
                            url: $('#customerRecordUrl').text(),
                            type: "POST",
                            data: $('#customerRecordInquiryForm').serialize() + '&button_type=delete',
                            success: function (response) {
                                // console.log(response);
                                $('#customerRecordInquiryForm #delete').html('Delete');
                                if (response.status === true) {
                                    if (willDelete) {
                                        swal("Deleted!", { icon: "success",});
                                        document.getElementById("customerRecordInquiryForm").reset();
                                    }
                                } else {
                                    swal("Discount number is not deleted!", { icon: "error",});
                                    $('#customerRecordInquiryForm #response').show();
                                    $('#customerRecordInquiryForm #alert').show();
                                    if (response.message === "Validation error") {
                                        var output = '<ul class="error-list">';
                                        $.each(response.data, function(index, element) {
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
        disableDates: function (date) {
            const currentDate = new Date();
            return date < currentDate ? true : false;
        },

    });

    
    $('#dailyDate').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        disableDates: function (date) {
            const currentDate = new Date();
            return date < currentDate ? true : false;
        },

    });
    
    $('#fromDate').datepicker({
        uiLibrary: 'bootstrap4',
        // iconsLibrary: 'fontawesome',
        format: 'yyyy-mm-dd',
        // minDate: today,
        maxDate: function () {
            return $('#toDate').val();
        },
        disableDates: function (date) {
            const currentDate = new Date();
            return date < currentDate ? true : false;
        },
    });
    $('#toDate').datepicker({
        uiLibrary: 'bootstrap4',
        // iconsLibrary: 'fontawesome',
        format: 'yyyy-mm-dd',
        // maxDate: function () {
        //     return $('#fromDate').val();
        // },
        minDate: function () {
            return $('#fromDate').val();
        },
        disableDates: function (date) {
            const currentDate = new Date();
            return date < currentDate ? true : false;
        },
    });
});