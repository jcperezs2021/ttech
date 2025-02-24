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

  // Show comment form
  $('.btnComment').on('click', function(e) {
    e.preventDefault();
    let feedId = $(this).attr('feedId');
    $('.feedComment-' + feedId).fadeIn();
  });

  // Create comment
  $('.comment_form').on('submit', function(e) {
    e.preventDefault();

    let feedId                = $(this).attr('feedId');
    let feedComment           = $('.feedComment-' + feedId);
    let comment               = $('.comment_text-' + feedId).val();
    let commentCount          = $('.feedCommentsValue-' + feedId);
    let commentContainer      = $('#comments_container-' + feedId);
    let commentContainerList  = $('.commentContainerList-' + feedId);

    $.post(base_url + 'trantor-informa/comment/add', { [csrfName]: csrfHash, feed: feedId, content: comment }, function(resp){
      handleResponse(resp)
      if(resp.ok){
        commentContainerList.fadeIn();
        commentCount.html(resp.comments_count);
        commentContainer.append(resp.comment);
        $('.comment_text-' + feedId).val('');
        feedComment.fadeOut();
      }
    }).fail(() => showMessage('alert-danger', 'Error en la solicitud.'));
  });

  // Get Comments
  $('.comments__action').on('click', function(e) {
    e.preventDefault();

    let feedId = $(this).attr('feedId');
    $('#commentListContainer').html(`<div class="d-flex justify-content-center mb-4"><div class="loader" id="commentListLoader"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div></div>`);
    
    $.get(base_url + 'trantor-informa/feed/comments/' + feedId, { feed: feedId }, function(resp){
      if(resp.ok){
        $('#commentListContainer').html(resp.comments);
      }
      if (resp.csrf_name && resp.csrf_token) {
        actualizarCsrfTokenAjax(resp.csrf_name, resp.csrf_token);
      }
    }
    ).fail(() => showMessage('alert-danger', 'Error en la solicitud.'));
  });

  $('#btnUploadFile').click(function() {
    $('#uploadImageContainer').hide();
    $('#uploadFileContainer').fadeIn();
    $('#images').val('');
  });

  $('#btnUploadImage').click(function() {
    $('#uploadFileContainer').hide();
    $('#uploadImageContainer').fadeIn();
    $('#file').val('');
  });

  // FilePond
  FilePond.registerPlugin(FilePondPluginImagePreview);
  FilePond.create(document.getElementById('images'), {
    credits: false, 
    acceptedFileTypes: ['image/*'],
    allowMultiple: true,
    maxFiles: 4,
    server: {
      url: base_url + '/files',
      process: {
        url: '/upload',
        method: 'POST',
      },
      revert:{
        url: '/revert',
        method: 'DELETE',
      }
    }
  });
});