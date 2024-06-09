(function() {
    $(document).ready(function () {
        let placeholder = 'Select here';
        let select = $('.sumoselect').SumoSelect();
    });
})()

function isNumberKey(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode !== 8 && charCode !== 46 && !/\d/.test(String.fromCharCode(charCode))) {
    return false;
    }
    return true;
}

function isNumberOrCommaKey(e) {
    // Allow only numbers, period, comma, and delete keys
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode !== 8 && charCode !== 46 && charCode !== 188 && !/[0-9,]/.test(String.fromCharCode(charCode))) {
    return false;
    }
    return true;
}