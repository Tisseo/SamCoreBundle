define(
    ['jquery', 'translations/messages'],
    function($, translations){

        var perimeterForm = {};

        var $collectionHolder;

        var $btnMsg = Translator.trans('client.add_perimeter', {}, 'messages');
        var $addPerimeterLink = $('<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> ' + $btnMsg + '</button>');

        perimeterForm.init = function()
        {
            $collectionHolder = $('div.perimeters');

            $collectionHolder.append($addPerimeterLink);

            $collectionHolder.data('index', $collectionHolder.find(':input').length);

            $addPerimeterLink.on('click', function(e) {
                e.preventDefault();

                addPerimeterForm($collectionHolder, $addPerimeterLink);
            });
        };

        var addPerimeterForm = function addPerimeterForm($collectionHolder, $addPerimeterLink) {
            var prototype = $collectionHolder.data('prototype');
            var index = $collectionHolder.data('index');
            var $newForm = prototype.replace(/__perimeter_id__/g, index);

            $collectionHolder.data('index', index + 1);
            $addPerimeterLink.before($newForm);
        }

        return perimeterForm;
    }
);
