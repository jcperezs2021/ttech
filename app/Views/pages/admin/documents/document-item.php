<?php

    $files_formats = array(
        'pdf' => 'assets/images/icons/pdf.png',
        'doc' => 'assets/images/icons/docx.png',
        'xls' => 'assets/images/icons/xls.webp',
        'ppt' => 'assets/images/icons/ppt.png',
        'zip' => 'assets/images/icons/zip.png',
        'rar' => 'assets/images/icons/rar.png',
        'unk' => 'assets/images/icons/unk.png'
    );

    $file_type = base_url($files_formats['unk']);

    if (strpos($file->type, 'zip') !== false) {
        $file_type = base_url($files_formats['zip']);
    } else if (strpos($file->type, 'rar') !== false) {
        $file_type = base_url($files_formats['rar']);
    } else if (strpos($file->type, 'pdf') !== false) {
        $file_type = base_url($files_formats['pdf']);
        $file_pdf = true;
    } else if (strpos($file->type, 'word') !== false) {
        $file_type = base_url($files_formats['doc']);
    } else if (strpos($file->type, 'sheet') !== false) {
        $file_type = base_url($files_formats['xls']);
    } else if (strpos($file->type, 'presentation') !== false) {
        $file_type = base_url($files_formats['ppt']);
    }

?>

<li class="document__list_item">
    <div class="file__item">
        <span class="document__list_item_image">
            <img
                src="<?= $file_type ?>"
                alt="file"
                width="28"
                height="28"
            >
        </span>
        <span class="document__list_item_name ms-2">
            <?= $file->name ?>
        </span>
    </div>
    <div class="document__action">
        <span class="me-2">
            <small>
                <?= number_format($file->size / (1024 * 1024), 2) ?> MB
            </small>
        </span>
        <div class="dropdown">
            <button class="btn" type="button" id="feed__card__actions" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-circle-dot"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="feed__card__actions">
                <?php if (isset($file_pdf)): ?>
                    <li><a class="dropdown-item" href="<?= base_url($file->path) ?>" target="_blank">Ver</a></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="<?= base_url($file->path) ?>" download>Descargar</a></li>
                <li><a class="dropdown-item delete__file" fileId="<?= $file->id ?>">Eliminar</a></li>
            </ul>
        </div>
    </div>
</li>