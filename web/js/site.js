jQuery(function($) {
    var form,
        taskId,
        pollInt
    ;

    form = $('#quest-form');
    if (form.length == 0) {
        return ;
    }

    taskId = $('#quest-task-id', form).val();

    function checkTaskState() {
        $.ajax({
            type: 'GET',
            url: '/quest/check-state/' + taskId + '/',
            timeout: 2000,
            dataType: 'json',
        }).then(checkTaskStateSuccess, checkTaskStateFail);
    }

    function checkTaskStateSuccess(response) {
        $('#check-state-alert').remove();
        if (typeof response.task_passed !== 'undefined'
            && response.task_passed
        ) {
            clearInterval(pollInt);
            location.href = '/quest/';
        }
    }

    function checkTaskStateFail() {
        if ($('#check-state-alert').length) {
            return;
        }
        $('<div>')
            .addClass('alert alert-warning')
            .attr('role', 'alert')
            .attr('id', 'check-state-alert')
            .text('Увага! Магчыма недаступны інтэрнэт ці адбылася памылка на сэрверы')
            .appendTo($('.body-content'))
        ;
    }

    pollInt = setInterval(checkTaskState, 1000);
});
