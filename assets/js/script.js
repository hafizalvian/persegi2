// Remove alert after 3 seconds
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").fadeOut("slow");
    }, 3000);
});