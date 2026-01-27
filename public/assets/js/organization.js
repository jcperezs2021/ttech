$(document).ready(function() {

    $('.select2').select2({
        placeholder: 'Departamento',
        allowClear: true,
    });

    $('.select2area').select2({
        placeholder: 'Area',
        allowClear: true,
    });

    $('#department').on('change', function() {
        let area = $('#area').val();
        if(area != ""){
            $('#area').select2('data', null);
        }
        var department = $(this).val();
        if (department) {
            showOrganization(department, null);
        }
        else {
            showOrganization();
        }
    });

    $('#area').on('change', function() {
        let department = $('#department').val();
        if(department != ""){
            $('#department').select2('data', null);
        }
        
        var area = $(this).val();
        if (area) {
            showOrganization(null, area);
        }
        else {
            showOrganization();
        }
    });

    // Inicializa el organigrama
    function showOrganization( department = null, area = null ) {
        var api_url = base_url + 'organization/data';
        if (department) {
            api_url += '/department/' + department;
        }
        if (area) {
            api_url += '/area/' + area;
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
                        if (data.pid == 10000001) {
                            $node.addClass('ghost__node__root');
                        } else {
                            $node.addClass('ghost__node__niveles__' + data.niveles);
                        }
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