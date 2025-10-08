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

    const rmInput = document.getElementById('rm_input');
    const etecCodeInput = document.getElementById('codigo_etec');
    const submitButton = document.getElementById('submit_button');

    if (rmInput && etecCodeInput && submitButton) {
        rmInput.addEventListener('input', () => {
            const rmValue = rmInput.value.toLowerCase().trim();
            
            if (rmValue === 'adm' || rmValue === 'emp') {
                etecCodeInput.required = false;
                etecCodeInput.style.backgroundColor = '#e9ecef';
                etecCodeInput.placeholder = 'Não necessário';
                etecCodeInput.value = '';
                submitButton.setAttribute('formnovalidate', 'formnovalidate');
            } else {
                etecCodeInput.required = true;
                etecCodeInput.style.backgroundColor = '';
                etecCodeInput.placeholder = 'Código da sua Etec';
                submitButton.removeAttribute('formnovalidate');
            }
        });
    }
});