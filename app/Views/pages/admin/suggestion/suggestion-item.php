<li class="s__list_item <?= $suggestion->status ?>" suggestionId="<?= $suggestion->id ?>" id="suggestion_<?= $suggestion->id ?>">
    <div class="d-flex align-items-center justify-content-between s__header">
        <span class="title"><?=$suggestion->name?></span>
        <?php 
        $createdDate = strtotime($suggestion->created_at);
        if (date('Y-m-d', $createdDate) == date('Y-m-d')): ?>
            <span><?= date('H:i', $createdDate) ?></span>
        <?php elseif (date('Y-m-d', $createdDate) == date('Y-m-d', strtotime('-1 day'))): ?>
            <span>Ayer</span>
        <?php else: ?>
            <span><?= date('d/m/Y H:i', $createdDate) ?></span>
        <?php endif; ?>
    </div>
    <div class="s__body">
        <span class="title"><?=$suggestion->title?></span><br>
        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;"><?=$suggestion->message?></span>
    </div>
</li>