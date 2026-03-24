$(document).ready(function() {
    // 1. Показ/Приховування при зміні перевізника з плавним розгортанням
    $('#shipping_method').on('change', function() {
        if ($(this).val() === 'Nova Poshta') {
            $('#nova-poshta-fields').hide().removeClass('d-none').slideDown(400);
        } else {
            $('#nova-poshta-fields').slideUp(400, function() {
                $(this).addClass('d-none');
            });
        }
    }).trigger('change');

    // 2. Ініціалізація міст
    $('#city-select').select2({
        placeholder: "Search for a city",
        minimumInputLength: 2,
        ajax: {
            url: '/novaposhta/cities',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return { id: item.Ref, text: item.Description };
                    })
                };
            },
            cache: true
        }
    });

    // 3. Налаштування відділень після вибору міста
    $('#city-select').on('select2:select', function (e) {
        let selectedCityRef = e.params.data.id;

        // Розблоковуємо вибір відділень та очищаємо його
        $('#warehouse-select').prop('disabled', false).val(null).trigger('change');

        // Ініціалізуємо Select2 для відділень
        $('#warehouse-select').select2({
            placeholder: "Select a warehouse",
            ajax: {
                url: '/novaposhta/warehouses',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        cityRef: selectedCityRef,
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return { id: item.Ref, text: item.Description };
                        })
                    };
                },
                cache: true
            }
        });
    });
});