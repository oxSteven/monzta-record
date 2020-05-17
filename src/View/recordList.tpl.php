<div class='recordList'>
<?php if (count($d->records) > 0) : ?>
    <?php foreach ($d->records as $record) : ?>
        <div class='recordEntry'>
            <div class='outerContainer'>
                <h3 class='type'><?=$record->name?></h3>
                <div class='innerContainer'>
                    <div class='value'><?=$record->value?></div>
                    <div class='holder'><?=$record->holder?></div>
                </div>
            </div>
            <div class='buttons'>
                <?php if ($record->class != '') : ?>
                <div title='Class: <?=$record->class?>'><img src='<?=$i?>class<?=$record->class?>.png' /></div>
                <?php endif; ?>
                <div class='region' title='Region: <?=$record->region?>'><?=$record->region?></div>
                <?php if ($record->proof != '') : ?>
                <a href='<?=$record->proof?>' title='See Proof' target='_blank'><img src='<?=$i?>proof.png' /></a>
                <?php else : ?>
                <div title='No Record'><img src='<?=$i?>proof.png' /></div>
                <?php endif; ?>
                <a href='<?=$d->submitLink?><?=$record->id?>' title='Submit Your Own Record' target='_blank'><img src='<?=$i?>submit.png' /></a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p class='nothingFound'>Sorry, there are no records matching your filters.</p>
<?php endif; ?>
</div>
</main>
