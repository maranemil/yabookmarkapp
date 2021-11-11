// noinspection JSUnresolvedFunction

$(document).ready(function () {
    $("[id^='dataTable_']").DataTable({
        // "paging":   false,
        // "ordering": false,
        // "info":     false,
        // "pageLength": 50, 
        "order": [
            [0, "desc"]
        ],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false
        }]
        /*"lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],*/
        /*buttons: [{
            extend: 'excel',
            text: 'Save current page',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            },
        }]*/
    });
});

$(function () {
    const $tabButtonItem = $('#tab-button li'),
        $tabSelect = $('#tab-select'),
        $tabContents = $('.tab-contents'),
        activeClass = 'is-active';

    $tabButtonItem.first().addClass(activeClass);
    $tabContents.not(':first').hide();

    $tabButtonItem.find('a').on('click', function (e) {
        const target = $(this).attr('href');

        $tabButtonItem.removeClass(activeClass);
        $(this).parent().addClass(activeClass);
        $tabSelect.val(target);
        $tabContents.hide();
        $(target).show();
        e.preventDefault();
    });

    $tabSelect.on('change', function () {
        const target = $(this).val(),
            targetSelectNum = $(this).prop('selectedIndex');

        $tabButtonItem.removeClass(activeClass);
        $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
        $tabContents.hide();
        $(target).show();
    });
});