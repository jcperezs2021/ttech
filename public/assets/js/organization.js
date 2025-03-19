$(document).ready(function() {

    function showTwoLevels() {
        $.ajax({
            'url': base_url + 'organization/data',
            'dataType': 'json'
        })
        .done(function(data) {
            datascource = data;
            $('#chart-container').empty(); // Limpia el contenedor del organigrama
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
    }

    // Despliegue inicial
    showTwoLevels();

    // Reconstruir el organigrama y mostrar todos los niveles
    $('#showAll').click(function() {
        $.ajax({
            'url': base_url + 'organization/data',
            'dataType': 'json'
        })
        .done(function(data) {
            $('#chart-container').empty(); // Limpia el contenedor del organigrama
            $('#chart-container').orgchart({
                'visibleLevel': 999, // Muestra todos los niveles
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

    // showTwo 
    $('#showTwo').click(function() {
        showTwoLevels();
    });
});