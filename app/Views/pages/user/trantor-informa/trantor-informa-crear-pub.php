<div class="tinf__card">
    <div class="tinf__header">
        <div class="tinf__profile">
            <img src="<?= session('user')->photo ?>" alt="<?= session('user')->name ?>">
            <div class="tinf_profile_info w-100">
                <div class="tinf__publiate" type="button" data-bs-toggle="modal" data-bs-target="#createFeed">
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
                        <button><i class="ti ti-heart"></i> Me gusta</button>
                        <button><i class="ti ti-speakerphone"></i> Comentar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>