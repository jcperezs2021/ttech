$(document).ready(function() {

    $('.select2').select2({
        placeholder: 'Departamento',
        allowClear: true,
    });

    // Console log al cambiar el valor de un select
    $('#department').on('change', function() {
        console.log($(this).val());
        var department = $(this).val();
        if (department) {
            showOrganization(department);
        }
        else {
            showOrganization();
        }
    });


    // Inicializa el organigrama
    function showOrganization( department = null ) {
        var api_url = base_url + 'organization/data';
        if (department) {
            api_url += '/department/' + department;
        }
        $.ajax({
            'url': api_url,
            'dataType': 'json'
        })
        .done(function(data) {
            datascource = data;
            $('#chart-container').empty(); // Limpia el contenedor del organigrama
            $('#chart-container').orgchart({
                'data': data,
                'nodeContent': 'title',
                'createNode': function($node, data) {
                    if (data.img) {
                        $node.prepend('<img class="node-img" src="' + data.img + '" alt="' + data.name + '">');
                    }
                    if(data.ghost) {
                        $node.addClass('ghost__node');
                        $node.addClass('ghost__node__niveles__' + data.niveles);
                    }else{
                        $node.addClass('normal__node');
                    }
                }
            });
        });
    }

    // Despliegue inicial
    showOrganization();
});