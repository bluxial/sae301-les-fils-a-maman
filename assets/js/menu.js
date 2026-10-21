function lfToggleMenu() {
    const button = document.querySelector('.lf-menu');
    const menu = document.getElementById(button.getAttribute('aria-controls'));

    if (button.getAttribute('aria-expanded') === 'true') {
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-label', 'Ouvrir le menu');
        menu.classList.remove('lf-header__nav--open');
    } else {
        button.setAttribute('aria-expanded', 'true');
        button.setAttribute('aria-label', 'Fermer le menu');
        menu.classList.add('lf-header__nav--open');
    }
}

function lfCloseMenu(event) {
    const button = document.querySelector('.lf-menu');

    if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') {
        lfToggleMenu();
        button.focus();
    }
}

function lfMenuLink() {
    const button = document.querySelector('.lf-menu');

    if (button.getAttribute('aria-expanded') === 'true') {
        lfToggleMenu();
    }
}

function lfStartMenu() {
    const menuButton = document.querySelector('.lf-menu');

    if (!menuButton) {
        return;
    }

    const menu = document.getElementById(menuButton.getAttribute('aria-controls'));
    menuButton.addEventListener('click', lfToggleMenu);
    document.addEventListener('keydown', lfCloseMenu);

    const links = menu.querySelectorAll('a');

    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener('click', lfMenuLink);
    }
}

document.addEventListener('DOMContentLoaded', lfStartMenu);
