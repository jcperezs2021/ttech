<?php
    if (!isset($currentFeed)) {
        return;
    }
    $contentWithBreaks = nl2br(htmlspecialchars($currentFeed->body_content));
    $likes      = json_decode($currentFeed->likes_detail);
    $likes      = is_array($likes) ? $likes : [];
    $isLiked    = in_array(session()->get('user')->id, $likes);
?>
<div class="tinf__card">
    <div class="tinf__header">
        <div class="tinf__profile">
            <img src="<?= $currentFeed->author_photo ?>" alt="<?= $currentFeed->author_name ?>">
            <div class="tinf_profile_info">
                <div>
                    <p><?= $currentFeed->author_name ?></p>
                    <span><?= $currentFeed->author_ocupation ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="tinf__body">
        <div class="text">
            <p><?= $contentWithBreaks ?></p>
        </div>
        <?php
            $image_path = json_decode($currentFeed->image_path);
            if (is_array($image_path) && count($image_path) > 0):
            foreach ($image_path as $image):
        ?>
                <div class="image">
                    <img class="img-fluid" src="<?= base_url($image) ?>" alt="image">
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
                            <img src="<?= base_url( "assets/images/icons/like.svg" ) ?>" alt="like" width="18" height="18"> <span class="<?= "feedLike-".$currentFeed->id ?>"><?= $currentFeed->likes_count ?></span>
                        </div>
                        <div class="comments">
                            55 comentarios
                        </div>
                    </div>
                </div>
            </div>
            <div class="row action__container">
                <div class="col-md-6 col-12 offset-md-6">
                    <div class="action">
                        <?php $likeButtonClass  = $isLiked ? 'btnRemoveLike' : 'btnCreateLike'; ?>
                        <?php $likeButtonContent   = $isLiked ? '<i class="ti ti-heart-broken"></i> Ya no me gusta' : '<i class="ti ti-heart"></i> Me gusta'; ?>
                        <button class="<?= $likeButtonClass ?>" feedId="<?= $currentFeed->id ?>"><?= $likeButtonContent ?></button>
                        <button><i class="ti ti-speakerphone"></i> Comentar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>
