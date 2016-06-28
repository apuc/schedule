<?php
/**
 * Plugin Name: schedule
 * Plugin URI: http://web-artcraft.com
 * Description: Расписание
 * Version: 0.1
 * Author: Kavalar
 * Author URI: http://web-artcraft.com
 */

define('PL_DIR', plugin_dir_path(__FILE__));
define('PL_URL', plugin_dir_url(__FILE__));

require_once PL_DIR . '/lib/Parser_s.php';
require_once PL_DIR . '/lib/functions.php';

function add_admin_script()
{
    wp_enqueue_style('font-ewesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', '1');
    wp_enqueue_script('s-bootstrap', PL_URL . '/js/bootstrap.min.js', array('jquery'), '', false);
    wp_enqueue_script('s-script', PL_URL . '/js/script.js', array('jquery'), '', false);
    wp_enqueue_style('s-bootstrap', PL_URL . '/css/bootstrap/bootstrap.min.css', array(), '1');
    wp_enqueue_style('s-style', PL_URL . '/css/style.css', array(), '1');
}

add_action('admin_enqueue_scripts', 'add_admin_script');


add_action('wp_footer', 'add_scripts_s'); // приклеем ф-ю на добавление скриптов в футер
function add_scripts_s()
{ // добавление скриптов
    if (is_admin()) return false; // если мы в админке - ничего не делаем
    wp_enqueue_style('font-ewesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', '1');
    wp_enqueue_style('s-bootstrap', PL_URL . '/css/bootstrap/bootstrap.modal.min.css', array(), '1');
    wp_enqueue_script('s-bootstrap', PL_URL . 'js/bootstrap.min.js', array('jquery'), '', false);
    wp_enqueue_script('s-script', PL_URL . 'js/script.js', array('s-bootstrap'), '', false);
    wp_localize_script('s-script', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );
}


add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
function add_styles()
{ // добавление стилей
    if (is_admin()) return false; // если мы в админке - ничего не делаем
    wp_enqueue_style('s-style', PL_URL . 'css/style.css', array(), '1');
}

/**
 * Регистрируем тип записи "Квест"
 */
add_action('init', 'myCustomInitQuest');

function myCustomInitQuest()
{
    $labels = array(
        'name' => 'Квест', // Основное название типа записи
        'singular_name' => 'Квест', // отдельное название записи типа Book
        'add_new' => 'Добавить Квест',
        'add_new_item' => 'Добавить новый Квест',
        'edit_item' => 'Редактировать Квест',
        'new_item' => 'Новый Квест',
        'view_item' => 'Посмотреть Квест',
        'search_items' => 'Найти Квест',
        'not_found' => 'Квестов не найдено',
        'not_found_in_trash' => 'В корзине Квестов не найдено',
        'parent_item_colon' => '',
        'menu_name' => 'Квест'

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );
    register_post_type('quest', $args);
}


/**
 * Добавляем страницу в админку
 */
function register_schedule_menu_page()
{
    add_menu_page(
        'Настройка расписания', 'Настройка расписания', 'manage_options', 'schedule', 'schedule_menu_page', '', 6
    );
}

function schedule_menu_page()
{
    $parser = new Parser_s();

    if (isset($_GET['q'])) {
        $schedule = get_post_meta($_GET['q'], 'schedule');
        //s_prn($schedule);
        $schedule = json_decode(stripslashes($schedule[0]), true);
        if (empty($schedule)) {
            $schedule = fillSchedule();
        }
        echo $parser->render(PL_DIR . 'views/admin_q.php', [
            'schedule' => $schedule
        ]);
    } else {
        $args = array(
            'post_type' => 'quest',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $my_query = null;
        $my_query = new WP_Query($args);


        echo $parser->render(PL_DIR . 'views/admin_main.php', [
            'my_query' => $my_query,
        ]);
    }
}

add_action('admin_menu', 'register_schedule_menu_page');

/**
 * Сохранение расписания
 */
// AJAX ACTION
add_action('wp_ajax_save_schedule', 'save_schedule');
add_action('wp_ajax_nopriv_save_schedule', 'save_schedule');

function save_schedule()
{
    $arr = $_POST['arr'];
    $arr = json_decode(stripslashes($arr), true);
    s_prn($arr);
    $schedule = [];
    foreach ($arr as $item) {
        $val = trim($item['val']);
        if ($val[0] == '*') {
            $val = substr($val, 1);
        }
        if (isset($item['lock'])) {
            $schedule[$item['week']][$item['day']][] = '*' . $val;
        } else {
            $schedule[$item['week']][$item['day']][] = trim($item['val']);
        }
    }
    $schedule_json = json_encode($schedule, JSON_UNESCAPED_UNICODE);
    $f = add_post_meta($_POST['qID'], 'schedule', $schedule_json, true);
    if (!$f) {
        $f = update_post_meta($_POST['qID'], 'schedule', $schedule_json);
    }
    wp_die();
}

function getDay($number)
{

    if ($number > 7 && $number < 14) {
        $number = $number - 7;
    }
    if ($number >= 14) {
        $number = $number - 14;
    }
    if ($number == 0) {
        $number = 7;
    }
    //s_prn($number);
    switch ($number) {
        case 1:
            return "mo";
        case 2:
            return "tu";
        case 3:
            return "we";
        case 4:
            return "th";
        case 5:
            return "fr";
        case 6:
            return "sa";
        case 7:
            return "su";
    }
}

function getDayRu($number)
{
    if ($number > 7) {
        $number = $number - 7;
    }
    if ($number == 0) {
        $number = 7;
    }
    switch ($number) {
        case 1:
            return "пн";
        case 2:
            return "вт";
        case 3:
            return "ср";
        case 4:
            return "чт";
        case 5:
            return "пт";
        case 6:
            return "сб";
        case 7:
            return "вс";
    }
}

function getDayRuAll($number)
{
    if ($number > 7 && $number <= 14) {
        $number = $number - 7;
    }
    if ($number > 14) {
        $number = $number - 14;
    }
    if ($number == 0) {
        $number = 7;
    }
    switch ($number) {
        case 1:
            return "понедельник";
        case 2:
            return "вторник";
        case 3:
            return "среда";
        case 4:
            return "четверг";
        case 5:
            return "пятница";
        case 6:
            return "суббота";
        case 7:
            return "воскресенье";
    }
}


function getEmptySchedule()
{
    return [
        1 => [
            'mo' => [],
            'tu' => [],
            'we' => [],
            'th' => [],
            'fr' => [],
            'sa' => [],
            'su' => [],
        ],
        2 => [
            'mo' => [],
            'tu' => [],
            'we' => [],
            'th' => [],
            'fr' => [],
            'sa' => [],
            'su' => [],
        ]
    ];
}

function getDefaultPrice()
{
    return '3500';
}

function fillSchedule()
{
    $arr = [];
    foreach (getEmptySchedule() as $w_key => $week) {
        foreach ($week as $d_key => $day) {
            $arr[$w_key][$d_key] = [
                '10:30 - ' . getDefaultPrice(),
                '12:00 - ' . getDefaultPrice(),
                '13:30 - ' . getDefaultPrice(),
                '15:00 - ' . getDefaultPrice(),
                '16:30 - ' . getDefaultPrice(),
                '18:00 - ' . getDefaultPrice(),
                '19:30 - ' . getDefaultPrice(),
                '21:00 - ' . getDefaultPrice(),
                '23:30 - ' . getDefaultPrice(),
                '00:00 - ' . getDefaultPrice(),
                '01:30 - ' . getDefaultPrice(),
                '03:00 - ' . getDefaultPrice(),
            ];
        }
    }
    return $arr;
}

/**
 * Вывод расписания front
 */
function scheduleShortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'id' => 1,
        ), $atts, 'schedule');

    $parser = new Parser_s();
    $schedule = get_post_meta($atts['id'], 'schedule');
    //s_prn($schedule);
    $schedule = json_decode(stripslashes($schedule[0]), true);
    if (empty($schedule)) {
        $schedule = getEmptySchedule();
    }
    echo $parser->render(PL_DIR . 'views/schedule_new.php', [
        'schedule' => $schedule,
        'qId' => $atts['id'],
        'parser' => $parser
    ]);
}

add_shortcode('schedule', 'scheduleShortcode');

/**
 * Активация плагина
 */
function schedule_install()
{
    global $wpdb;

    $table_name = $wpdb->prefix . "schedule_orders";
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {

        $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  dt_add bigint(11) DEFAULT '0' NOT NULL,
	  q_id bigint(11) DEFAULT '0' NOT NULL,
	  name tinytext NOT NULL,
	  email VARCHAR(255) NOT NULL,
	  phone VARCHAR(255) NOT NULL,
	  time_price VARCHAR(255) NOT NULL,
	  q_date VARCHAR(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'schedule_install');

/**
 * Добавление брони
 */
// AJAX ACTION
add_action('wp_ajax_add_lock', 'add_lock');
add_action('wp_ajax_nopriv_add_lock', 'add_lock');

function add_lock()
{
    global $wpdb;
    $parser = new Parser_s();

    $wpdb->insert($wpdb->prefix . "schedule_orders", [
        'dt_add' => time(),
        'q_id' => $_POST['qID'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'time_price' => $_POST['val'],
        'q_date' => $_POST['q_date']
    ]);

    $msg = $parser->render(PL_DIR . 'views/eot.php', [
        'name' => $_POST['name'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email']
    ], false);

    add_filter('wp_mail_content_type', 'set_html_content_type');

    wp_mail(get_option('admin_email'), 'Бронирование квеста', $msg);

    remove_filter('wp_mail_content_type', 'set_html_content_type');

    wp_die();
}

/**
 * Добавляем страницу в админку (бронь)
 */
function register_orders_menu_page()
{
    add_menu_page(
        'Бронь квесты', 'Бронь квесты', 'manage_options', 'q_orders', 'q_orders_menu_page', '', 6
    );
}

function q_orders_menu_page()
{
    global $wpdb;
    $parser = new Parser_s();

    $res = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'schedule_orders' . ' ORDER BY id DESC', OBJECT_K);

    $parser->render(PL_DIR . 'views/admin_orders.php', ['res' => $res]);

}

add_action('admin_menu', 'register_orders_menu_page');

function set_html_content_type()
{
    return 'text/html';
}

function getSmartDate($day)
{
    $numDay = date('w');
    if ($numDay == 0) {
        $numDay = 7;
    }
    $dayInSec = 60 * 60 * 24;
    $date = $numDay - $day;
    return time() - ($date * $dayInSec);
}

/**
 * Передача расписания API
 */
function scheduleApiShortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'id' => 1,
        ), $atts, 'schedule-api');

    $schedule = get_post_meta($atts['id'], 'schedule');
    $schedule = json_decode(stripslashes($schedule[0]), true);
    $i = 1;
    $arr = [];
    foreach ($schedule as $item) {
        foreach ($item as $day) {
            if (!empty($day[0])) {
                $j = 0;
                foreach ($day as $val) {
                    if (!empty($val)) {
                        $date = (date('Y-m-d', getSmartDate($i)));
                        $d = explode('-', $day[$j]);
                        $dp = explode(' ', trim($d[1]));

                        $is_free = true;
                        if ($d[0][0] == '*') {
                            $is_free = false;
                        }
                        if ($d[0][0] == '*') {
                            $d[0] = substr($d[0], 1);
                        }
                        $arr[] =
                            [
                                'date' => $date,
                                'time' => $d[0],
                                'is_free' => $is_free,
                                'price' => $dp[0],
                                'your_slot_id' => $atts['id'],
                            ];
                    }
                    $j++;
                }
            }
            $i++;
        }
    }
    echo(json_encode($arr, JSON_UNESCAPED_UNICODE));
}

add_shortcode('schedule-api', 'scheduleApiShortcode');

/**
 * @param $atts
 * Бронирование через API
 */

function getBook($atts)
{
    $atts = shortcode_atts(
        array(
            'date' => '2016-05-31',
            'time' => '15:30',
            'price' => '4500',
            'id' => 7
        ), $atts, 'schedule-get');

    $schedule = get_post_meta($atts['id'], 'schedule');
    $schedule = json_decode(stripslashes($schedule[0]), true);
    //s_prn($schedule);
    $i = 1;
    $arr = [];
    $week = 1;
    $flag = 0;
    $scheduleNew = [];
    foreach ($schedule as $item) {
        $dayCount = 1;
        foreach ($item as $k => $day) {
            if (!empty($day[0])) {
                $j = 0;
                foreach ($day as $val) {
                    if (!empty($val)) {

                        $date = (date('Y-m-d', getSmartDate($i)));

                        $d = explode('-', $day[$j]);
                        /*s_prn($date . ' - ' . $atts['date']);
                        s_prn( $d[0][0] .' - ' . '*');
                        s_prn(trim($d[0]) . ' - ' . $atts['time']);*/
                        if ($date == $atts['date'] and $d[0][0] != '*' and trim($d[0]) == $atts['time']) {
                            $val = '*' . $val;
                            $flag = 1;
                        }

                        $is_free = true;
                        if ($d[0][0] == '*') {
                            $is_free = false;
                        }
                        if ($d[0][0] == '*') {
                            $d[0] = substr($d[0], 1);
                        }

                        $arr[] =
                            [
                                'date' => $date,
                                'time' => $d[0],
                                'is_free' => $is_free,
                                'price' => $d[1],
                                'your_slot_id' => strtotime($date . ' ' . $d[0]),
                            ];

                        $scheduleNew[$week][$k][] = $val;
                    }
                    $j++;
                }
            } else {
                $scheduleNew[$week][$k] = [0 => ''];
            }
            $i++;
            $dayCount++;
        }
        $week++;
    }
    $scheduleNew = json_encode($scheduleNew, JSON_UNESCAPED_UNICODE);
    //s_prn($scheduleNew);
    $f = add_post_meta($atts['id'], 'schedule', $scheduleNew, true);
    if (!$f) {
        $f = update_post_meta($atts['id'], 'schedule', $scheduleNew);
    }
    if ($flag) {
        echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['success' => false, "message" => 'Занят'], JSON_UNESCAPED_UNICODE);
    }
}

add_shortcode('schedule-get', 'getBook');

function getMonth($monthNumber = false)
{
    if ($monthNumber) {
        $m = $monthNumber;
    } else {
        $m = date('m');
    }
    switch ($m) {
        case '01':
            return "января";
        case '02':
            return "февраля";
        case '03':
            return "марта";
        case '04':
            return "апреля";
        case '05':
            return "мая";
        case '06':
            return "июня";
        case '07':
            return "июля";
        case '08':
            return "августа";
        case '09':
            return "сентября";
        case '10':
            return "октября";
        case '11':
            return "ноября";
        case '12':
            return "декабря";
    }
}

function getScheduleToDay($id, $day, $week)
{
    $schedule = get_post_meta($id, 'schedule');
    $schedule = json_decode(stripslashes($schedule[0]), true);
    $day = ($day == 0) ? 7 : $day;
    if ($day > 7 && $week == 1) {
        $day = $day - 7;
    }
    if ($day > 7 && $day <= 14 && $week == 2) {
        $day = $day - 7;
    }
    if ($day > 14 && $week == 2) {
        $day = $day - 14;
    }
    $day = getDay($day);
    return $schedule[$week][$day];
}

function getDayFor7($count)
{
    //s_prn($count);
    $time = time() + 60 * 60 * 24 * $count;
    return date('d', $time);
}

function getMonthFor7($count)
{
    $time = time() + 60 * 60 * 24 * $count;
    return date('m', $time);
}

function getScheduleOneDay()
{
    $parser = new Parser_s();
    $args = array(
        'post_type' => 'quest',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $my_query = null;
    $my_query = new WP_Query($args);


    echo $parser->render(PL_DIR . '/views/schedule_one_day.php', [
        'my_query' => $my_query,
    ]);
}
add_shortcode('one_day', 'getScheduleOneDay');

function dayOff($today)
{
    $time = (time() + 60 * 60 * 24 * $today);
    return date('w', $time);
}

function dayToday($today)
{
    $time = ( time() + 60 * 60 * 24 * $today ) - ( 60 * 60 * 24 );
    return date('d', $time);
}

function getToMonth($today)
{
    $time = (time() + 60 * 60 * 24 * $today);
    return date('m', $time);
}

function extraFieldsQuestDescription($post)
{
    ?>
    <p>
        <span>Описание: </span>
        <input type="text" name='extra[desc]' style="width: 100%"  value="<?php echo get_post_meta($post->ID, "desc", 1); ?>">
    </p>
    <?php
}

function extraFieldsQuest()
{
    add_meta_box('extra_desc', 'Описание', 'extraFieldsQuestDescription', 'quest', 'normal', 'high');
}

add_action('add_meta_boxes', 'extraFieldsQuest', 1);

/* Сохраняем данные, при сохранении поста */
add_action('save_post', 'myExtraFieldsUpdate', 10, 1);
function myExtraFieldsUpdate($post_id)
{
    if (!isset($_POST['extra'])) return false;
    foreach ($_POST['extra'] as $key => $value) {
        if (empty($value)) {
            delete_post_meta($post_id, $key); // удаляем поле если значение пустое
            continue;
        }

        update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
    }
    return $post_id;
}


