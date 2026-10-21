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

function lfQuantityInput(event) {
    lfQuantityButtons(event.currentTarget.parentElement);
}

function lfStartQuantity() {
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
}

document.addEventListener('DOMContentLoaded', lfStartQuantity);
