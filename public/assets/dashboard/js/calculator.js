function validateForm() {
    const salary = document.getElementById('salary').value;

    const extraHourPercentage = document.getElementById('extra_hour_percentage').value;

    const monthlyWorkload = document.getElementById('monthly_workload').value;

    const extraHours = document.getElementById('extra_hours').value;

    if (isNaN(salary) || salary <= 0) {
        alert('Por favor, insira um salário bruto válido (número positivo).');
        return false;
    }

    if (isNaN(extraHourPercentage) || extraHourPercentage < 0) {
        alert('Por favor, insira uma porcentagem válida para as horas extras (número não negativo).');
        return false;
    }

    if (isNaN(monthlyWorkload) || monthlyWorkload <= 0) {
        alert('Por favor, insira uma carga horária mensal válida (número positivo).');
        return false;
    }

    const timeParts = extraHours.split(':');
    if (timeParts.length !== 2 || isNaN(timeParts[0]) || isNaN(timeParts[1]) || timeParts[0] < 0 || timeParts[1] < 0 || timeParts[1] > 59) {
        alert('Por favor, insira uma quantidade de horas extras válida no formato HH:MM.');
        return false;
    }

    document.querySelector('.loading').style.display = 'inline-block';


    return true;
}