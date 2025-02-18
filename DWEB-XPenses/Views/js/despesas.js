document.addEventListener("DOMContentLoaded", function () {
  const dateFilterInput = document.getElementById("dateFilter");

  if (!dateFilterInput) {
    console.error("Elemento #dateFilter não encontrado.");
    return;
  }

  // Executar a busca assim que a página carregar, trazendo despesas do mês atual
  fetchExpenses();

  // Adiciona um evento para detectar mudanças no input
  dateFilterInput.addEventListener("change", function () {
    fetchExpenses();
  });

  document
    .getElementById("addExpenseBtn")
    .addEventListener("click", function (event) {
      event.preventDefault();
      addNewExpenseRow();
    });
});

function fetchExpenses() {
  const dateFilterInput = document.getElementById("dateFilter");

  if (!dateFilterInput) {
    console.error("Elemento #dateFilter não encontrado.");
    return;
  }

  const dateFilter = dateFilterInput.value; // Exemplo de valor: "2025-01"
  if (!dateFilter) {
    console.warn("Nenhuma data selecionada.");
    return;
  }

  // Extrai o ano e o mês corretamente
  const [year, month] = dateFilter.split("-");

  console.log(`Buscando despesas para: ${month}/${year}`); // Debug no console

  fetch(
    `../Controller/ExpenseController.php?action=getByMonthYear&month=${month}&year=${year}`
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success" && Array.isArray(data.data)) {
        renderExpenses(data.data); // Pegando apenas o array de despesas
        updateTotal();
      } else {
        console.error("Erro ao carregar despesas:", data.message);
      }
    });
}

let expenseCounter = 1;

function renderExpenses(expenses) {
  const expenseItems = document.getElementById("expenseItems");

  if (!Array.isArray(expenses)) {
    console.error(
      "Erro: renderExpenses esperava um array, mas recebeu:",
      expenses
    );
    return;
  }
  expenseItems.innerHTML = "";

  expenses.forEach((expense) => {
    let counter = expenseCounter++;

    let newRow = document.createElement("div");
    newRow.classList.add("row", "mb-2", "existing-expense");
    newRow.id = `expense-row-${counter}`;

    newRow.innerHTML = `
        <input type="hidden" id="db-id-${counter}" value="${expense.id_Expense}">
        <div class="col-4">
          <input type="text" class="form-control" value="${expense.description}" id="desc-${counter}">
        </div>
        <div class="col-4">
        <input type="text" class="form-control" value="${expense.category_id}" id="cat-${counter}">
      </div>
        <div class="col-3">
        <input type="number" class="form-control" value="${expense.amount}" id="amount-${counter}" >
        </div>
        <div class="col-2 d-flex">
          <button class="btn edit editar" type="button" onclick="saveExpense(${counter}, event)">
            <a  href="https://icons8.com/icon/59856/lápis"></a>
            <a href="">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=">
            </a>          
          </button>
            <button class="btn delete" type="button" onclick="deleteExpense(${counter}, event)">
                <a  href="https://icons8.com/icon/59856/lápis"></a>
                <a href="">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA3ElEQVR4nM3UsQ3CMBAF0ItdgChyFykFqdIgnZMKmAAaIkHNArAFbAAl1CwAA2SBlInERiihCDTcQQF86TeW9XSWLQP8JC6Mmn6cFIfW+bO2dLq3Xav3iI5lP/Mc7Q1TaRxeX5aprPda9jMRfKe2nvarMQ4L8bhtCwVIFz1IZxH0GI9a0GM8yBMybdUTMm1kMMG1GkxwJYLWBQstaJNgLoLgcKwFIcGRAgwjNZj2+jIIYAxTpbiQCpZgtY87V0yYgzbNByG9QUc7NQhx3LWM0+cv7KGMExhARw/+U243mZ31loLtywAAAABJRU5ErkJggg==">
                </a>
            </button>
        </div>
      `;
    expenseItems.appendChild(newRow);
  });
}

let counter = 1;

function addNewExpenseRow() {
  let counter2 = counter++;
  let expenseItems = document.getElementById("expenseItems");

  let newRow = document.createElement("div");
  newRow.classList.add("row", "mb-2", "new-expense");
  newRow.id = `expense-row-${counter2}`;

  newRow.innerHTML = `                            
      <div class="col-4">
        <input type="text" class="form-control" id="desc-${counter2}" placeholder="Descrição">
      </div>
      <div class="col-4">
        <input type="text" class="form-control" id="categ-${counter2}" placeholder="Descrição">
      </div>
      <div class="col-3">
      <input type="number" class="form-control" id="amount-${counter2}" placeholder="Valor" >
      </div>
      <div class="col-2 d-flex">
        <button class="btn edit editar" type="button" onclick="saveExpense(${counter2}, event)">
            <a  href="https://icons8.com/icon/59856/lápis"></a>
            <a href="">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=">
            </a>          
        </button>
        <button class="btn delete" type="button" onclick="deleteExpense(${counter2}, event)">
                <a  href="https://icons8.com/icon/59856/lápis"></a>
                <a href="">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA3ElEQVR4nM3UsQ3CMBAF0ItdgChyFykFqdIgnZMKmAAaIkHNArAFbAAl1CwAA2SBlInERiihCDTcQQF86TeW9XSWLQP8JC6Mmn6cFIfW+bO2dLq3Xav3iI5lP/Mc7Q1TaRxeX5aprPda9jMRfKe2nvarMQ4L8bhtCwVIFz1IZxH0GI9a0GM8yBMybdUTMm1kMMG1GkxwJYLWBQstaJNgLoLgcKwFIcGRAgwjNZj2+jIIYAxTpbiQCpZgtY87V0yYgzbNByG9QUc7NQhx3LWM0+cv7KGMExhARw/+U243mZ31loLtywAAAABJRU5ErkJggg==">
                </a>
        </button>      
    </div>
    `;
  expenseItems.appendChild(newRow);
}

function saveExpense(counter, event) {
  if (event) event.preventDefault();

  console.log(`Verificando elementos no DOM para a linha: ${counter}`);

  let idElement = document.getElementById(`db-id-${counter}`);
  let descriptionElement = document.getElementById(`desc-${counter}`);
  let amountElement = document.getElementById(`amount-${counter}`);
  let categoryElement = document.getElementById(`cat-${counter}`);
  let dateElement = document.getElementById("dateFilter"); // Pega a data do input
  let userId = document.getElementById("user_id")?.value;

  if (!descriptionElement || !amountElement || !categoryElement || !dateElement) {
    console.error(`Erro: Elementos não encontrados para o contador ${counter}`);
    alert("Erro: Elementos do formulário não encontrados. Verifique se os IDs estão corretos.");
    return;
  }

  let id = idElement ? idElement.value : "";
  let description = descriptionElement.value;
  let amount = amountElement.value;
  let category = categoryElement.value;
  let date = dateElement.value; // Pega a data do filtro corretamente

  if (!description || !amount || !category || !date) {
    alert("Todos os campos são obrigatórios.");
    return;
  }

  let formData = new URLSearchParams();
  formData.append("description", description);
  formData.append("amount", amount);
  formData.append("category_id", category);
  formData.append("date", date);
  formData.append("user_id", userId);

  let url = id
    ? `../Controller/ExpenseController.php?action=update&id=${id}`
    : "../Controller/ExpenseController.php?action=add"; // Se não tem ID, ele cria uma nova despesa.

  console.log("Enviando para backend:", {
    id,
    description,
    amount,
    category,
    date,
    userId,
  });

  fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: formData.toString(),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Resposta do backend:", data);
      alert(data.message);
      fetchExpenses();
    })
    .catch((error) => console.error("Erro ao salvar despesa:", error));
}


function deleteExpense(counter, event) {
  if (event) event.preventDefault();

  let id = document.getElementById(`db-id-${counter}`)?.value || null;
  let rowElement = document.getElementById(`expense-row-${counter}`);

  if (!rowElement) {
    console.error("Erro: Linha não encontrada!");
    return;
  }

  if (!id) {
    rowElement.remove();
    console.log(`Linha ${counter} removida localmente.`);
    return;
  }

  if (confirm("Tem certeza que deseja excluir esta despesa?")) {
    fetch(`../Controller/ExpenseController.php?action=delete`, {
      method: "DELETE",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ id }),
    })
      .then((response) => response.json())
      .then((data) => {
        alert(data.message);
        fetchExpenses();
      })
      .catch((error) => console.error("Erro ao excluir despesa:", error));
  }
}

function updateTotal() {
  const amounts = document.querySelectorAll("[id^=amount-]");
  let total = 0;
  amounts.forEach((input) => {
    total += parseFloat(input.value) || 0;
  });
  document.querySelector(".tot").value = total.toFixed(2);
}
