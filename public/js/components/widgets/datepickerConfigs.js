$(document).ready(function() {
    $("#datepicker").flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: new Date().fp_incr(1), // tomorrow
        maxDate: new Date().fp_incr(30) // 30 days from now
    });
});
