const products = [
    {
        "name": "Croquettes de chorizo",
        "category": "partager",
        "image": "../assets/9b0f5.png",
        "price": 8,
        "description": "Croquettes croustillantes au chorizo, servies avec une petite salade.",
        "allergens": "Gluten, œufs, lait",
        "composition": "Chorizo, béchamel, chapelure, salade",
        "options": [
            {
                "name": "Portion",
                "values": [
                    {
                        "label": "×4"
                    },
                    {
                        "label": "×8 (+6 €)",
                        "extra": 6
                    }
                ]
            },
            {
                "name": "Sauce",
                "values": [
                    {
                        "label": "Sauce des Fistons"
                    },
                    {
                        "label": "Mayo paprika"
                    },
                    {
                        "label": "Sans sauce"
                    }
                ]
            }
        ],
        "remove": [],
        "notice": "",
        "id": 0
    },
    {
        "name": "Beignets de courgettes au Parmesan",
        "category": "partager",
        "image": "../assets/e2429.png",
        "price": 7.5,
        "description": "Beignets de courgettes et Parmesan, fromage frais aux herbes pour tremper.",
        "allergens": "Gluten, œufs, lait",
        "composition": "Courgettes, Parmesan, farine, fromage frais, herbes",
        "options": [
            {
                "name": "Portion",
                "values": [
                    {
                        "label": "×5"
                    },
                    {
                        "label": "×10 (+6 €)",
                        "extra": 6
                    }
                ]
            },
            {
                "name": "Sauce",
                "values": [
                    {
                        "label": "Fromage frais aux herbes"
                    },
                    {
                        "label": "Sauce des Fistons"
                    }
                ]
            }
        ],
        "remove": [],
        "notice": "",
        "id": 1
    },
    {
        "name": "Œufs mimosa",
        "category": "partager",
        "image": "../assets/5f33c.png",
        "price": 7,
        "description": "Œufs mimosa à la mayonnaise au paprika, éclats de bacon.",
        "allergens": "Œufs, moutarde",
        "composition": "Œufs, mayonnaise, paprika, bacon",
        "options": [
            {
                "name": "Version",
                "values": [
                    {
                        "label": "Bacon"
                    },
                    {
                        "label": "Saumon gravlax (+1 €)",
                        "extra": 1
                    }
                ]
            }
        ],
        "remove": [],
        "notice": "",
        "id": 2
    },
    {
        "name": "Cordon bleu des Fistons",
        "category": "plats",
        "image": "../assets/3dd74.png",
        "price": 19,
        "description": "Filet de poulet français, Saint-Nectaire, poitrine fumée et crème de Saint-Nectaire.",
        "allergens": "Gluten, œufs, lait",
        "composition": "Poulet français, Saint-Nectaire, poitrine fumée, chapelure",
        "options": [
            {
                "name": "Accompagnement",
                "values": [
                    {
                        "label": "Pommes grenaille"
                    },
                    {
                        "label": "Frites maison"
                    },
                    {
                        "label": "Salade"
                    }
                ]
            }
        ],
        "remove": [
            "Sans poitrine fumée"
        ],
        "notice": "",
        "id": 3
    },
    {
        "name": "Tartare aux deux saumons",
        "category": "plats",
        "image": "../assets/6556c.png",
        "price": 21,
        "description": "Saumon frais et saumon gravlax, avocat, oignons rouges, citron vert et herbes fraîches.",
        "allergens": "Poisson",
        "composition": "Saumon, saumon gravlax, avocat, oignons rouges, citron vert",
        "options": [
            {
                "name": "Accompagnement",
                "values": [
                    {
                        "label": "Frites + salade"
                    },
                    {
                        "label": "Salade seule"
                    }
                ]
            }
        ],
        "remove": [
            "Sans oignons rouges",
            "Sans avocat"
        ],
        "notice": "",
        "id": 4
    },
    {
        "name": "Œufs Bénédicte",
        "category": "plats",
        "image": "../assets/91651.png",
        "price": 17.5,
        "description": "Œufs pochés, sauce hollandaise, pommes grenaille et salade. Servis le dimanche.",
        "allergens": "Gluten, œufs, lait",
        "composition": "Œufs, muffin, hollandaise, pommes grenaille, salade",
        "options": [
            {
                "name": "Version",
                "values": [
                    {
                        "label": "Bacon"
                    },
                    {
                        "label": "Saumon gravlax"
                    }
                ]
            }
        ],
        "remove": [],
        "notice": "Uniquement le dimanche",
        "id": 5
    },
    {
        "name": "Millefeuille façon palmito",
        "category": "desserts",
        "image": "../assets/6bd9c.png",
        "price": 8,
        "description": "Biscuit feuilleté façon palmier, crème mascarpone et fraises fraîches.",
        "allergens": "Gluten, œufs, lait",
        "composition": "Pâte feuilletée, mascarpone, fraises, sucre",
        "options": [],
        "remove": [],
        "notice": "",
        "id": 6
    },
    {
        "name": "Cookie de Maman",
        "category": "desserts",
        "image": "../assets/ba98e.png",
        "price": 6,
        "description": "Le cookie maison de Maman, servi avec sa crème fouettée.",
        "allergens": "Gluten, œufs, lait, fruits à coque",
        "composition": "Farine, beurre, chocolat, crème",
        "options": [
            {
                "name": "Topping",
                "values": [
                    {
                        "label": "Crème fouettée"
                    },
                    {
                        "label": "Sans"
                    },
                    {
                        "label": "Boule de glace (+2 €)",
                        "extra": 2
                    }
                ]
            }
        ],
        "remove": [],
        "notice": "",
        "id": 7
    },
    {
        "name": "Une pêche d’enfer",
        "category": "desserts",
        "image": "../assets/cbcf3.png",
        "price": 8,
        "description": "Mocktail sans alcool : purée et sirop de pêche, citron vert, Perrier, menthe fraîche. 17 cl.",
        "allergens": "Aucun allergène majeur",
        "composition": "Purée de pêche, sirop de pêche, citron vert, Perrier, menthe",
        "options": [
            {
                "name": "Glaçons",
                "values": [
                    {
                        "label": "Avec"
                    },
                    {
                        "label": "Sans"
                    }
                ]
            }
        ],
        "remove": [],
        "notice": "",
        "id": 8
    }
];

function euro(value) {
    return Number(value).toLocaleString('fr-FR', { maximumFractionDigits: 2 }) + ' €';
}

function escapeHTML(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#39;');
}

let toastTimer;

function hideToast() {
    document.getElementById('toast').hidden = true;
}

function announce(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.hidden = false;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(hideToast, 3600);
}

function copySuccess() {
    announce('Copié. À toi de jouer !');
}

function copyError() {
    announce('Copie indisponible : sélectionne le code pour le copier.');
}

function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(copySuccess, copyError);
        return;
    }

    const area = document.createElement('textarea');
    area.value = text;
    area.style.position = 'fixed';
    area.style.left = '-9999px';
    document.body.append(area);
    area.select();

    try {
        if (document.execCommand('copy')) {
            announce('Copié. À toi de jouer !');
        } else {
            announce('Copie indisponible : sélectionne le code pour le copier.');
        }
    } catch (error) {
        announce('Copie indisponible : sélectionne le code pour le copier.');
    }

    area.remove();
}

function getProduct(id) {
    for (let i = 0; i < products.length; i++) {
        if (products[i].id === Number(id)) {
            return products[i];
        }
    }
}

function filterProducts(category) {
    const buttons = document.querySelectorAll('[data-filter]');
    const cards = document.querySelectorAll('#product-grid > .lf-card');
    let count = 0;

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].setAttribute('aria-pressed', 'false');
        if (buttons[i].dataset.filter === category) {
            buttons[i].setAttribute('aria-pressed', 'true');
        }
    }

    for (let i = 0; i < cards.length; i++) {
        cards[i].hidden = false;
        if (category !== 'all' && cards[i].dataset.category !== category) {
            cards[i].hidden = true;
        }
        if (!cards[i].hidden) {
            count++;
        }
    }

    let label = count + ' composant affiché';
    if (count > 1) {
        label = count + ' composants affichés';
    }
    document.getElementById('product-count').textContent = label;
}

function quantityHTML(value) {
    let disabled = '';
    if (value <= 1) {
        disabled = 'disabled';
    }

    return '<div class="lf-quantity" data-quantity>'
        + '<button type="button" data-step="-1" aria-label="Diminuer la quantité" ' + disabled + '>−</button>'
        + '<output aria-label="Quantité" aria-live="polite">' + value + '</output>'
        + '<button type="button" data-step="1" aria-label="Augmenter la quantité">+</button>'
        + '</div>';
}

function detailHTML(product, prefix) {
    let category = 'À partager';
    let badge = '';
    let titleId = 'detail-title';

    if (product.category === 'plats') {
        category = 'Plats';
        badge = 'lf-badge--plats';
    } else if (product.category === 'desserts') {
        category = 'Desserts & boissons';
        badge = 'lf-badge--desserts';
    }

    if (prefix === 'dialog') {
        titleId = 'dialog-title';
    }

    let html = '<div class="lf-detail" data-product="' + product.id + '">'
        + '<div class="lf-photo lf-detail__image"><img src="' + product.image + '" alt="' + escapeHTML(product.name) + '"></div>'
        + '<div>'
        + '<span class="lf-badge ' + badge + '">' + category + '</span>'
        + '<h3 class="lf-title lf-title--h1 lf-title--outlined" id="' + titleId + '">' + escapeHTML(product.name) + '</h3>'
        + '<p class="lf-detail__description">' + escapeHTML(product.description) + '</p>'
        + '<p class="lf-detail__price" data-product-price>' + euro(product.price) + '</p>';

    if (product.notice !== '') {
        html += '<p class="lf-badge lf-badge--desserts" style="margin-bottom:20px">' + escapeHTML(product.notice) + '</p>';
    }

    for (let g = 0; g < product.options.length; g++) {
        const group = product.options[g];
        html += '<fieldset class="lf-options"><legend>' + escapeHTML(group.name) + '</legend><div class="lf-chips">';

        for (let i = 0; i < group.values.length; i++) {
            const option = group.values[i];
            let checked = '';
            let extra = 0;

            if (i === 0) {
                checked = 'checked';
            }
            if (option.extra) {
                extra = option.extra;
            }

            html += '<label class="lf-chip"><input type="radio" name="' + prefix + '-' + g + '" value="' + i + '" data-extra="' + extra + '" ' + checked + '>' + escapeHTML(option.label) + '</label>';
        }

        html += '</div></fieldset>';
    }

    if (product.remove.length > 0) {
        html += '<fieldset class="lf-options"><legend>À retirer (facultatif)</legend><div class="lf-chips">';

        for (let i = 0; i < product.remove.length; i++) {
            html += '<label class="lf-chip"><input type="checkbox">' + escapeHTML(product.remove[i]) + '</label>';
        }

        html += '</div></fieldset>';
    }

    html += '<div class="lf-detail__actions">' + quantityHTML(1)
        + '<button class="lf-btn" data-add-detail>Ajouter au panier · <span data-product-total>' + euro(product.price) + '</span></button></div>'
        + '<dl class="lf-facts">'
        + '<div><dt>Allergènes</dt><dd>' + escapeHTML(product.allergens) + '</dd></div>'
        + '<div><dt>Composition</dt><dd>' + escapeHTML(product.composition) + '</dd></div>'
        + '</dl></div></div>';

    return html;
}

function updateDetail(root) {
    const product = getProduct(root.dataset.product);
    const inputs = root.querySelectorAll('input[type="radio"]:checked');
    let price = product.price;

    for (let i = 0; i < inputs.length; i++) {
        price += Number(inputs[i].dataset.extra || 0);
    }

    const quantity = Number(root.querySelector('output').textContent);
    root.querySelector('[data-product-price]').textContent = euro(price);
    root.querySelector('[data-product-total]').textContent = euro(price * quantity);
}

let basket = [
    { id: 3, qty: 1, unit: 19, choice: 'Pommes grenaille' },
    { id: 8, qty: 1, unit: 8, choice: 'Avec glaçons' }
];

function renderBasket() {
    const target = document.getElementById('cart-items');
    let html = '';
    let total = 0;
    let count = 0;

    for (let i = 0; i < basket.length; i++) {
        const item = basket[i];
        const product = getProduct(item.id);

        html += '<article class="lf-cart-item" data-cart-index="' + i + '">'
            + '<div class="lf-photo"><img src="' + product.image + '" alt="' + escapeHTML(product.name) + '"></div>'
            + '<div class="lf-cart-item__info">'
            + '<h4>' + escapeHTML(product.name) + '</h4>'
            + '<p class="lf-small lf-muted">' + escapeHTML(item.choice) + '</p>'
            + '<button class="lf-link lf-small" data-remove="' + i + '" aria-label="Retirer ' + escapeHTML(product.name) + '">Retirer</button>'
            + '</div>' + quantityHTML(item.qty)
            + '<strong class="lf-price">' + euro(item.unit * item.qty) + '</strong></article>';

        total += item.unit * item.qty;
        count += item.qty;
    }

    if (basket.length === 0) {
        html = '<div class="panel"><h3 class="lf-title lf-title--h3">Ton panier est vide</h3>'
            + '<p style="margin-top:12px">Un petit creux ? Les cartes produits t’attendent.</p>'
            + '<a href="#produits" class="lf-btn lf-btn--small" style="margin-top:20px">Voir la carte</a></div>';
    }

    target.innerHTML = html;

    const totals = document.querySelectorAll('[data-cart-total]');
    const counts = document.querySelectorAll('[data-cart-count]');

    for (let i = 0; i < totals.length; i++) {
        totals[i].textContent = euro(total);
    }
    for (let i = 0; i < counts.length; i++) {
        counts[i].textContent = count;
    }

    document.getElementById('demo-checkout').disabled = basket.length === 0;
}

function addProduct(id, unit, quantity, choice) {
    let found = false;

    for (let i = 0; i < basket.length; i++) {
        const item = basket[i];
        if (item.id === id && item.unit === unit && item.choice === choice) {
            item.qty += quantity;
            found = true;
            break;
        }
    }

    if (!found) {
        basket.push({ id: id, unit: unit, qty: quantity, choice: choice });
    }

    renderBasket();

    let message = quantity + ' × ' + getProduct(id).name + ' ajouté';
    if (quantity > 1) {
        message += 's';
    }
    announce(message + ' au panier de démonstration.');
}

function addDetail(button) {
    const root = button.closest('[data-product]');
    const product = getProduct(root.dataset.product);
    const selections = root.querySelectorAll('input:checked');
    let unit = product.price;
    let choice = '';

    for (let i = 0; i < selections.length; i++) {
        unit += Number(selections[i].dataset.extra || 0);
        if (i > 0) {
            choice += ' · ';
        }
        choice += selections[i].parentElement.textContent.trim();
    }

    addProduct(product.id, unit, Number(root.querySelector('output').textContent), choice);
}

function changeQuantity(button) {
    const root = button.closest('[data-quantity]');
    const output = root.querySelector('output');
    let value = Number(output.textContent) + Number(button.dataset.step);

    if (value < 1) {
        value = 1;
    }

    output.value = value;
    output.textContent = value;
    root.querySelector('[data-step="-1"]').disabled = value <= 1;

    const item = button.closest('[data-cart-index]');
    if (item) {
        basket[Number(item.dataset.cartIndex)].qty = value;
        renderBasket();
    }

    const detail = button.closest('[data-product]');
    if (detail) {
        updateDetail(detail);
    }
}

function updateChips() {
    const inputs = document.querySelectorAll('.lf-chip input');

    for (let i = 0; i < inputs.length; i++) {
        const chip = inputs[i].parentElement;
        chip.classList.add('has-input');
        chip.classList.remove('is-selected', 'is-disabled');

        if (inputs[i].checked) {
            chip.classList.add('is-selected');
        }
        if (inputs[i].disabled) {
            chip.classList.add('is-disabled');
        }
    }
}

function handleChipFocus(event) {
    const input = event.target;
    if (input.matches('.lf-chip input') && input.matches(':focus-visible')) {
        input.parentElement.classList.add('is-focused');
    }
}

function handleChipBlur(event) {
    if (event.target.matches('.lf-chip input')) {
        event.target.parentElement.classList.remove('is-focused');
    }
}

function handleClick(event) {
    const button = event.target.closest('button, a');
    if (!button) {
        return;
    }

    if (button.hasAttribute('data-feedback')) {
        announce(button.dataset.feedback);
    }
    if (button.hasAttribute('data-copy-css')) {
        copyText(document.getElementById('wordpress-css').textContent.trim());
    }
    if (button.hasAttribute('data-copy-code')) {
        copyText(button.closest('details').querySelector('code').textContent);
    }
    if (button.hasAttribute('data-copy-color')) {
        copyText(button.dataset.copyColor);
    }
    if (button.hasAttribute('data-filter')) {
        filterProducts(button.dataset.filter);
    }
    if (button.hasAttribute('data-category-link')) {
        filterProducts(button.dataset.categoryLink);
    }
    if (button.hasAttribute('data-open-product')) {
        const product = getProduct(button.dataset.openProduct);
        document.getElementById('dialog-content').innerHTML = detailHTML(product, 'dialog');
        updateChips();
        document.getElementById('product-dialog').showModal();
    }
    if (button.id === 'close-dialog') {
        document.getElementById('product-dialog').close();
    }
    if (button.hasAttribute('data-add')) {
        const product = getProduct(button.dataset.add);
        let choice = '';

        for (let i = 0; i < product.options.length; i++) {
            if (i > 0) {
                choice += ' · ';
            }
            choice += product.options[i].values[0].label;
        }

        addProduct(product.id, product.price, 1, choice);
    }
    if (button.hasAttribute('data-add-detail')) {
        addDetail(button);
    }
    if (button.hasAttribute('data-step')) {
        changeQuantity(button);
    }
    if (button.hasAttribute('data-remove')) {
        basket.splice(Number(button.dataset.remove), 1);
        renderBasket();
        announce('Article retiré du panier de démonstration.');
    }
    if (button.id === 'reset-cart') {
        basket = [
            { id: 3, qty: 1, unit: 19, choice: 'Pommes grenaille' },
            { id: 8, qty: 1, unit: 8, choice: 'Avec glaçons' }
        ];
        renderBasket();
        announce('Panier de démonstration réinitialisé.');
    }
    if (button.id === 'demo-checkout') {
        const slot = document.querySelector('input[name="slot-cart"]:checked').value;
        announce('Démonstration : retrait à ' + slot + '. Aucune commande envoyée.');
    }
    if (button.hasAttribute('data-scroll-cart')) {
        document.getElementById('panier').scrollIntoView();
    }
    if (button.classList.contains('lf-menu')) {
        const menu = document.getElementById(button.getAttribute('aria-controls'));

        if (button.getAttribute('aria-expanded') === 'true') {
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', 'Ouvrir le menu de l’exemple mobile');
            menu.hidden = true;
        } else {
            button.setAttribute('aria-expanded', 'true');
            button.setAttribute('aria-label', 'Fermer le menu de l’exemple mobile');
            menu.hidden = false;
        }
    }
}

function handleChange(event) {
    updateChips();
    const detail = event.target.closest('[data-product]');
    if (detail) {
        updateDetail(detail);
    }
}

function closeDialogOutside(event) {
    if (event.target.id !== 'product-dialog') {
        return;
    }

    const rect = event.target.getBoundingClientRect();
    if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) {
        event.target.close();
    }
}

function showCode(event) {
    const details = event.currentTarget;
    if (!details.open || details.querySelector('pre')) {
        return;
    }

    const sample = document.getElementById(details.dataset.codeTarget).cloneNode(true);
    const elements = sample.querySelectorAll('[id]');

    sample.removeAttribute('id');
    for (let i = 0; i < elements.length; i++) {
        elements[i].removeAttribute('id');
    }

    const toolbar = document.createElement('div');
    toolbar.className = 'code-box__toolbar';
    toolbar.innerHTML = '<button data-copy-code>Copier le code</button>';

    const pre = document.createElement('pre');
    const code = document.createElement('code');
    code.textContent = '<div class="lf-system">\n' + sample.outerHTML + '\n</div>';
    pre.append(code);
    details.append(toolbar, pre);
}

function highlightNavigation() {
    const sections = document.querySelectorAll('main > .section');
    const links = document.querySelectorAll('.sidebar nav a');
    let current = '';

    for (let i = 0; i < sections.length; i++) {
        const rect = sections[i].getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.35 && rect.bottom > window.innerHeight * 0.1) {
            current = '#' + sections[i].id;
            break;
        }
    }

    if (current === '') {
        return;
    }

    for (let i = 0; i < links.length; i++) {
        links[i].removeAttribute('aria-current');
        if (links[i].hash === current) {
            links[i].setAttribute('aria-current', 'location');
        }
    }
}

document.addEventListener('click', handleClick);
document.addEventListener('change', handleChange);
document.addEventListener('focusin', handleChipFocus);
document.addEventListener('focusout', handleChipBlur);
document.getElementById('product-dialog').addEventListener('click', closeDialogOutside);

const examples = document.querySelectorAll('[data-code-target]');
for (let i = 0; i < examples.length; i++) {
    examples[i].addEventListener('toggle', showCode);
}

window.addEventListener('scroll', highlightNavigation);
updateChips();
highlightNavigation();
renderBasket();
