
// JavaScript para coletar os dados do formulário e redirecionar para a página de Conecte-se
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o comportamento padrão do formulário

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Validação simples de senha
        if (password !== confirmPassword) {
            alert('As senhas não correspondem!');
            return;
        }

        // Coletando os dados do formulário
        const formData = {
            name: name,
            email: email,
            password: password
        };

        console.log('Dados do formulário:', formData);

        // Aqui você pode enviar os dados para o backend via AJAX/fetch ou outras formas se necessário

        // Redirecionar para a página de Conecte-se
        window.location.href = './Conectese.html';
    });
});