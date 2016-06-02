<?php
/**
 * @var  $my_query object WP_Query
 */
?>

<div class="container-fluid">
    <?php if ($my_query->have_posts()): ?>
        <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="quest-item">
                        <a href="/wp-admin/admin.php?page=schedule&q=<?= get_the_ID() ?>"><?= the_title() ?></a>
                    </div>
                </div>
            </div>
        <?php endwhile;
        wp_reset_query(); ?>
    <?php endif ?>
</div>