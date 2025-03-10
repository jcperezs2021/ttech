$(document).ready(function() {
    
    // Get Suggestions
    function getSuggestions(){
        $.get(base_url + '/suggestions/get',  function(resp){
            if(resp.ok){
                $('#s__list__wrapper').html(resp.suggestions);
            }
        }
        ).fail(() => showMessage('alert-danger', 'Ocurrio un error al cargar la página, intente de nuevo.'));
    }
    getSuggestions();

    // Suggestion List Item Click
    $(document).on('click', '.s__list_item', function(){
        if($(window).width() < 768){
            $('#suggestion__list_main').hide();
            $('#suggestion__wrapper_main').show();
        }
        $('.s__list_item').removeClass('active');
        $(this).addClass('active');
        $(this).removeClass('new');
        let id = $(this).attr('suggestionId');
        $.get(base_url + '/suggestions/get/' + id,  function(resp){
            if(resp.ok){
                const { suggestion } = resp;
                $('#suggestion__wrapper').show();
                $('#s__title').html(suggestion.title);
                $('#s__name').html(suggestion.name + ' | ' + suggestion.email);
                $('#s__date').html(suggestion.created_at);
                $('#s__photo').attr('src', base_url + suggestion.author_photo);
                $('#s__message').html(suggestion.message);
                $('#s__markUnread').attr('suggestionId', suggestion.id);
                $('#s__delete').attr('suggestionId', suggestion.id);
            }
        }
        ).fail(() => showMessage('alert-danger', 'Ocurrio un error al cargar la página, intente de nuevo.'));
    }); 

    // Mark Unread
    $('#s__markUnread').click(function(){
        let id = $(this).attr('suggestionId');
        $.post(base_url + '/suggestions/unread', { id, [csrfName]: csrfHash }, handleResponse)
            .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
            .done(() => { 
                getSuggestions();
                $('#suggestion__wrapper').hide();
                if($(window).width() < 768){
                    $('#suggestion__wrapper').hide();
                    $('#suggestion__list_main').show();
                }
            }
        );
    });

    // Delete Suggestion
    $('#s__delete').click(function(){
        let id = $(this).attr('suggestionId');
        if(!confirm('¿Está seguro de eliminar esta sugerencia?')) return;
        $.post(base_url + '/suggestions/delete', { id, [csrfName]: csrfHash }, handleResponse)
            .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
            .done(() => { 
                getSuggestions();
                $('#suggestion__wrapper').hide();
                if($(window).width() < 768){
                    $('#suggestion__wrapper').hide();
                    $('#suggestion__list_main').show();
                }
            }
        );
    });

    $('#s__back').on('click', function(){
        $('#suggestion__wrapper').hide();
        $('#suggestion__list_main').show();
    });
});