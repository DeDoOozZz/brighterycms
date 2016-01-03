$(document).ready(function () {
    var connectivity_status;
    setInterval(function () {
        $.getJSON(site_url + 'connection_status', function (status) {
                if (connectivity_status !== status.connected == 1) {
                    connectivity_status = status.connected;
                    if (status.connected !== 1) {
                        var opts = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-bottom-left",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "0",
                            "extendedTimeOut": "0",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.warning("You are offline.", null, opts);
                    }
                    else
                    {
                        toastr.clear();
                    }
                }
            }
        );
    }, 10000);
});