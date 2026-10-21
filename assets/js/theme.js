// Menu mobile : ouvre ou ferme le menu (aria-expanded indique l'état aux lecteurs d'écran).
function lfToggleMenu() {
    const button = document.querySelector('.lf-menu');
    const menu = document.getElementById(button.getAttribute('aria-controls'));

    if (button.getAttribute('aria-expanded') === 'true') {
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-label', 'Ouvrir le menu');
        menu.classList.remove('is-open');
    } else {
        button.setAttribute('aria-expanded', 'true');
        button.setAttribute('aria-label', 'Fermer le menu');
        menu.classList.add('is-open');
    }
}

// Touche Échap : ferme le menu et remet le focus sur le bouton.
function lfCloseMenu(event) {
    const button = document.querySelector('.lf-menu');

    if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') {
        lfToggleMenu();
        button.focus();
    }
}

// Clic sur un lien du menu : on referme le menu.
function lfMenuLink() {
    const button = document.querySelector('.lf-menu');

    if (button.getAttribute('aria-expanded') === 'true') {
        lfToggleMenu();
    }
}

// Boutons − et + de la quantité : désactivés quand on atteint le minimum ou le maximum.
function lfQuantityButtons(quantity) {
    const input = quantity.querySelector('input.qty');
    const buttons = quantity.querySelectorAll('button');
    let minimum = 1;

    if (input.min !== '') {
        minimum = Number(input.min);
    }

    buttons[0].disabled = Number(input.value) <= minimum;
    buttons[1].disabled = false;

    if (input.max !== '') {
        buttons[1].disabled = Number(input.value) >= Number(input.max);
    }
}

// Clic sur − ou + : ajoute ou enlève 1 à la quantité.
function lfChangeQuantity(event) {
    const button = event.currentTarget;
    const quantity = button.parentElement;
    const input = quantity.querySelector('input.qty');

    if (button.textContent === '+') {
        input.value = Number(input.value) + 1;
    } else {
        input.value = Number(input.value) - 1;
    }

    lfQuantityButtons(quantity);
}

// Quand on tape une quantité au clavier, on met à jour les boutons − et +.
function lfQuantityInput(event) {
    lfQuantityButtons(event.currentTarget.parentElement);
}

// IT-3 : la pastille choisie est recopiée dans la liste déroulante cachée de WooCommerce.
// La ligne « dispatchEvent » prévient WooCommerce du changement : il affiche alors le bon prix et le stock.
function lfChooseOption(event) {
    const radio = event.currentTarget;
    const select = document.querySelector('select[name="' + radio.getAttribute('data-select') + '"]');

    select.value = radio.value;
    select.dispatchEvent(new Event('change', { bubbles: true }));
}

// Au chargement de la page : on branche tous les événements.
function lfStart() {
    const menuButton = document.querySelector('.lf-menu');

    if (menuButton) {
        const menu = document.getElementById(menuButton.getAttribute('aria-controls'));
        menuButton.addEventListener('click', lfToggleMenu);
        document.addEventListener('keydown', lfCloseMenu);

        const links = menu.querySelectorAll('a');

        for (let i = 0; i < links.length; i++) {
            links[i].addEventListener('click', lfMenuLink);
        }
    }

    const quantities = document.querySelectorAll('.lf-product-summary .quantity');

    for (let i = 0; i < quantities.length; i++) {
        const quantity = quantities[i];
        const input = quantity.querySelector('input.qty');

        if (input && input.type !== 'hidden') {
            const decrease = document.createElement('button');
            decrease.type = 'button';
            decrease.textContent = '−';
            decrease.setAttribute('aria-label', 'Diminuer la quantité');
            decrease.addEventListener('click', lfChangeQuantity);

            const increase = document.createElement('button');
            increase.type = 'button';
            increase.textContent = '+';
            increase.setAttribute('aria-label', 'Augmenter la quantité');
            increase.addEventListener('click', lfChangeQuantity);

            quantity.prepend(decrease);
            quantity.append(increase);
            input.addEventListener('change', lfQuantityInput);
            lfQuantityButtons(quantity);
        }
    }

    const options = document.querySelectorAll('.lf-variations-form input[type="radio"]');

    for (let i = 0; i < options.length; i++) {
        options[i].addEventListener('change', lfChooseOption);
    }

    const selects = document.querySelectorAll('.lf-variations-form select');

    for (let i = 0; i < selects.length; i++) {
        selects[i].tabIndex = -1;
        selects[i].setAttribute('aria-hidden', 'true');
    }
}

document.addEventListener('DOMContentLoaded', lfStart);
