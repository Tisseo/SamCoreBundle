define('navitia', ['jquery', 'utils', 'translations/messages'], function($, utils) {
    var self = {};
    var _url = null;
    var $msgWrapperTpl = utils.getTpl('msgWrapperTpl');

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
        $.get(_url, function(data){
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
    }
});
