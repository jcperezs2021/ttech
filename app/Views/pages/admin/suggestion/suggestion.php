<div class="container-fluid">
    <div class="card documents__wrapper">
        <div class="">
            <div class="row bgc__gray">
                <div class="col-md-4 pl__0 pr__0">
                    <div class="suggestion__container">
                        <ul class="s__list" id="s__list__wrapper"></ul>
                    </div>
                </div>
                <div class="col pl__0 pr__0" >
                    <div id="suggestion__wrapper" style="display: none;">
                        <div class="suggestion__title">
                            <h4>Asunto: <b id="s__title"></b></h4>
                        </div>
                        <div class="suggestion__content">
                            <div class="suggestion__header">
                                <div>
                                    <b id="s__name"></b><br>
                                    <span id="s__date"></span>
                                </div>
                                <img src="" alt="" width="45" height="45" class="rounded-circle" id="s__photo">
                            </div>
                            <div class="suggestion__body" id="s__message"></div>
                            <div class="tinf__footer">
                                <div class="container">
                                    <div class="row action__container">
                                        <div class="col-md-6 col-12 offset-md-6">
                                            <div class="action">
                                                <a class="btn d-flex align-items-center justify-content-center" id="s__markUnread" suggestionId="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="24" width="24" class="me-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                    </svg>
                                                    Marcar no leido
                                                </a>
                                                <a class="btn d-flex align-items-center justify-content-center" id="s__delete" suggestionId="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="24" width="24" class="me-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    Eliminar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  var csrfName = '<?= $csrfName ?>';
  var csrfHash = '<?= $csrfHash ?>';
</script>