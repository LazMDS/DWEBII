document.addEventListener("DOMContentLoaded", function () {
  fetchUserData();

  document.getElementById("editSenhaBtn").addEventListener("click", function () {
    document.getElementById("senhaSection").classList.toggle("d-none");
  });

  document.getElementById("salvarSenhaBtn").addEventListener("click", function () {
    const senhaAtual = document.getElementById("senhaAntiga").value;
    const novaSenha = document.getElementById("senhaNova").value;
    const confirmarSenha = document.getElementById("confirmarSenha").value;

    if (!senhaAtual || !novaSenha || !confirmarSenha) {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    if (novaSenha !== confirmarSenha) {
        alert("A nova senha e a confirmação devem ser iguais.");
        return;
    }

    fetch("../Controller/UserController.php?action=updatePassword", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
          senhaAtual: senhaAtual,
          novaSenha: novaSenha
      }),
    })
    .then((response) => response.text()) // Primeiro pegamos como texto
    .then((text) => {
        console.log("Resposta bruta do servidor:", text); // Depuração
        try {
            return JSON.parse(text); // Agora tentamos converter para JSON
        } catch (error) {
            throw new Error("Erro ao converter resposta do servidor para JSON: " + text);
        }
    })
    .then((data) => {
        if (data.success) {
            alert("Senha alterada com sucesso!");
            document.getElementById("senhaSection").classList.add("d-none");
            document.getElementById("senhaAntiga").value = "";
            document.getElementById("senhaNova").value = "";
            document.getElementById("confirmarSenha").value = "";
        } else {
            alert("Erro: " + data.error);
        }
    })
    .catch((error) => console.error("Erro ao alterar senha:", error));
  
  });

  const userNameInput = document.getElementById("userName");
  const userEmailInput = document.getElementById("userEmail");
  const editNameBtn = document.getElementById("editNameBtn");
  const editEmailBtn = document.getElementById("editEmailBtn");
  const saveNameBtn = document.getElementById("saveNameBtn");
  const saveEmailBtn = document.getElementById("saveEmailBtn");

  function enableEdit(input, saveButton) {
      input.removeAttribute("disabled");
      input.focus();
      saveButton.classList.remove("d-none");
  }

  function saveUserData(field, value, saveButton, input) {
      fetch("../Controller/UserController.php?action=updateUserData", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
              field: field,
              value: value
          }),
      })
      .then((response) => response.json())
      .then((data) => {
          if (data.success) {
              alert("Dados atualizados com sucesso!");
              input.setAttribute("disabled", "true");
              saveButton.classList.add("d-none");
          } else {
              alert("Erro: " + data.error);
          }
      })
      .catch((error) => console.error("Erro ao atualizar dados:", error));
  }

  // Ativa edição e exibe botão de salvar
  editNameBtn.addEventListener("click", () => enableEdit(userNameInput, saveNameBtn));
  editEmailBtn.addEventListener("click", () => enableEdit(userEmailInput, saveEmailBtn));

  // Envia atualização para o banco ao clicar no botão de salvar
  saveNameBtn.addEventListener("click", () => saveUserData("name", userNameInput.value, saveNameBtn, userNameInput));
  saveEmailBtn.addEventListener("click", () => saveUserData("email", userEmailInput.value, saveEmailBtn, userEmailInput));
});

function fetchUserData() {
  fetch("../Controller/UserController.php?action=getUser")
    .then((response) => response.json())
    .then((data) => {
      console.log("Dados recebidos do backend:", data); // Log para depuração

      if (data.error) {
        console.error("Erro ao buscar usuário:", data.error);
        return;
      }

      document.getElementById("userName").value = data.name;
      document.getElementById("userEmail").value = data.email;

      // Se houver imagem, exibe na tela
      if (data.profile_picture) {
        let imagePath =
          "../uploads/" + data.profile_picture + "?t=" + new Date().getTime();
        console.log("Caminho da imagem atualizado:", imagePath);

        // Atualiza a imagem do perfil
        document.getElementById("profileImage").src = imagePath;

        // Verifica se a Navbar está carregada antes de tentar atualizar
        let navProfileImage = document.getElementById("navProfileImage");
        if (navProfileImage) {
          navProfileImage.src = imagePath;
          console.log("Navbar atualizada com a imagem:", imagePath);
        } else {
          console.error("Elemento da Navbar não encontrado!");
        }
      }
    })
    .catch((error) => console.error("Erro ao carregar perfil:", error));
}

// Quando clicar no botão, abre o input de arquivo
document
  .getElementById("profilePictureButton")
  .addEventListener("click", function () {
    document.getElementById("profilePictureInput").click();
  });

// Quando o usuário selecionar uma imagem, faz o upload
document
  .getElementById("profilePictureInput")
  .addEventListener("change", function () {
    let formData = new FormData();
    let file = this.files[0];

    if (!file) return;

    formData.append("profile_picture", file);

    fetch("../Controller/UserController.php?action=uploadProfilePicture", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.profile_picture) {
          let imagePath =
            "../uploads/" + data.profile_picture + "?t=" + new Date().getTime();
          console.log("Imagem atualizada após upload:", imagePath);

          document.getElementById("profileImage").src = imagePath; // Atualiza no perfil

          let navProfileImage = document.getElementById("navProfileImage");
          if (navProfileImage) {
            navProfileImage.src = imagePath;
            console.log("Navbar atualizada após upload:", imagePath);
          } else {
            console.error("Navbar não encontrada após upload!");
          }
        } else {
          console.error("Erro ao atualizar foto de perfil:", data.error);
        }
      })
      .catch((error) => console.error("Erro ao enviar imagem:", error));
  });
