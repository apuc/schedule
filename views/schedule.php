<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 31.05.2016
 * Time: 14:37
 *
 * @var $schedule array
 * @var $qId integer
 */
?>
<?php
//s_prn($schedule);
?>

<div class="schedule-front" data-q="<?= $qId ?>">
    <div class="schedule-front-week" data-week="1">
        <?php $i = 1; ?>
        <?php foreach ($schedule[1] as $k => $day): ?>
            <div class="schedule-front-week-day" data-day="<?= $k ?>">
                <div class="schedule-front-week-day--title"><?= getDayRu($i) ?> <br> <?= date('d-m-Y', getSmartDate($i)) ?></div>
                <?php foreach ($day as $d): ?>
                    <?php if (!empty($d)): ?>
                        <div class="schedule-front-week-day--item <?= ($d[0] == '*') ? 'lock' : '' ?>" data-date="<?= date('d-m-Y', getSmartDate($i)) ?>">
                            <span><?= $d ?></span>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
                <div class="schedule-front-week-day--item empty-item"></div>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>

    </div>
    <div class="schedule-front-week" data-week="2">
        <?php $i = 1; ?>
        <?php foreach ($schedule[2] as $k => $day): ?>
            <div class="schedule-front-week-day" data-day="<?= $k ?>">
                <div class="schedule-front-week-day--title"><?= getDayRu($i) ?> <br> <?= date('d-m-Y', getSmartDate($i)) ?></div>
                <?php foreach ($day as $d): ?>
                    <?php if (!empty($d)): ?>
                        <div class="schedule-front-week-day--item <?= ($d[0] == '*') ? 'lock' : '' ?>" data-date="<?= date('d-m-Y', getSmartDate($i)) ?>">
                            <span><?= $d ?></span>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
                <div class="schedule-front-week-day--item empty-item"></div>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
        </div>
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
                    <div class="form-group">
                        <label for="qName">Имя</label>
                        <input type="text" class="form-control" id="qName">
                    </div>
                    <div class="form-group">
                        <label for="qPhone">Телефон</label>
                        <input type="text" class="form-control" id="qPhone" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="qEmail">Email</label>
                        <input type="text" class="form-control" id="qEmail" placeholder="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary lock-add">Сохранить</button>
            </div>
        </div>
    </div>
</div>