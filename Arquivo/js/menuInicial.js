// Inicializando o gráfico de despesas totais usando Chart.js
function renderPieChart() {
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Gastos', 'Saldo Restante'],
            datasets: [{
                data: [0, 0], // Inicializando com zero, os valores reais serão atualizados
                backgroundColor: ['#28a745', '#c0f1cc'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // gráfico dimensionado de forma flexível 
            plugins: {
                tooltip: { //caixa de informação ao passar o mouse
                    callbacks: {
                        label: function (tooltipItem) {
                            const label = tooltipItem.label || '';
                            const value = tooltipItem.raw || 0;
                            return `${label}: ${value}%`;
                        }
                    }
                }
            }
        }
    });
}


// Função lidar com a mudança do mês selecionado
document.getElementById('monthSelect').addEventListener('change', async function () {
    const selectedMonth = this.value;
    console.log(`Mês selecionado: ${selectedMonth}`);

    if (selectedMonth !== 0) {
       // Irá ficar a parte do backend que vai buscar esses dados referente ao mês.
    }
});

// Função para atualizar os dados no dashboard
function atualizarDadosDashboard(dados) {
    const h3Elements = document.querySelectorAll('.dashboard-card h3');
    
    //total de despesas
    h3Elements[0].textContent = `R$ ${dados.totalDespesas.toFixed(2)}`;
    
    //saldo restante
    h3Elements[1].textContent = `R$ ${dados.saldoRestante.toFixed(2)}`;


    atualizarGrafico(dados.totalDespesas, dados.saldoRestante);
}

// Função para atualizar o gráfico com os dados da nova seleção
function atualizarGrafico(totalDespesas, saldoRestante) {
    const chart = Chart.getChart('pieChart'); // Obtendo o gráfico existente
    if (chart) {
        // Calculando o total
        const total = totalDespesas + saldoRestante;

        // Calculando as porcentagens
        const percentualDespesas = ((totalDespesas / total) * 100).toFixed(2);
        const percentualSaldo = ((saldoRestante / total) * 100).toFixed(2);

        // Atualizando os dados do gráfico
        chart.data.labels = ['Gastos', 'Saldo Restante'];
        chart.data.datasets[0].data = [percentualDespesas, percentualSaldo];
        chart.update();
    }
}

// Mostrar o formulário de adição de despesas
document.getElementById('btnIncluirDespesas').addEventListener('click', function () {
    const formAdicionarDespesas = document.getElementById('formAdicionarDespesas');
    
    if (formAdicionarDespesas.classList.contains('d-none')) {
        formAdicionarDespesas.classList.remove('d-none');
    }else{
        formAdicionarDespesas.classList.add('d-none');
    }
});

// Manipular o formulário de adição de despesas
document.querySelector('#addExpenseButton').addEventListener('click', function () {
    const descricao = document.querySelector('input[placeholder="Descrição"]').value;
    const categoria = document.querySelector('input[placeholder="Categoria"]').value;
    const valor = document.querySelector('input[placeholder="Valor R$"]').value;

    if (descricao && categoria && valor) {
        console.log(`Descrição: ${descricao}, Categoria: ${categoria}, Valor: R$${valor}`);
        // Irá ficar a parte do backend que vai salvar os dados
    } else {
        alert('Por favor, preencha todos os campos.');
    }
});

// Inicialização ao carregar a página
document.addEventListener('DOMContentLoaded', function () {
    renderPieChart();

    atualizarDadosDashboard({
        totalDespesas: 400.00, // Novo valor de despesas
        saldoRestante: 199.70   // Novo valor de saldo
    });
});