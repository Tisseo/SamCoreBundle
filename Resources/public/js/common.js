require(["jquery"], function($) {
    // to prevent modal content to be cached by bootstrap
    $('body').on(
        'hidden.bs.modal',
        '#base-modal',
        function () {
            $(this).removeData('bs.modal');
            $(this).find('.modal-header, .modal-body, .modal-footer').empty();
        }
    );
    // Display area when we have nojs
    $('.force-show-nojs').removeClass('force-show-nojs');
});