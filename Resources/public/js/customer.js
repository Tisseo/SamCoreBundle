require(['jquery'], function() {
    $(".customer-row").each(function() {
        $(".customer-token[customer-id='" + $(this).attr('customer-id') + "']").each(function(){
            $("tr", $(this)).each(function(){
//                $(this).display();
            });
        });
    });
});