define(
    ['jquery', 'navitia', 'translations/messages'],
    function($, Navitia){

        var $navApi = new Navitia();
        var perimeterForm = {};

        var $collectionHolder;

        var $btnMsg = Translator.trans('customer.add_perimeter', {}, 'messages');
        var $addPerimeterLink = $('<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> ' + $btnMsg + '</button>');

        perimeterForm.init = function()
        {
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

            $('#customer_navitiaToken').on('focusout', function(e) {
                if (e.which == 17) { //17 = CTRL
                    return;
                }
                perimeterForm.checkNavitiaToken();
            });
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
            $('#customer_perimeters_' + index + '_external_coverage_id').parent().parent().find('.delete-item').click(function(){
                $('#perimeter_' + index).remove();
            });
            $('#customer_perimeters_' + index + '_external_coverage_id').change(function(){
                perimeterElements = [];
                perimeterElements[index] = [];

                perimeterElements[index]['net'] = $('#customer_perimeters_' + index + '_external_network_id');
                perimeterElements[index]['cov'] = $(this);

                perimeterElements[index]['cov'].css('background-color', 'none');
                perimeterElements[index]['net'].css('background-color', 'none');
                $(perimeterElements[index]['cov'].parent().parent().children('.error')).text('');
                $(perimeterElements[index]['cov'].parent().parent().children('.error')).hide();

                var $networkSelect = $('#customer_perimeters_' + index + '_external_network_id');
                // keep selected value when refreshing network list
                if ($networkSelect.val() != '') {
                    var previousValue = $networkSelect.val();
                }
                $navApi.getCoverageNetworks(
                    'canal_tp_sam_network_list_json',
                    {
                        'externalCoverageId': $(this).val()
                    },
                    function(networks){
                        var network = null;
                        $networkSelect.empty();
                        $networkSelect.append('<option disabled="disabled" selected="selected" value="">' + Translator.trans('global.please_choose', {}, 'messages') + '</option>');
                        for (key in networks) {
                            $networkSelect.append('<option value="' + key + '">' + networks[key] + '</option>');
                        }
                        if (previousValue) {
                            $networkSelect.find('option[value="' + previousValue + '"]').prop('selected', true);
                        } else {
                            $networkSelect.children().first().prop('selected', true);
                        }
                        $networkSelect.show().siblings('label').show();
                    },
                    function(){
                        $networkSelect.hide().siblings('label').hide();
                });
            });

            $('#customer_perimeters_' + index + '_external_network_id').change(function(){
                perimeterElements = [];
                perimeterElements[index] = [];

                perimeterElements[index]['cov'] = $('#customer_perimeters_' + index + '_external_coverage_id');
                perimeterElements[index]['net'] = $(this);

                extCoverageId = $('#customer_perimeters_' + index + '_external_coverage_id').val();
                extNetworkId = $('#customer_perimeters_' + index + '_external_network_id').val();
                customerToken = $('#customer_navitiaToken').val();

                $navApi.getCoverageNetworks(
                    'canal_tp_sam_network_check_permission_json',
                    {
                        'externalCoverageId': extCoverageId,
                        'externalNetworkId': extNetworkId,
                        'token': customerToken
                    },
                    function(networks){
                        perimeterElements[index]['cov'].css('background-color', 'none');
                        perimeterElements[index]['net'].css('background-color', 'none');
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).text('');
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).hide();
                    },
                    function(){
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).text('Ce token ne vous permet pas d\'accéder à ce réseau');
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).show();
                        perimeterElements[index]['cov'].css('background-color', '#f67074');
                        perimeterElements[index]['net'].css('background-color', '#f67074');
                    }
                );
            });
        }

        var onChangeNetwork =

        perimeterForm.checkNavitiaToken = function() {
            perimeterElements = [];
            $('div[id^=perimeter_]').each(function (index, element) {
                extCoverageId = $('#customer_perimeters_' + $(element).attr('perimeter-index') + '_external_coverage_id').val();
                extNetworkId = $('#customer_perimeters_' + $(element).attr('perimeter-index') + '_external_network_id').val();
                customerToken = $('#customer_navitiaToken').val();

                perimeterElements[index] = [];
                perimeterElements[index]['cov'] = $('#customer_perimeters_' + $(element).attr('perimeter-index') + '_external_coverage_id');
                perimeterElements[index]['net'] = $('#customer_perimeters_' + $(element).attr('perimeter-index') + '_external_network_id');

                $navApi.getCoverageNetworks(
                    'canal_tp_sam_network_check_permission_json',
                    {
                        'externalCoverageId': extCoverageId,
                        'externalNetworkId': extNetworkId,
                        'token': customerToken
                    },
                    function(networks){
                        perimeterElements[index]['cov'].css('background-color', 'none');
                        perimeterElements[index]['net'].css('background-color', 'none');
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).text('');
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).hide();
                    },
                    function(){
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).text('Ce token ne vous permet pas d\'accéder à ce réseau');
                        $(perimeterElements[index]['cov'].parent().parent().children('.error')).show();
                        perimeterElements[index]['cov'].css('background-color', '#f67074');
                        perimeterElements[index]['net'].css('background-color', '#f67074');
                    }
                );
            });
        };

        return perimeterForm;
    }
);
