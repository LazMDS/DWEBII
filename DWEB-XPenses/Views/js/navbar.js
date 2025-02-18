document.addEventListener("DOMContentLoaded", function () {
  fetch(`../Controller/UserController.php?action=getUser`)
    .then((response) => response.json())
    .then((data) => {
      console.log("Dados recebidos do backend:", data); // Log para depuração

      if (data.error) {
        console.error("Erro ao buscar usuário:", data.error);
        return;
      }

      if (data.profile_picture) {
        let imagePath =
          "../uploads/" + data.profile_picture + "?t=" + new Date().getTime();
        console.log("Caminho da imagem atualizado:", imagePath);

        let navProfileImage = document.getElementById("navProfileImage");
        if (navProfileImage) {
          navProfileImage.src = imagePath;
          console.log("Navbar atualizada com a imagem:", imagePath);
        } else {
          console.error("Elemento da Navbar não encontrado!");
        }
      }
    })
    .catch((error) =>
      console.error("Erro ao carregar imagem da Navbar:", error)
    );
});
