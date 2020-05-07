"use strict";

// Class definition
var KTWizard2 = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var validator;
    var wizard;

    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        wizard = new KTWizard('kt_wizard_v2', {
            startStep: 1,
        });

        // Validation before going to next page
        wizard.on('beforeNext', function (wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        })

        // Change event
        wizard.on('change', function (wizard) {
            KTUtil.scrollTop();
        });
    }

    var initValidation = function () {
        validator = formEl.validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Display error  
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();

                swal.fire({
                    "title": "",
                    "text": "هناك بعض الأخطاء . يرجى تصحيحها.\n",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
            },

            // Submit valid form
            submitHandler: function (form) {

            }
        });
    }

    var initSubmit = function () {
        var btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function (e) {
            e.preventDefault();

            if (validator.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                //KTApp.block(formEl);

                // See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.sun
                formEl.ajaxSubmit({
                    success: function () {
                        KTApp.unprogress(btn);
                        //KTApp.unblock(formEl);

                        swal.fire({
                            "title": "",
                            "text": "تم الاضافة بنجاح!\n",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });

                    }
                });
            }
        });
    }

    return {
        // public functions
        init: function () {
            wizardEl = KTUtil.get('kt_wizard_v2');
            formEl = $('#kt_form');

            initWizard();
            initValidation();
            initSubmit();
        }
    };
}();

jQuery(document).ready(function () {
    KTWizard2.init();
});