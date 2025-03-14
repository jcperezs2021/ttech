$(document).ready(function() {
    $('#chart-container').append(`<i class="oci oci-spinner spinner"></i>`);
    $.ajax({
        'url': base_url + 'organization/data',
        'dataType': 'json'
    })
    .done(function(data) {
        datascource = data;
        $('#chart-container').orgchart({
            'visibleLevel': 2,
            'data': data,
            'nodeContent': 'title',
            'createNode': function($node, data) {
                if (data.img) {
                    $node.prepend('<img class="node-img" src="' + data.img + '" alt="' + data.name + '">');
                }
            }
        });
    });
});