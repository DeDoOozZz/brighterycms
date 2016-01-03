$(document).on("click", ".addResume_msg", function () {
    var full_url = $(this).data('url');
    $("#addResume_id").attr('href', full_url);
});