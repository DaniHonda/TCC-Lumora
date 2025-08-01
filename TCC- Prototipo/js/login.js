document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('close-btn');
    const sidemenu = document.getElementById('sidemenu');
    const overlay = document.getElementById('overlay');

    if (menuBtn && sidemenu && closeBtn && overlay) {
        function openMenu() {
            sidemenu.classList.add('active');
            overlay.classList.add('active');
        }

        function closeMenu() {
            sidemenu.classList.remove('active');
            overlay.classList.remove('active');
        }

        menuBtn.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    }

    const toggleSenha = document.getElementById('toggleSenha');
    const senhaInput = document.getElementById('senha');

    if (toggleSenha && senhaInput) {
        toggleSenha.addEventListener('click', () => {
            const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
            senhaInput.setAttribute('type', tipo);
            toggleSenha.textContent = tipo === 'password' ? '👁️' : '🙈';
        });
    }

    const rmInput = document.getElementById('rm_input');
    const etecCodeInput = document.getElementById('codigo_etec');

    if (rmInput && etecCodeInput) {
        rmInput.addEventListener('input', () => {
            if (rmInput.value.toLowerCase().trim() === 'adm') {
                etecCodeInput.required = false;
                etecCodeInput.style.backgroundColor = '#e9ecef';
                etecCodeInput.placeholder = 'Não necessário para admin';
            } else {
                etecCodeInput.required = true;
                etecCodeInput.style.backgroundColor = '';
                etecCodeInput.placeholder = 'Código da sua Etec';
            }
        });
    }
});

function validarLogin() {
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value.trim();

    if (!email || !senha) {
        alert('Por favor, preencha todos os campos.');
        return false;
    }

    return true;
}