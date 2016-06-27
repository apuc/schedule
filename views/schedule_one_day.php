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
 * @var $s_prn
 *
 */
?>
<?php $parser = new Parser_s(); ?>

<section class="scedual">
    <div class="container">
        <h1 class="scedual__title"><?= getScheduleToDay(get_the_ID(), date('w'), 1) ?> <img src="img/icon22.png" alt="">
        </h1>
        <?php $j = date('w') ?>

        <div class="scedual__today">

            <p></p>

            <ul class="scedual__today--week">


                <li class="active"><a class="go" href="#"> 24</a></li>

                <li><a class="day-off go" href="#">25</a></li>
                <li><a class="day-off go" href="#">26</a></li>
                <li><a class="go" href="#">27</a></li>
                <li><a class="go" href="#">28</a></li>
                <li><a class="go" href="#">29</a></li>
                <li><a class="go" href="#">30</a></li>
                <li><a class="go" href="#">1</a></li>
                <li><a class="go" class="day-off" href="#">2</a></li>
                <li><a class="go" class="day-off" href="#">3</a></li>
                <li><a class="go" href="#">4</a></li>
                <li><a class="go" href="#">5</a></li>
                <li><a class="go" href="#">6</a></li>
                <li><a class="go" href="#">7</a></li>

            </ul>


        </div>


        <div class="scedual__days">

            <p>Сегодня</p>

            <ul class="scedual__days--week">
                <li><span>сб</span></li>

                <li><span class="day-off">вс</span></li>
                <li><span>пн</span></li>
                <li><span>вт</span></li>
                <li><span>ср</span></li>
                <li><span>чт</span></li>
                <li><span>пт</span></li>
                <li><span class="day-off">сб</span></li>
                <li><span class="day-off">вс</span></li>
                <li><span>пн</span></li>
                <li><span>вт</span></li>
                <li><span>ср</span></li>
                <li><span>чт</span></li>
            </ul>

        </div>


        <h3 class="title">

            <?= getDayFor7($j-1) ?>
        </h3>


        <div class="field"></div>
        <?php if ($my_query->have_posts()): ?>
            <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <div class="price__box">
                    <div class="price__box_line">

                        <div class="price__day">
                            <p>
                                <a href="#"><?= the_title() ?></a>
                            </p>
                            <p></p>
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
            <?php endwhile;
            wp_reset_query(); ?>
        <?php endif ?>
        <!-- <div class="price__box">
             <div class="price__box_line">
                 <div class="price__day">
                     <p><a class="go" href="#">Супермаркет зомби II</a></p>
                     <p>2-5 игроков, 60 минут, 16+</p>
                 </div>
                 <div class="price__item">
                     <ul>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                     </ul>

                       <span class="price__item_price">
                           <span class="line"></span>
                         <span class="price__item_price-inner">
                           1000 р.
                         </span>
                       </span>
                 </div>
                 <div class="price__item">
                     <ul>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                     </ul>

                       <span class="price__item_price">
                           <span class="line"></span>
                         <span class="price__item_price-inner">
                           1000 р.
                         </span>
                       </span>
                 </div>
             </div>
         </div>
         <div class="price__box">
             <div class="price__box_line">
                 <div class="price__day">
                     <p><a class="go" href="#">Супермаркет зомби II</a></p>
                     <p>2-5 игроков, 60 минут, 16+</p>
                 </div>
                 <div class="price__item">
                     <ul>
                         <li><a class="late go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                     </ul>

                       <span class="price__item_price">
                           <span class="line"></span>
                         <span class="price__item_price-inner">
                           1000 р.
                         </span>
                       </span>
                 </div>
                 <div class="price__item">
                     <ul>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="late go" href="#">19:30</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                     </ul>

                       <span class="price__item_price">
                           <span class="line"></span>
                         <span class="price__item_price-inner">
                           1000 р.
                         </span>
                       </span>
                 </div>
             </div>
         </div>
         <div class="price__box">
             <div class="price__box_line">
                 <div class="price__day">
                     <p><a class="go" href="#">Супермаркет зомби II</a></p>
                     <p>2-5 игроков, 60 минут, 16+</p>
                 </div>
                 <div class="price__item">
                     <ul>
                         <li><a class="late go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" class="late" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" class="late" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                     </ul>

                       <span class="price__item_price">
                           <span class="line"></span>
                         <span class="price__item_price-inner">
                           1000 р.
                         </span>
                       </span>
                 </div>
                 <div class="price__item">
                     <ul>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" class="late" href="#">19:30</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                         <li><a class="go" href="#">10:00</a></li>
                     </ul>

                       <span class="price__item_price">
                           <span class="line"></span>
                         <span class="price__item_price-inner">
                           1000 р.
                         </span>
                       </span>
                 </div>
             </div>
             <div class="price__box">
                 <div class="price__box_line">
                     <div class="price__day">
                         <p><a class="go" href="#">Супермаркет зомби II</a></p>
                         <p>2-5 игроков, 60 минут, 16+</p>
                     </div>
                     <div class="price__item--quest">

                         <ul>
                             <li><a class="book-quest go" href="#">Забронировать квест Лаборатория 33</a></li>

                         </ul>

                     </div>
                 </div>
             </div>
         </div>-->

    </div>

</section>

<!--modal window-->
<!-- Modal -->
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

    <!--<input type="text" class="modal_form" placeholder="Квест">
    <input type="text" class="modal_form" placeholder="Телефон">
    <textarea type="text" class="modal_form2" placeholder="Сообщение" rows=3 cols=30
              wrap=physical></textarea>-->
    <!--<a class="modal_but" id="closed" href="#">подтвердить</a>-->

</div>
<div id="overlay"></div>
<!-- Пoдлoжкa -->
<!-- Modal end-->
<!--close window-->

