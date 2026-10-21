function lfChooseOption(event) {
    const radio = event.currentTarget;
    const select = document.querySelector('select[name="' + radio.getAttribute('data-select') + '"]');

    select.value = radio.value;
    select.dispatchEvent(new Event('change', { bubbles: true }));
}

function lfStartOptions() {
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

document.addEventListener('DOMContentLoaded', lfStartOptions);
