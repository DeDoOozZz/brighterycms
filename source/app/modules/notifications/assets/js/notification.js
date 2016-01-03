$(document).ready(function () {
    var latest_notifications_update;
    setInterval(function () {
        $.getJSON(site_url + 'notifications', function (notifications) {
                if (latest_notifications_update !== notifications.connected == 1) {
                    latest_notifications_update = notifications.connected;
                    if (notifications.connected !== 1) {
                        // Notifications
                        $('.dropdown-menu-list').prepend('<li class="active notification-success">'
                            + '            <a href="#">'
                            + '        <i class="fa-user"></i>'
                            + '        <span class="line">'
                            + '        <strong>New user registered</strong>'
                            + '</span>'
                            + '<span class="line small time">'
                            + '        30 seconds ago'
                            + '</span>'
                            + '</a>'
                            + '</li>');
                    }
                }
            }
        );
    }, 10000);
});