import $ from 'jquery';

$(function () {
    let $popup = $('#event-popup');

    function showPopup($cell, events) {
        let html = `<div class="event-popup-title">イベント</div><ul class="event-popup-list">`;
        for (let ev of events) {
            html += `<li>
                        <span class="event-popup-time">${ev.time}</span>
                        <a href="${ev.detail_url}" class="event-popup-link">${ev.title}</a>
                    </li>`;
        }
        html += '</ul>';

        $popup.html(html).show();

        // 中央固定表示
        $popup.css({
            position: 'fixed',
            top: '30%',
            left: '50%',
            transform: 'translate(-50%, -30%)',
            zIndex: 1000,
            background: '#fff',
            border: '1px solid #ccc',
            padding: '1em',
            boxShadow: '0 2px 8px rgba(0,0,0,0.3)'
        });
    }

    // クリックで中央固定ポップアップ表示
    $('.calendar td[data-events]').on('click', function (e) {
        e.stopPropagation();
        if ($(this).attr('data-events') === '[]') return;
        let events = JSON.parse($(this).attr('data-events'));
        if (!events.length) return;
        showPopup($(this), events);

        // クリックで外側を押したら消す
        setTimeout(() => {
            $(document).on('click.scheduleFixedPopup', function (ev) {
                if (!$(ev.target).closest('#event-popup').length) {
                    $popup.hide();
                    $(document).off('click.scheduleFixedPopup');
                }
            });
        }, 10);
    });

    // ポップアップ内クリックでイベント遷移は <a href="..."> でOK

    // ポップアップ内クリック時は閉じない
    $popup.on('click', function (e) {
        e.stopPropagation();
    });

    // ===== 強調表示とカーソル変更の追加 =====
    // クリック可能なセル
    $('.calendar td[data-events]').each(function () {
        if ($(this).attr('data-events') !== '[]') {
            $(this).addClass('clickable-cell');
        }
    });

    // スマホ: 画面タップで消す
    $(document).on('touchstart', function (e) {
        if (!$(e.target).closest('#event-popup').length) {
            $popup.hide();
        }
    });
});