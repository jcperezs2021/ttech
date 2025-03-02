<div class="tinf__card_filter">    
    <div class="tinf__header">
        <h5>Hola, <?= session('user')->name ?> </h5>
    </div>    
    <div class="tinf__header">
        <div class="tinf__profile">
            <img src="<?= base_url(session('user')->photo) ?>" alt="<?= session('user')->name ?>">
        </div>
    </div>
    <hr>
    <div class="tinf__header">
        <h5>Filtrar</h5>
    </div>
    <div class="tinf__filters">
        <div class="tinf__filter">
            <a href="<?=base_url('/trantor-informa/text')?>" class="<?= $filter == 'text' ? ' btn-primary' : 'btn-outline-primary' ?> btn w-100 mb-2"><i class="ti ti-message"></i> Solo texto</a>
            <a href="<?=base_url('/trantor-informa/file')?>" class="<?= $filter == 'file' ? ' btn-primary' : 'btn-outline-primary' ?> btn w-100 mb-2"><i class="ti ti-paperclip"></i> Archivo</a>
            <a href="<?=base_url('/trantor-informa/image')?>" class="<?= $filter == 'image' ? ' btn-primary' : 'btn-outline-primary' ?> btn w-100 mb-2"><i class="ti ti-app-window"></i> Imagen</a>
            <?php if ($filter != 'all'): ?>
            <a href="<?=base_url('/trantor-informa/')?>" class="btn-outline-primary btn w-100 mb-2"><i class="ti ti-filter"></i> Todo</a>
            <?php endif; ?>
        </div>
    </div>
</div>
