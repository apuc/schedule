jQuery(document).ready(function ($) {
    $('.add_item').on('click', function(){
        $('.add_item').each(function(){
            $(this).removeClass('add_item_active');
        });
        $('#myModal').modal('show');
        $(this).addClass('add_item_active');
        return false;
    });

    $('.schedule-add').on('click', function(){
        var qTime = $('#qTime').val();
        var qPrice = $('#qPrice').val();
        var item = '<span class="schedule-wrap-week-day--item"><span> ' + qTime + ' - ' + qPrice + '</span></span>';
        $(item).insertBefore(".add_item_active");
        $('#myModal').modal('hide');
    });

    $('.lock-add').on('click', function(){
        $('.active-item').addClass('lock');
        var qName = $('#qName').val();
        var qPhone = $('#qPhone').val();
        var qEmail = $('#qEmail').val();
        var qId = $('.schedule-front').data('q');
        var val = $('.active-item').find('span').html();
        var qDate = $('.active-item').data('date');
        var arr = {};
        var i = 0;
        $('.schedule-front-week-day--item').each(function(){
            var week = $(this).parent().parent().data('week');
            var day = $(this).parent().data('day');
            if(!$(this).hasClass('empty-item')){
                if($(this).hasClass('lock')){
                    arr[i] = {week:week, day:day, val:$(this).find('span').html(), lock:1};
                }
                else {
                    arr[i] = {week:week, day:day, val:$(this).find('span').html()};
                }
            }
            else {
                arr[i] = {week:week, day:day};
            }
            i++;
        });

        arr = JSON.stringify(arr);
        console.log(arr);

        $.ajax({
            url: myajax.url, //url, к которому обращаемся
            type: "POST",
            data: "action=save_schedule&qID=" + qId + "&arr=" + arr ,
            success: function (data) {
                console.log(data);
            }
        });

        $('#myModal').modal('hide');

        $.ajax({
            url: myajax.url, //url, к которому обращаемся
            type: "POST",
            data: "action=add_lock&qID=" + qId + "&name=" + qName + '&email=' + qEmail + '&phone=' + qPhone + '&val=' + val + '&q_date=' + qDate,
            success: function (data) {
                console.log(data);
            }
        });
    });

    $('.schedule-front-week-day--item').on('click', function(){

        $('.schedule-front-week-day--item').each(function(){
            $(this).removeClass('active-item');
        });
        $(this).addClass('active-item');
        if(!$(this).hasClass('lock')){
            $('#myModal').modal('show');
        }

    });

    $('#save_schedule').on('click', function(){
        var qId = $('.schedule-wrap').data('q');
        var arr = {};
        var i = 0;
        $('.schedule-wrap-week-day--item').each(function(){
            var week = $(this).parent().parent().data('week');
            var day = $(this).parent().data('day');

            if(!$(this).hasClass('add_item')){
                //console.log(week + ' - ' + day + ' - ' + $(this).html());
                arr[i] = {week:week, day:day, val:$(this).find('span').html()};
            }
            else {
                arr[i] = {week:week, day:day};
            }
            i++;
        });
        console.log(arr);
        arr = JSON.stringify(arr);

        $.ajax({
            url: ajaxurl, //url, к которому обращаемся
            type: "POST",
            data: "action=save_schedule&qID=" + qId + "&arr=" + arr ,
            success: function (data) {
                console.log(data);
            }
        });
        return false;
    });

    $('.icon-del').on('click', function(){
        $(this).parent().remove();
    });

    $('.icon-unlock').on('click', function(){
        var val = $(this).parent().find('span').html();
        val = val.slice(1);
        console.log(val);
        $(this).parent().find('span').html(val);
        $(this).remove();
    });
});