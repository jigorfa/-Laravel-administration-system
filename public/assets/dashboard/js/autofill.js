$(document).ready(function () {
    $('#employee_code').on('change', function () {
        var code = $(this).val(); // Obtém o valor do campo Código
        var url = routeGetEmployeeDetails.replace(':code', code);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response) {
                    // Preenche os campos automaticamente
                    $('#employee_name').val(response.name);
                    $('#employee_adjuntancy').val(response.adjuntancy);
                } else {
                    alert('Funcionário não encontrado.');
                    $('#employee_name').val('');
                    $('#employee_adjuntancy').val('');
                }
            },
            error: function () {
                alert('Erro ao buscar os dados do funcionário.');
                $('#employee_name').val('');
                $('#employee_adjuntancy').val('');
            }
        });
    });
});
