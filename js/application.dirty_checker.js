"use strict";

App.DirtyChecker = new function () {
    var self = this;
    self.submitButtonId = "";
    self.continueButtonId = "";
    self.formId = "";
    self.initialFormHash = null;
    self.currentFormHash = null;

    self.init = function () {
        var submitId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "accept";
        var formId = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "form";
        var continueButtonId = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "continueButton";

        //Set selectors and disable submitButton
        self.submitButtonId = submitId;
        self.formId = formId;
        self.continueButtonId = continueButtonId;
        $("#" + self.submitButtonId).attr("disabled", true);
        $("#" + self.continueButtonId).attr("disabled", true);

        //Setup event handlers
        self._initEvenHandlers();

        //Save Initial values
        self.initialFormHash = App.DirtyChecker._getFormHash();
    };

    //In some cases when form inputs has changed (changing case template), dirty checker need to be reloaded/
    self.reload = function () {
        self._initEvenHandlers();
        self.isDirty();
    };

    self._initEvenHandlers = function () {
        self._setGlobalFormEventHandler();
        self._setDatePickerEventHandlers();
    };

    self._setGlobalFormEventHandler = function () {
        $("#" + self.formId).off("input", self.isDirty).on("input", self.isDirty);
        $("#" + self.formId + ' *').off("change input", self.isDirty).on("change input", self.isDirty);
        $("#" + self.formId + ' div.field-editor').off('keyup', self.isDirty).on('keyup', self.isDirty);
    };

    self._setDatePickerEventHandlers = function () {
        $(".hasDatepicker, .dirty-trackable-datepicker").off("change click", self.isDirty).on("change click", self.isDirty);
    };

    self.isDirty = function () {
        var initialFormHash = self.initialFormHash;
        var currentFormHash = self._getFormHash();
        self.currentFormHash = currentFormHash;

        if (initialFormHash === currentFormHash) {
            $("#" + self.submitButtonId + ", #" + self.continueButtonId).attr("disabled", true);
            return false;
        } else {
            $("#" + self.submitButtonId + ", #" + self.continueButtonId).removeAttr("disabled");
            return true;
        }
    };

    self._getFormHash = function () {
        var inputsValues = self._getInputsValues();
        var inputsHash = self._calcFormHash(inputsValues);

        return inputsHash;
    };

    self._getInputsValues = function () {

        var inputsValues = [];

        $("#" + self.formId + " .dirty-trackable:input,\n        #" + self.formId + " .dirty-trackable :input, \n #" + self.formId + " .searchable,  \n        #" + self.formId + " .form-group :input:visible, \n        #" + self.formId + " .dirty-trackable-datepicker").not('.header .selectionCheckbox, .search-field :input, .steps') // exclude search input for multiselect
        .each(function (e) {
            var input = $(this);
            var inputType = input.prop('type');
            var inputValue = input.val();

            if (inputType == "checkbox") {
                inputValue = input.prop("id") + input.prop("name") + input.prop("checked");
            } else if (inputType == "radio" && input.is(':checked')) {
                inputValue = input.prop("id");
            }

            inputsValues.push({
                value: inputValue === "" ? undefined : inputValue
            });
        });

        $('#' + self.formId + ' div.field-editor').each(function(e)
        {
            inputsValues.push({
                value: $(this).html()
            });
        });

        return inputsValues;
    };

    self._calcFormHash = function (inputs) {
        var inputsString = "";

        $.each(inputs, function (index, input) {
            inputsString += input.value;
        });
        inputsString += inputs.length;

        return hex_md5(inputsString);
    };
}();

;

