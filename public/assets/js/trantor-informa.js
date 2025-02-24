$(document).ready(function() {

  // Create or remove like
  $('.btnCreateLike, .btnRemoveLike').on('click', function(e) {
    e.preventDefault();
    
    let feedId    = $(this).attr('feedId');
    let button    = $(this);
    let likeCount = $('.feedLike-' + feedId);
    let action    = $(this).hasClass('btnRemoveLike') ? 'remove' : 'add';

    $.post(base_url + `trantor-informa/like/${action}`, { [csrfName]: csrfHash, feed: feedId }, function(resp){
      handleResponse(resp)
      if(resp.ok){
        button.toggleClass('btnCreateLike btnRemoveLike');
        button.html(action === 'add' ? '<i class="ti ti-heart-broken"></i> Ya no me gusta' : '<i class="ti ti-heart"></i> Me gusta');
        likeCount.html(resp.likes);
      }
    }).fail(() => showMessage('alert-danger', 'Error en la solicitud.'));
  });

});