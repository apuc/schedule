<?php
/**
 * @var $schedule array
 */
?>
<?php
//s_prn($schedule);
?>
<div class="schedule-wrap" data-q="<?= $_GET['q'] ?>">
    <a href="#" id="save_schedule" class="btn btn-success">Сохранить</a>
    <div class="schedule-wrap-week" data-week="1">
        <?php getScheduleToDay(get_the_ID(), date('w'),1) ?>
        <?php //$i = 1; ?>
        <?php $i = date('w'); ?>
        <?php $j = 1; ?>
        <?php foreach ($schedule[1] as $k => $day): ?>
            <div class="schedule-wrap-week-day" data-day="<?= getDay($i) ?>">
                <span class="schedule-wrap-week-day--title"><?= getDayRu($i) ?> <?= date('d-m-Y', getSmartDate($i)) ?></span>
                <?php foreach ($day as $d): ?>
                    <?php if (!empty($d)): ?>
                        <?php $price_time = explode('-', $d); ?>
                        <span class="schedule-wrap-week-day--item">
                        <span id="<?= $j ?>"><?= $d ?></span> <!--<a href="#" class="icon icon-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                            <a href="#" class="icon icon-edit"
                               data-id="<?= $j ?>"
                               data-time="<?= trim($price_time[0]) ?>"
                               data-price="<?= trim($price_time[1]) ?>"
                               title="Удалить">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <?php if($d[0] == '*'): ?>
                                <a href="#" class="icon icon-unlock" title="Снять бронь"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                            <?php endif; ?>
                    </span>
                    <?php endif ?>
                    <?php $j++ ?>
                <?php endforeach; ?>
                <span class="schedule-wrap-week-day--item add_item">
              </span>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
    <div class="schedule-wrap-week" data-week="2">

        <?php $i = date('w'); ?>
        <?php foreach ($schedule[2] as $k => $day): ?>
            <div class="schedule-wrap-week-day" data-day="<?= getDay($i + 7) ?>">
                <span class="schedule-wrap-week-day--title"><?= getDayRu($i) ?> <?= date('d-m-Y', getSmartDate($i + 7)) ?></span>
                <?php foreach ($day as $d): ?>
                    <?php if (!empty($d)): ?>
                        <?php $price_time = explode('-', $d); ?>
                        <span class="schedule-wrap-week-day--item">
                        <span id="<?= $j ?>"><?= $d ?></span><!--<a href="#" class="icon icon-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                            <a href="#" class="icon icon-edit"
                               data-id="<?= $j ?>"
                               data-time="<?= trim($price_time[0]) ?>"
                               data-price="<?= trim($price_time[1]) ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <?php if($d[0] == '*'): ?>
                                <a href="#" class="icon icon-unlock" title="Снять бронь"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                            <?php endif; ?>
                    </span>
                    <?php endif ?>
                    <?php $j++; ?>
                <?php endforeach; ?>
                <span class="schedule-wrap-week-day--item add_item">
                <!--<a href="#">Добавить</a>-->
            </span>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить время</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <!--<div class="form-group">
                        <label for="qTime">Время</label>
                        <input type="text" class="form-control" id="qTime" placeholder="например 16:30">
                    </div>-->
                    <div class="form-group">
                        <label for="qPrice">Цена</label>
                        <input type="text" class="form-control" id="qPrice" placeholder="">
                    </div>
                </form>
            </div>
            <span id="qidMy" data-current="0"></span>
            <span id="qidOneMy" data-qtime="0"></span>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary schedule-add">Сохранить</button>
            </div>
        </div>
    </div>
</div>