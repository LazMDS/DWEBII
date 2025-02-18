document.addEventListener("DOMContentLoaded", function () {
  fetchCategories();

  let addCategoryButton = document.getElementById("addCategoryBtn");
  if (addCategoryButton) {
    addCategoryButton.addEventListener("click", function (event) {
      event.preventDefault();
      addNewCategoryRow();
    });
  } else {
    console.error("Erro: Botão de adicionar categoria não encontrado!");
  }
});

let categoryCounter = 1; // Contador para IDs do frontend

function fetchCategories() {
  fetch("../Controller/CategoryController.php?action=getAll")
    .then((response) => {
      if (!response.ok) throw new Error("Erro na resposta do servidor");
      return response.text();
    })
    .then((text) => {
      console.log("Resposta bruta do servidor:", text); // Debug
      return JSON.parse(text);
    })
    .then((data) => {
      let tableBody = document.getElementById("categoryItems");
      tableBody.innerHTML = ""; // Limpa todas as categorias carregadas

      data.forEach((category) => {
        let counter = categoryCounter++; // Gera um ID para o frontend

        let newRow = document.createElement("div");
        newRow.classList.add("row", "mb-2", "existing-category");
        newRow.id = `category-row-${counter}`; // ID da linha no frontend

        newRow.innerHTML = `
                  <input type="hidden" id="db-id-${counter}" value="${category.id_Category}">
                  <div class="col-4">
                      <input type="text" class="form-control" value="${category.name}" id="name-${counter}">
                  </div>
                  <div class="col-4">
                      <input type="text" class="form-control" value="${category.description}" id="description-${counter}">
                  </div>
                  <div class="col-2">
                      <input type="number" class="form-control" value="${category.weight}" id="weight-${counter}" min="1" max="5">
                  </div>
                  <div class="col-2 d-flex">
                      <button class="btn edit editar" type="button" onclick="saveCategory(null, ${counter}, event)">
                        <a  href="https://icons8.com/icon/59856/lápis"></a>
                        <a href="">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=">
                        </a>
                      </button>

                      <button class="btn edit delete" type="button" onclick="deleteCategoryRow(null, ${counter}, event)">
                        <a  href="https://icons8.com/icon/59856/lápis"></a>
                        <a href="">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA3ElEQVR4nM3UsQ3CMBAF0ItdgChyFykFqdIgnZMKmAAaIkHNArAFbAAl1CwAA2SBlInERiihCDTcQQF86TeW9XSWLQP8JC6Mmn6cFIfW+bO2dLq3Xav3iI5lP/Mc7Q1TaRxeX5aprPda9jMRfKe2nvarMQ4L8bhtCwVIFz1IZxH0GI9a0GM8yBMybdUTMm1kMMG1GkxwJYLWBQstaJNgLoLgcKwFIcGRAgwjNZj2+jIIYAxTpbiQCpZgtY87V0yYgzbNByG9QUc7NQhx3LWM0+cv7KGMExhARw/+U243mZ31loLtywAAAABJRU5ErkJggg==">
                        </a>
                      </button>
                  </div>
              `;

        tableBody.appendChild(newRow);
      });
    })
    .catch((error) => console.error("Erro ao buscar categorias:", error));
}

function addNewCategoryRow() {
  let counter = categoryCounter++; // Novo ID apenas no frontend

  let tableBody = document.getElementById("categoryItems");

  let newRow = document.createElement("div");
  newRow.classList.add("row", "mb-2", "new-category");
  newRow.id = `category-row-${counter}`; // ID da linha no frontend

  newRow.innerHTML = `
        <div class="col-4">
            <input type="text" class="form-control" id="name-${counter}">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" id="description-${counter}">
        </div>
        <div class="col-2">
            <input type="number" class="form-control" id="weight-${counter}" min="1" max="5">
        </div>
        <div class="col-2 d-flex">
            <button class="btn edit editar" type="button" onclick="saveCategory(null, ${counter}, event)">
              <a  href="https://icons8.com/icon/59856/lápis"></a>
              <a href="">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=">
              </a>
            </button>
            <button class="btn edit delete" type="button" onclick="deleteCategoryRow(null, ${counter}, event)">
                <a  href="https://icons8.com/icon/59856/lápis"></a>
                <a href="">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA3ElEQVR4nM3UsQ3CMBAF0ItdgChyFykFqdIgnZMKmAAaIkHNArAFbAAl1CwAA2SBlInERiihCDTcQQF86TeW9XSWLQP8JC6Mmn6cFIfW+bO2dLq3Xav3iI5lP/Mc7Q1TaRxeX5aprPda9jMRfKe2nvarMQ4L8bhtCwVIFz1IZxH0GI9a0GM8yBMybdUTMm1kMMG1GkxwJYLWBQstaJNgLoLgcKwFIcGRAgwjNZj2+jIIYAxTpbiQCpZgtY87V0yYgzbNByG9QUc7NQhx3LWM0+cv7KGMExhARw/+U243mZ31loLtywAAAABJRU5ErkJggg==">
                </a>
            </button>
        </div>
    `;

  tableBody.appendChild(newRow);
}

function saveCategory(id = null, counter = null, event) {
  if (event) event.preventDefault();

  let name,
    description,
    weight,
    dbId = null;

  if (counter !== null) {
    // Categoria já existente ou nova
    dbId = document.getElementById(`db-id-${counter}`)?.value || "";
    name = document.getElementById(`name-${counter}`).value;
    description = document.getElementById(`description-${counter}`).value;
    weight = document.getElementById(`weight-${counter}`).value;
  }

  if (!name || !weight) {
    alert("Nome e Peso são obrigatórios.");
    return;
  }

  let formData = new URLSearchParams();
  formData.append("name", name);
  formData.append("description", description);
  formData.append("weight", weight);

  let url = dbId
    ? `../Controller/CategoryController.php?action=editar&id=${dbId}`
    : "../Controller/CategoryController.php?action=add";

  fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: formData.toString(),
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.message);

      // Se foi um novo cadastro, o BD retorna um ID, e precisamos atualizar a linha
      if (!dbId && counter !== null && data.id_Category) {
        let rowElement = document.getElementById(`category-row-${counter}`);

        let hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.id = `db-id-${counter}`;
        hiddenInput.value = data.id_Category;
        rowElement.appendChild(hiddenInput);
      }

      fetchCategories(); // Atualiza a tabela
    })
    .catch((error) => console.error("Erro ao salvar categoria:", error));
}

// Excluir categoria
function deleteCategoryRow(id, counter = null, event) {
  if (event) event.preventDefault();

  let rowElement = document.getElementById(`category-row-${counter}`);

  if (!rowElement) {
    console.error("Erro: Linha não encontrada!");
    return;
  }

  let dbId = document.getElementById(`db-id-${counter}`)?.value || null;

  if (!dbId) {
    rowElement.remove();
    console.log(`Linha ${counter} removida localmente, sem excluir no banco.`);
    return;
  }

  if (confirm("Tem certeza que deseja excluir esta categoria?")) {
    fetch(`../Controller/CategoryController.php?action=delete`, {
      method: "DELETE",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ id: dbId }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Resposta do servidor após exclusão:", data); // 🔍 Log para depuração
        alert(data.message);
        fetchCategories(); // Atualiza a tabela para refletir a exclusão
      })
      .catch((error) => console.error("Erro ao excluir categoria:", error));
  }
}
