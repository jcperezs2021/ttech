<div class="modal" id="createFeed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createFeed" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createFeed">Crear una publicación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body feed">
                <div class="tinf__header">
                    <div class="tinf__profile">
                        <img src="<?= base_url(session('user')->photo) ?>" alt="<?= session('user')->name ?>">
                        <div class="tinf_profile_info">
                            <div>
                                <p><?= session('user')->name ?> <?= session('user')->lastname ?></p>
                                <span>Activo ahora</span>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="feedForm" enctype="multipart/form-data" action="<?= base_url('trantor-informa/new') ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="tinf__body">
                        <textarea rows="6" class="form-control" placeholder="Comienza a escribir aquí" name="publication" id="publicationInput"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="comments_active" 
                            name="comments_active" 
                            checked
                        >
                        <label class="form-check-label" for="comments_active">Permitir comentarios</label>
                    </div>
                    <div class="tinf__body" id="uploadFileContainer" style="display:none">
                        <small>
                            Sube un archivo de hasta 5MB
                        </small>
                        <input type="file" 
                            class="filepond"
                            name="file" 
                            id="fileInput" 
                            data-allow-reorder="true"
                            data-max-file-size="5MB"
                            data-max-files="1">
                    </div>
                    <div class="tinf__body" id="uploadImageContainer" style="display:none">
                        <small>
                            Sube hasta 4 imágenes de maximo 5MB cada una
                        </small>
                        <input 
                            type="file" 
                            class="filepond"
                            name="images[]" 
                            id="imagesInput" 
                            multiple 
                            data-allow-reorder="true"
                            data-max-file-size="5MB"
                            data-max-files="4">
                    </div>
                    <div class="tinf__add">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <span>Agregar a la publicación</span>
                                </div>
                                <div class="col-md-6">
                                    <ul class="menu__list">
                                        <li id="btnUploadFile" class="menu__list_item"><i class="ti ti-paperclip"></i> Archivo</li>
                                        <li id="btnUploadImage" class="menu__list_item"><i class="ti ti-app-window"></i> Imágen</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-0 mt-2">
                        <button id="handleCreatePublication" disabled type="submit" class="btn btn-primary w-100">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>