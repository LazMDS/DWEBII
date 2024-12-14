// Store current expenses for selected month
let currentExpenses = [];

// Function to render expenses
function renderExpenses() {
    const expenseItems = document.getElementById('expenseItems');
    expenseItems.innerHTML = ''; // Clear existing rows

    currentExpenses.forEach((expense, index) => {
        const expenseRow = document.createElement('div');
        expenseRow.classList.add('row', 'mb-2');

        expenseRow.innerHTML = `
            <div class="col-4"><input type="text" class="form-control" value="${expense.categoria}"></div>
            <div class="col-4"><input type="text" class="form-control" value="${expense.descricao}"></div>
            <div class="col-2"><input type="number" class="form-control" value="${expense.peso}"></div>
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
        <div class="col-2 d-flex justify-content-start">
            <button class="btn add edit" onclick="addExpense()">+</button>
        </div>
    `;

    expenseItems.appendChild(addButtonRow);

    updateTotal();
}

// Function to add a new expense
function addExpense() {
    currentExpenses.push({ categoria: '', descricao: '', peso: 0 });
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

// Add a new expense when clicking the add button
document.querySelector('.add').addEventListener('click', addExpense);