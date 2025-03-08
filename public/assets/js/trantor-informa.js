$(document).ready(function() {

  // Image preview
  $('.image__link').on('click', function(e) {
    e.preventDefault();
    let imageSrc = $(this).attr('src');
    $('#imageFull').attr('src', imageSrc);
  });

  // Block or unblock publicationInput button
  $('#publicationInput').on('input', function() {
    let publicationInput = $('#publicationInput').val();
    let publicationButton = $('#handleCreatePublication');
    if (publicationInput.trim().length > 0) {
      publicationButton.removeAttr('disabled');
    }
    else {
      publicationButton.attr('disabled', 'disabled');
    }
  });

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
    $('.comment__area').fadeOut();
    $('#commentListContainer').html(`<div class="d-flex justify-content-center mb-4"><div class="loader" id="commentListLoader"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div></div>`);
    
    $.get(base_url + 'trantor-informa/feed/comments/' + feedId, { feed: feedId }, function(resp){
      if(resp.ok){
        $('#commentListContainer').html(resp.comments);
      }
      if (resp.csrf_name && resp.csrf_token) {
        actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
      }
    }
    ).fail(() => showMessage('alert-danger', 'Error en la solicitud.'));
  });

  // Upload file
  $('#btnUploadFile, #btnHandleFile').click(function() {
    $('#uploadImageContainer').hide();
    $('#uploadFileContainer').fadeIn();
    $('#images').val('');
  });

  // Upload image
  $('#btnUploadImage, #btnHandleImage').click(function() {
    $('#uploadFileContainer').hide();
    $('#uploadImageContainer').fadeIn();
    $('#file').val('');
  });

  // Edit feed item
  $('.btnEditFeedItem').click(function() {
    let feedId = $(this).attr('feedId');
  });
  
  // Delete feed item
  $('.btnDeleteFeedItem').click(function() {
    let feedId = $(this).attr('feedId');
    let deleteItem = confirm('¿Estás seguro de que deseas eliminar este elemento?, este cambio no puede revertirse');
    if (deleteItem) {
        $.post(base_url + 'trantor-informa/delete', { id: feedId, [csrfName]: csrfHash }, handleResponse)
          .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
          .done(() => { $(this).closest('.tinf__card').remove(); });

    }
  });

  // Delete comment
  $(document).on('click', '.btnDeleteCommentItem', function() {
    let commentId     = $(this).attr('commentId');
    let feedId        = $(this).attr('feedId');
    let commentCount  = $('.feedCommentsValue-' + feedId);
    let deleteItem = confirm('¿Estás seguro de que deseas eliminar este comentario?, este cambio no puede revertirse');
    if (deleteItem) {
        $.post(base_url + 'trantor-informa/comment/delete', { id: commentId, [csrfName]: csrfHash }, handleResponse)
          .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
          .done(() => { 
            $(this).closest('.comment__area').remove(); 
            commentCount.html(parseInt(commentCount.html()) - 1);
          });
    }
  });

  // Function to scroll to a specific container with offset
  function scrollToContainer(containerId) {
    var container = document.getElementById(containerId);
    if (container) {
        var appHeader = document.querySelector('.app-header');
        var headerOffset = appHeader ? appHeader.offsetHeight + 10 : 10; // Dynamic height of header plus 10px gap
        var elementPosition = container.getBoundingClientRect().top;
        var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scroll({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
  }

  // Check if there is a scrollTo parameter in the URL
  var urlParams = new URLSearchParams(window.location.search);
  var scrollTo = urlParams.get('scrollTo');
  if (scrollTo) {
    scrollToContainer(scrollTo);
  }

  // FilePond configuration
  FilePond.registerPlugin(FilePondPluginImagePreview);
  FilePond.registerPlugin(FilePondPluginFileValidateType);
  FilePond.registerPlugin(FilePondPluginFileValidateSize);

  // Images
  FilePond.create(document.getElementById('imagesInput'), {
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

  // Files
  FilePond.create(document.getElementById('fileInput'), {
    credits: false, 
    acceptedFileTypes: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip'],
    allowMultiple: false,
    maxFiles: 1,
    server: {
      url: base_url + '/files',
      process: {
        url: '/upload/file',
        method: 'POST',
      },
      revert:{
        url: '/revert',
        method: 'DELETE',
      }
    }
  });
});