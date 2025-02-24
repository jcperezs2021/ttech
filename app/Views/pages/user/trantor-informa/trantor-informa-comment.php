<div class="tinf__header pb-3 mb-0" >
    <div class="tinf__profile pt-1 pb-0 align-items-center">
        <img src="<?= htmlspecialchars($comment->author_photo) ?>" alt="<?= htmlspecialchars($comment->author_name) ?>">
        <div class="tinf_profile_info w-100 comment_area d-block">
            <b class="mb-1"><?= htmlspecialchars($comment->author_name) ?></b><br>
            <p class="mt-2 mb-2"><?= htmlspecialchars($comment->content) ?></p>
            <small class="float-right"><b><?= htmlspecialchars(date('j F, Y', strtotime($comment->created_at))) ?></b></small>
        </div>
    </div>
</div>