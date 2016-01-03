$(document).on("click", ".delete_msg", function () {
    var full_url = $(this).data('url_id');
    $("#delete_id").attr('href', full_url);
});