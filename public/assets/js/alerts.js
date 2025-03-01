$(document).ready(function() {

    // Function to fetch unread alerts
    function fetchUnreadAlerts() {
        $.getJSON( base_url + 'alerts/unread', function(resp) {
            if(resp.ok){
                let { alerts } = resp;
                if(alerts.length > 0){
                    $('#bell__icon').removeClass().addClass('ti ti-bell-ringing');
                    $('#bell__icon-indicator').removeClass().addClass('notification bg-primary rounded-circle');
                }else{
                    $('#bell__icon').removeClass().addClass('ti ti-bell');
                    $('#bell__icon-indicator').removeClass().addClass('notification bg-light rounded-circle');
                }
            }
        });
    }

    // Mark as read
    $('.markAsRead').click(function(e) {
        var button = $(this);
        var type = $(this).attr('alertType');
        var alert_id = $(this).attr('alertId');
        $.post(base_url + 'alerts/read/' + alert_id, { id: alert_id, [csrfName]: csrfHash }, function(resp) {
            if(resp.ok){
                if(type === 'button') button.hide();
                button.closest('li').removeClass('alert__closed');
                showMessage('alert-success', 'Alerta marcada como leída');
                fetchUnreadAlerts();
            }
            if (resp.csrf_name && resp.csrf_token) {
                actualizarCsrfTokenAjax(resp.csrf_name, resp.csrf_token);
            }
        });
    });

    $(window).on('load', fetchUnreadAlerts);
});
