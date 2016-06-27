<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 31.05.2016
 * Time: 14:37
 *
 * @var $schedule array
 * @var $qId integer
 * @var $my_query
 *
 */

?>
<?php $parser = new Parser_s(); ?>

<section class="scedual">
    <div class="container">
        <?php $i = date('w') ?>
        <div class="scedual__today">
            <p></p>
            <ul class="scedual__today--week">
                <?php for ($j = 1; $j <= 14; $j++) : ?>
                    <li class="<?= ($j == $_GET['today']) ? 'active' : '' ?>">
                        <a class="<?= (dayOff($i - 1) == 6 || dayOff($i - 1) == 0) ? 'day-off go' : '' ?>"
                           href="/schedule/?today=<?= $i; ?>">
                            <?= getDayFor7($j - 1) ?>
                        </a>
                    </li>
                    <?php $i++; ?>
                <?php endfor; ?>
            </ul>
        </div>
        <div class="scedual__days">
            <p>Сегодня</p>
            <ul class="scedual__days--week">
                <?php for ($j = 1; $j <= 14; $j++) : ?>
                    <li><span
                            class="<?= (dayOff($i - 1) == 6 || dayOff($i - 1) == 0) ? 'day-off' : '' ?>"> <?= getDayRu($j); ?></span>
                    </li>
                    <?php $i++; ?>
                <?php endfor; ?>
            </ul>
        </div>

        <h3 class="title">
            <?=  dayToday(isset($_GET['today'])? $_GET['today'] - 1: $i+1); ?> &nbsp;<?= getMonth(getToMonth(isset($_GET['today'])? $_GET['today'] - 1: $i-1)); ?>
        </h3>
        <div class="field"></div>
        <?php if ($my_query->have_posts()): ?>
            <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <div class="price__box">
                    <div class="price__box_line">
                        <div class="price__day">
                            <p>
                                <a href="<?= get_permalink(get_the_ID()) ?>"><?= the_title() ?></a>
                            </p>
                            <p><?php echo get_post_meta(get_the_ID(), "desc", 1); ?></p>
                        </div>
                        <?php $sc = getScheduleToDay(get_the_ID(), (isset($_GET['today']) ? $_GET['today'] : $j), 1) ?>
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
            <?php endwhile;
            wp_reset_query(); ?>
        <?php endif ?>
    </div>
</section>
<div id="modal_form"><!-- Сaмo oкнo -->
    <span id="modal_close">X</span> <!-- Кнoпкa зaкрыть -->

    <div class="row">
        <span>квест</span>
        <div class="description">Супермаркет зомби II</div>
    </div>
    <div class="row">
        <span>время</span>
        <div class="description">пятница — 24 июня — 18:00</div>
    </div>
    <div class="row">
        <span>имя</span>
        <div class="description">
            <input type="text">
        </div>
    </div>
    <div class="row">
        <span>email</span>
        <div class="description">
            <input type="text">
        </div>
    </div>
    <div class="row">
        <span>телефон</span>
        <div class="description">
            <input type="text" placeholder="+7 (___) ___-__-__">
        </div>
    </div>
    <div class="row">
            <span>кол-во <br>
            игроков
            </span>
        <div class="description">
            <select name="players" id="players">
                <option value="1">2-4</option>
                <option value="2">5</option>
            </select>
        </div>
    </div>
    <div class="row">
        <span>оплата</span>
        <div class="description">На месте наличными <br>
            Подарочный сертификат
        </div>
    </div>
    <div class="row">
        <div class="price">
            <span class="title">цена</span>
            <span class="cost">4500 р.</span>
        </div>
        <a class="modal_but" id="closed" href="#">подтвердить</a>
    </div>
</div>
<div id="overlay"></div>

