<div class="tinf__card_filter">    
    <div class="tinf__header">
        <h5>Hola, <?= session('user')->name ?> </h5>
    </div>    
    <div class="tinf__header">
        <div class="tinf__profile">
            <img src="<?= session('user')->photo ?>" alt="<?= session('user')->name ?>">
        </div>
    </div>
    <hr>
    <div class="tinf__header">
        <h5>Filtrar</h5>
    </div>
    <div class="tinf__filters">
        <div class="tinf__filter">
            <button class="btn btn-outline-primary w-100 mb-2" id="filterOption1" type="button"><i class="ti ti-message"></i> Solo texto</button>
            <button class="btn btn-outline-primary w-100 mb-2" id="filterOption1" type="button"><i class="ti ti-paperclip"></i> Archivo</button>
            <button class="btn btn-outline-primary w-100" id="filterOption2" type="button"><i class="ti ti-app-window"></i> Imagen</button>
        </div>
    </div>
</div>
