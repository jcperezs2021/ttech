<?php
    if (!isset($currentFeed)) { return; }
    $contentWithBreaks  = nl2br(htmlspecialchars($currentFeed->body_content));
    $likes              = json_decode($currentFeed->likes_detail, true) ?: [];
    $isLiked            = in_array(session()->get('user')->id, $likes);
?>
<div class="tinf__card">
    <div class="tinf__header">
        <div class="tinf__profile">
            <img src="<?= htmlspecialchars($currentFeed->author_photo) ?>" alt="<?= htmlspecialchars($currentFeed->author_name) ?>">
            <div class="tinf_profile_info">
                <div>
                    <p><?= htmlspecialchars($currentFeed->author_name) ?></p>
                    <span><?= htmlspecialchars($currentFeed->author_ocupation) ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="tinf__body">
        <div class="text">
            <p><?= $contentWithBreaks ?></p>
        </div>
        <?php
            $image_path = json_decode($currentFeed->image_path, true);
            if (!empty($image_path)):
                foreach ($image_path as $image):
        ?>
                    <div class="image">
                        <img class="img-fluid" src="<?= base_url(htmlspecialchars($image)) ?>" alt="image">
                    </div>
        <?php
                endforeach;
            endif;
        ?>
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
                        <button class="btnComment" feedId="<?= htmlspecialchars($currentFeed->id) ?>"><i class="ti ti-speakerphone"></i> Comentar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="comments_container-<?= htmlspecialchars($currentFeed->id) ?>""></div>
    <div class="tinf__header mt-2 <?= "feedComment-" . htmlspecialchars($currentFeed->id) ?>" style="display: none;">
        <div class="tinf__profile pt-1 pb-3">
            <img src="<?= htmlspecialchars(session('user')->photo) ?>" alt="<?= htmlspecialchars(session('user')->name) ?>">
            <div class="tinf_profile_info w-100">
                <form class="w-100 comment_form" feedId="<?= htmlspecialchars($currentFeed->id) ?>">
                    <input type="text" class="form-control <?= "comment_text-" . htmlspecialchars($currentFeed->id) ?>" placeholder="Presiona enter para enviar" feedId="<?= htmlspecialchars($currentFeed->id) ?>">
                </form>
            </div>
        </div>
    </div>
</div>
