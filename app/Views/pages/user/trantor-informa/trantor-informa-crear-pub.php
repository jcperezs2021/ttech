<div class="tinf__card">
    <div class="tinf__header">
        <div class="tinf__profile">
            <img src="<?= base_url(session('user')->photo) ?>" alt="<?= session('user')->name ?>">
            <div class="tinf_profile_info w-100">
                <div id="tinf__publicate" type="button" data-bs-toggle="modal" data-bs-target="#createFeed">
                    Crear una publicación
                </div>
            </div>
        </div>
    </div>
    <div class="tinf__footer">
        <div class="container">
            <div class="row action__container">
                <div class="col-md-6 col-12 offset-md-6">
                    <div class="action">
                        <button id="btnHandleFile" type="button" data-bs-toggle="modal" data-bs-target="#createFeed"><i class="ti ti-paperclip"></i> Archivo</button>
                        <button id="btnHandleImage" type="button" data-bs-toggle="modal" data-bs-target="#createFeed"><i class="ti ti-app-window"></i> Imagen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>