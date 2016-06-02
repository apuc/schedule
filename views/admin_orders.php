<?php
/**
 * @var $res array
 */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th>Квест</th>
                    <th>Дата</th>
                    <th>Телефон</th>
                    <th>Имя</th>
                    <th>Email</th>
                </tr>
                <?php foreach($res as $re): ?>
                    <tr>
                        <td><?= get_the_title($re->q_id) ?> ( <?= $re->time_price ?> )</td>
                        <td><?= $re->q_date ?></td>
                        <td><?= $re->phone ?></td>
                        <td><?= $re->name ?></td>
                        <td><?= $re->email ?></td>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>