define(
    ['jquery', 'navitia', 'translations/messages'],
    function($, Navitia){

        var $navApi = new Navitia();
        var perimeterForm = {};

        var $collectionHolder;
        var $navitiaToken;

        var $btnMsg = Translator.trans('client.add_perimeter', {}, 'messages');
        var $addPerimeterLink = $('<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> ' + $btnMsg + '</button>');

        perimeterForm.init = function(navitiaToken)
        {
            $navitiaToken = navitiaToken
            $collectionHolder = $('div.perimeters');

            $collectionHolder.append($addPerimeterLink);
            $collectionHolder.data('index', $collectionHolder.children().length - 1);
            $addPerimeterLink.on('click', function(e) {
                e.preventDefault();
                addPerimeterForm($collectionHolder, $addPerimeterLink);
            });
            for (var i = ($collectionHolder.data('index') - 1); i >= 0; i--) {
                initPerimeterForm(i);
            };
        };

        var addPerimeterForm = function addPerimeterForm($collectionHolder, $addPerimeterLink) {
            var prototype = $collectionHolder.data('prototype');
            var index = $collectionHolder.data('index');
            var $newForm = prototype.replace(/__perimeter_id__/g, index);

            $collectionHolder.data('index', index + 1);
            $addPerimeterLink.before($newForm);
            initPerimeterForm(index);
        }

        var initPerimeterForm = function addPerimeterForm(index) {
            $('#client_perimeters_' + index + '_external_coverage_id').parent().parent().find('.delete-item').click(function(){
                $('#perimeter-' + index).remove();
            });
            $('#client_perimeters_' + index + '_external_coverage_id').change(function(){
                    var $networkSelect = $('#client_perimeters_' + index + '_external_network_id');
                    // keep selected value when refreshing network list
                    if ($networkSelect.val() != '') {
                        var previousValue = $networkSelect.val();
                    }
                    $navApi.getCoverageNetworks(
                        'canal_tp_sam_network_list_json',
                        {
                            'externalCoverageId': $(this).val(),
                            'token': $navitiaToken
                        },
                        function(networks){
                            var network = null;
                            $networkSelect.empty();
                            for (key in networks) {
                                $networkSelect.append('<option value="' + key + '">' + networks[key] + '</option>');
                            }
                            if (previousValue) {
                                $networkSelect.find('option[value="' + previousValue + '"]').prop('selected', true);
                            }
                            $networkSelect.show().siblings('label').show();
                        },
                        function(){
                            $networkSelect.hide().siblings('label').hide();
                    }
                );
            });
        }



        return perimeterForm;
    }
);
