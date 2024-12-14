// JavaScript para coletar os dados do formulário e redirecionar para a página do menu inicial
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o comportamento padrão do formulário

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Coletando os dados do formulário
        const formData = {
            email: email,
            password: password
        };

        console.log('Dados do formulário:', formData);

        // Falta enviar os dados para o backend via AJAX.

        // Redirecionar para a página do menu inicial
        window.location.href = './menuInicial.html'; 
    });
});