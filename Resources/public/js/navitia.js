define('navitia', ['routing'], function(Routing,Translator) {
    var self = {};
    var _url = null;
    console.log(Routing);
   // var $msgWrapperTpl = utils.getTpl('msgWrapperTpl');
    var $msgWrapperTpl = $('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>')

    var _set_url = function(route, params)
    {
        _url = Routing.generate(
            route,
            params
        );
    }

    self.getCoverageNetworks = function(route, params, callback, callbackFail)
    {
        _set_url(route, params);
        $.get(_url,
        function(data, status, xhr){
            callback(data.networks);
        }).fail(function() {
            var msg = Translator.trans('network.error.wrong_token', {}, 'message');

            $msgWrapperTpl.empty().append('<div>' + msg + '</div>');
            $('.modal-header').after($msgWrapperTpl);
            callbackFail();
        });
    };

    return function Navitia(){
        return self;
    };
});
