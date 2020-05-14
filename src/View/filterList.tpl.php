<div class='filterList'>
<?php foreach ($d->filterList as $filterGroupName => $filterGroup) : ?>
    <label><?=$filterGroupName?></label>
    <div class='filterGroup'>
        <?php foreach ($filterGroup as $filter) : ?>
            <a <?php if ($filter->active == true) : ?>class='active' <?php endif; ?>href='<?=$a?><?=$filter->url?>' title='<?php if ($filter->active == true) : ?>Remove<?php else : ?>Add<?php endif; ?> Filter'><?=$filter->name?></a>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
</div>
