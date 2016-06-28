<section class="scedual front-sc">
    <div class="container">
        <?php $parser = new Parser_s(); ?>
        <!--<h1 class="scedual__title">24 июня — 1 июля <img src="img/icon22.png" alt=""></h1>-->
        <?php $j = date('w'); ?>
        <?php for ($i = 1; $i <= 7; $i++): ?>
            <div class="price__box">
                <div class="price__box_line">
                    <div class="price__day">
                        <p class="<?= (dayOff($j) == 6 || dayOff($j) == 0) ? 'day-off go' : '' ?>"><?= getDayFor7($j) ?> <?= getMonth(); ?></p>
                        <p class="<?= (dayOff($j) == 6 || dayOff($j) == 0) ? 'day-off go' : '' ?>"><?= getDayRuAll($j); ?></p>
                    </div>
                    <?php $sc = getScheduleToDay(get_the_ID(), $j, 1) ?>
                    <?php //s_prn($sc); ?>
                    <?php $old_price = 0 ?>
                    <?php $old_price_last = 0 ?>
                    <?php //s_prn($sc); ?>
                    <?php foreach ($sc as $key => $item): ?>
                        <?php if (!empty($item)): ?>
                            <?php $tp = explode('-', $item); ?>
                            <?php $time = trim($tp[0]) ?>
                            <?php $price = trim($tp[1]) ?>
                            <?php $prev_tp = explode('-', $sc[$key - 1]) ?>
                            <?php if ($key == 0 || trim($prev_tp[1]) != $price): ?>
                                <?php $parser->render(PL_DIR . 'views/s_time_start.php', [
                                    'time' => $time
                                ]); ?>
                            <?php else: ?>
                                <?php $parser->render(PL_DIR . 'views/s_time_middle.php', [
                                    'time' => $time
                                ]); ?>
                            <?php endif; ?>
                            <?php $next_tp = explode('-', $sc[$key + 1]) ?>
                            <?php if (trim($next_tp[1]) != $price || $time == '03:00'): ?>
                                <?php $parser->render(PL_DIR . 'views/s_time_last.php', [
                                    'price' => $price
                                ]); ?>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $j++ ?>
        <?php endfor; ?>
        <?php for ($i = 8; $i <= 14; $i++): ?>
            <div class="price__box">
                <div class="price__box_line">
                    <div class="price__day">
                        <p class="<?= (dayOff($j) == 6 || dayOff($j) == 0) ? 'day-off go' : '' ?>">
                           <?= getDayFor7($i - 1) ?> <?= getMonth(getMonthFor7($i-1)); ?>
                        </p>
                        <p class="<?= (dayOff($j) == 6 || dayOff($j) == 0) ? 'day-off go' : '' ?>"><?= getDayRuAll($j); ?></p>
                    </div>
                    <?php $sc = getScheduleToDay(get_the_ID(), $j, 2) ?>
                    <?php $old_price = 0 ?>
                    <?php $old_price_last = 0 ?>
                    <?php foreach ($sc as $key => $item): ?>
                        <?php if (!empty($item)): ?>
                            <?php $tp = explode('-', $item); ?>
                            <?php $time = trim($tp[0]) ?>
                            <?php $price = trim($tp[1]) ?>
                            <?php $prev_tp = explode('-', $sc[$key - 1]) ?>
                            <?php if ($key == 0 || trim($prev_tp[1]) != $price): ?>
                                <?php $parser->render(PL_DIR . 'views/s_time_start.php', [
                                    'time' => $time
                                ]); ?>
                            <?php else: ?>
                                <?php $parser->render(PL_DIR . 'views/s_time_middle.php', [
                                    'time' => $time
                                ]); ?>
                            <?php endif; ?>

                            <?php $next_tp = explode('-', $sc[$key + 1]) ?>
                            <?php if (trim($next_tp[1]) != $price || $time == '03:00'): ?>
                                <?php $parser->render(PL_DIR . 'views/s_time_last.php', [
                                    'price' => $price
                                ]); ?>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $j++ ?>
        <?php endfor; ?>
    </div>
</section>