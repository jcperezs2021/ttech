<?php
    if (!isset($currentFeed)) { return; }
    $contentWithBreaks  = nl2br(htmlspecialchars($currentFeed->body_content));
    $likes              = json_decode($currentFeed->likes_detail, true) ?: [];
    $isLiked            = in_array(session()->get('user')->id, $likes);
    $formatter          = new \IntlDateFormatter('es_MX', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
    $formattedDate      = $formatter->format(new \DateTime($currentFeed->created_at));
?>
<div class="tinf__card card__feed" id="feed_c_<?= htmlspecialchars($currentFeed->id) ?>">
    <div class="tinf__header">
        <div class="tinf__profile align-items-center">
            <img src="<?= base_url(htmlspecialchars($currentFeed->author_photo)) ?>" alt="<?= htmlspecialchars($currentFeed->author_name) ?>">
            <div class="tinf_profile_info">
                <div>
                    <p><?= htmlspecialchars($currentFeed->author_name) ?></p>
                    <span><?= htmlspecialchars($currentFeed->author_ocupation) ?></span> el <small><b><?= $formattedDate ?></b></small>
                </div>
            </div>
        </div>
        <?php if (session('user')->rol === 'admin'): ?>
            <div class="tinf__profile__action">
                <div class="dropdown">
                    <button class="btn" type="button" id="feed__card__actions" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-circle-dot"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="feed__card__actions">
                        <li><a class="dropdown-item btnDeleteFeedItem" feedId="<?= htmlspecialchars($currentFeed->id) ?>">Eliminar</a></li>
                        <!-- <li><a class="dropdown-item btnEditFeedItem" feedId="<?= htmlspecialchars($currentFeed->id) ?>">Editar</a></li> -->
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="tinf__body">
        <div class="text">
            <p><?= $contentWithBreaks ?></p>
        </div>
        <?php
        if($currentFeed->file_path){
            $file_path = json_decode($currentFeed->file_path, true);
            if (!empty($file_path)):
        ?>
                    <div class="text mb-4">
                        <a href="<?= base_url(htmlspecialchars($file_path)) ?>" target="_blank">
                            <i class="ti ti-file me-1"></i>
                            Archivo adjunto
                        </a>
                    </div>
        <?php
            endif;
        ?>
        <?php } ?>
        <?php
        if($currentFeed->image_path){
            $image_path = json_decode($currentFeed->image_path, true);
            if (!empty($image_path)):
                $imagesCount = count($image_path);
                echo "<div class=\"image__content image__container-${imagesCount}\">";
                foreach ($image_path as $image):
        ?>
                    <div class="image" type="button" data-bs-toggle="modal" data-bs-target="#imageFullModal">
                        <img class="image__link" src="<?= base_url(htmlspecialchars($image)) ?>" alt="image">
                    </div>
        <?php
                endforeach;
                echo "</div>";
            endif;
        ?>
        <?php } ?>
    </div>
    <div class="tinf__footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="results">
                        <div class="likes">
                            <img src="<?= base_url("assets/images/icons/like.svg") ?>" alt="like" width="18" height="18" class="me-1"> 
                            <span class="<?= "feedLike-" . htmlspecialchars($currentFeed->id) ?>"><?= htmlspecialchars($currentFeed->likes_count) ?></span>
                        </div>
                        <div class="comments__action comments d-flex" type="button" data-bs-toggle="modal" data-bs-target="#commentList" feedId="<?= htmlspecialchars($currentFeed->id) ?>">
                            <div class="me-1 <?= "feedCommentsValue-" . htmlspecialchars($currentFeed->id) ?>"><?= htmlspecialchars($currentFeed->comments_count) ?></div> 
                            <?= $currentFeed->comments_count == "1" ? 'comentario' : 'comentarios' ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row action__container">
                <div class="col-md-6 col-12 offset-md-6">
                    <div class="action">
                        <?php 
                            $likeButtonClass  = $isLiked ? 'btnRemoveLike' : 'btnCreateLike'; 
                            $likeButtonContent = $isLiked ? '<i class="ti ti-heart-broken"></i> Ya no me gusta' : '<i class="ti ti-heart"></i> Me gusta'; 
                        ?>
                        <button class="<?= $likeButtonClass ?>" feedId="<?= htmlspecialchars($currentFeed->id) ?>"><?= $likeButtonContent ?></button>
                        <button class="btnComment d-flex align-items-center justify-content-center" feedId="<?= htmlspecialchars($currentFeed->id) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="17" width="17" class="me-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                            </svg>
                             Comentar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="comments_container-<?= htmlspecialchars($currentFeed->id) ?>""></div>
    <div class="tinf__header mt-2 <?= "feedComment-" . htmlspecialchars($currentFeed->id) ?>" style="display: none;">
        <div class="tinf__profile pt-1 pb-3 w-100">
            <img src="<?= base_url(htmlspecialchars(session('user')->photo)) ?>" alt="<?= htmlspecialchars(session('user')->name) ?>">
            <div class="tinf_profile_info w-100">
                <form class="w-100 comment_form" feedId="<?= htmlspecialchars($currentFeed->id) ?>">
                    <input type="text" class="form-control <?= "comment_text-" . htmlspecialchars($currentFeed->id) ?>" placeholder="Presiona enter para enviar" feedId="<?= htmlspecialchars($currentFeed->id) ?>">
                </form>
            </div>
        </div>
    </div>
</div>
