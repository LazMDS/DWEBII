// Mock data example (replace this with actual API fetch)
const mockExpensesData = {
    1: [{ descricao: 'Aluguel', categoria: 'Casa', valor: 1500 }],
    2: [{ descricao: 'Supermercado', categoria: 'Alimentação', valor: 300 },{descricao: 'Luz', categoria: 'Casa', valor: 250.00}],
    // Add more data as needed for each month
};

// Store current expenses for selected month
let currentExpenses = [];

// Function to load expenses based on selected month
function loadExpenses(month) {
    currentExpenses = mockExpensesData[month] || [];
    renderExpenses();
}

// Function to render expenses
function renderExpenses() {
    const expenseItems = document.getElementById('expenseItems');
    expenseItems.innerHTML = ''; // Clear existing rows

    currentExpenses.forEach((expense, index) => {
        const expenseRow = document.createElement('div');
        expenseRow.classList.add('row', 'mb-2');

        expenseRow.innerHTML = `
            <div class="col-4"><input type="text" class="form-control" value="${expense.descricao}"></div>
            <div class="col-4"><input type="text" class="form-control" value="${expense.categoria}"></div>
            <div class="col-2"><input type="number" class="form-control" value="${expense.valor}"></div>
            <div class="col-2 d-flex">
                <button class="btn edit me-2 editar" onclick="editExpense(${index}, event)">
                    <a  href="https://icons8.com/icon/59856/lápis"></a>
                    <a href="">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=">
                    </a>
                </button>
                <button class="btn edit" type="button" onclick="deleteExpense(${index}, event)">
                    <a  href="https://icons8.com/icon/59856/lápis"></a>
                    <a href="">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA3ElEQVR4nM3UsQ3CMBAF0ItdgChyFykFqdIgnZMKmAAaIkHNArAFbAAl1CwAA2SBlInERiihCDTcQQF86TeW9XSWLQP8JC6Mmn6cFIfW+bO2dLq3Xav3iI5lP/Mc7Q1TaRxeX5aprPda9jMRfKe2nvarMQ4L8bhtCwVIFz1IZxH0GI9a0GM8yBMybdUTMm1kMMG1GkxwJYLWBQstaJNgLoLgcKwFIcGRAgwjNZj2+jIIYAxTpbiQCpZgtY87V0yYgzbNByG9QUc7NQhx3LWM0+cv7KGMExhARw/+U243mZ31loLtywAAAABJRU5ErkJggg==">
                    </a>
                </button>
            </div>
        `;
        expenseItems.appendChild(expenseRow);
    });

    // Add the dollar button at the end
    const addButtonRow = document.createElement('div');
    addButtonRow.classList.add('row', 'mb-2');

    addButtonRow.innerHTML = `
        <div class="col-1 d-flex justify-content-start">
            <button class="btn add" onclick="addExpense()">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADOUlEQVR4nM2Xz0sUURzA37w3Kqw63++shm1Whrj7vjOCWtOPQ6lFhyCok4eELilIdAiULkVeNLKoLhHSRftxiLLAiJLq1KWUirL/KL5vp92d1Z2Z3Tr04AvDzHvv876/3wjx348+0WITjkqCGUvDgiJcZuFnfmd7OMJz/h0wn+22CG5Igg1J8CtBNiyCeV7TONAXzVLDFUn4PQWwSvAbW0EEoqk+6CCgIlyqHxgVpeGJoPaOdFBq75AEa38LrZB3wney8dBRYafVVGkYUxrPptbcF801uUWfJm60qQhX7IJ71Pbaj0jClyk1n96e2pfdnRRIiuC5yEMvz1UenFQajotCW6fw3H6p4W1SwAndsWsLN0yZuIVfGSI1XmatKzdUGs8IDfukxh9xe1gezFVpK1qS8tTScFP0u3sk4c9tvn8WQS5jabgVe3gN65EiE1akeB9p52LcPKXhhCS8lLSP7eFwOagIZhLBHl435txe43pkuuzfJBMVzfRJ9AAqzz0tCd43CrY0LFQEVsrcJVwRHuxnIwkfhiTBlCJ8lBRUETDhUt3gikh+xSYzHSnIZQR15jj4Uh5+uT5T15YNSXiVK1MauEV4t67gsghvS4LXMXOm2A0pDjpTTicPR5IWmOpEMB1zsDvCd/cm7WOzeyIFRMN67KICng8DarPWd6WdU+ZZ40fpwaRdcA6xSA8mzDtWgEtuVcmcTzjtGgeSJHecy2dUW7gv/B1tSsMzi+ChGOhqNZvmcZAPa54HulotgkVF+CLaqfLZ7vDmEN/e+MRBLsMViKsVFxXhYQ8DWasS1HQ7vCYJZ0uMga5WqfGDJOdcROtUFawob+yCe4xFEq6WzO/BZGS/arAwrXdCETyNNotANCkNj9NfBGAsEji+c5jNy7BQVkOZNQfwYcjWzkGp4YvYMnwny9eVRnLagE1K1QATBKImOISn1TwiDZu6cgSiqZi38QEXkaTgCjgruMG44yJxcB32YC4xz8uptViCcyoRHPgDtTQ8MI0m7uK3ZfAvjIfDbAWuyXwb5c5kabxX+oXJQy/nqUkZDRPsz9CnF/hdEZrZmR5azzAucs5xzhsraVhnnxrzVmj6G+7nTwwp6auVAAAAAElFTkSuQmCC" alt="Adicionar Despesa">
            </button>
        </div>
    `;

    expenseItems.appendChild(addButtonRow);

    updateTotal();
}

// Function to add a new expense
function addExpense() {
    currentExpenses.push({ descricao: '', categoria: '', valor: 0 });
    renderExpenses();
}

// Function to edit an expense
function editExpense(index, event) {
    event.preventDefault(); // Impede o recarregamento da página
    const row = document.querySelectorAll('#expenseItems .row')[index];
    const inputs = row.querySelectorAll('input');

    const editButton = row.querySelector('.editar');
    
    // Ao clicar no botão, chamar a função saveExpense para salvar as alterações
    editButton.onclick = (e) => saveExpense(index, e);
}

// Function to save an edited expense
function saveExpense(index, event) {
    event.preventDefault(); // Impede o recarregamento da página

    const row = document.querySelectorAll('#expenseItems .row')[index];
    const inputs = row.querySelectorAll('input');

    // Atualizar os dados no array currentExpenses
    currentExpenses[index] = {
        descricao: inputs[0].value,
        categoria: inputs[1].value,
        valor: parseFloat(inputs[2].value)
    };

    // Atualizar a tabela para refletir a mudança
    renderExpenses();
    updateTotal();
}

// Function to delete an expense
function deleteExpense(index, event) {
    event.preventDefault(); // Impede o recarregamento da página
    currentExpenses.splice(index, 1);
    renderExpenses();
}

// Function to update the total value
function updateTotal() {
    const total = currentExpenses.reduce((acc, expense) => acc + parseFloat(expense.valor), 0);
    document.querySelector('.tot').value = total.toFixed(2);
}

// Event listener for month selection
document.getElementById('monthSelect').addEventListener('change', function () {
    const selectedMonth = parseInt(this.value);
    if (selectedMonth > 0) {
        loadExpenses(selectedMonth);
    }
});

// Add a new expense when clicking the add button
document.querySelector('.add').addEventListener('click', addExpense);