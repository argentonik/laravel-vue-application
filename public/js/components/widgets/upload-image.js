$(document).ready(function() {
    var btnUpload = $("#upload_file"), btnOuter = $(".button_outer");
    // show image by default if it exists
    var serverImage = document.getElementById('serverImage');
    if (serverImage && serverImage.value) {
        $(".panel").hide();
        $("#uploaded_view").append('<img src="/storage/'+document.getElementById('serverImage').value+'" />').addClass("show");
    }

    btnUpload.on("change", function(e){
        var ext = btnUpload.val().split('.').pop().toLowerCase();

        if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
            $(".error_msg").text("Not an Image...");
            document.getElementById("upload_file").value = '';
        } else {
            $(".error_msg").text("");
            btnOuter.addClass("file_uploading");
            var uploadedFile = URL.createObjectURL(e.target.files[0]);
            setTimeout(function(){
                $(".panel").hide();
                $("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
            },3500);
        }
    });

    $(".file_remove").on("click", function(e){
        if (serverImage.value) {
            createCookie('deletedServerImage', true, 1)
        }
        document.getElementById("upload_file").value = '';
        $("#uploaded_view").removeClass("show");
        $("#uploaded_view").find("img").remove();
        btnOuter.removeClass("file_uploading");
        btnOuter.removeClass("file_uploaded");
        $(".panel").show();
    });
});

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}
