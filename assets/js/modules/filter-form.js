import { FormLoader } from '../vendor/@oom/page-loader/loaders.js';
import target from './transitions/target.js';
import Storage from './storage.js';

const latestFilters = new Storage('latest-filters');

export default function handleForm(form, start) {
    form.querySelectorAll('.js-trending').forEach(el => trending(el));
    form.querySelectorAll('.js-age').forEach(el => age(el));
    form.querySelectorAll('output').forEach(el => output(el));
    form.querySelectorAll('input,select').forEach(field => {
        field.addEventListener('change', e => {
            const event = document.createEvent('HTMLEvents');
            event.initEvent('submit', true, false);
            form.dispatchEvent(event);
        });
    });

    form.querySelectorAll('.js-hidden').forEach(e => (e.hidden = true));

    form.addEventListener('submit', e => {
        submit(form, start, e);
        e.preventDefault();
    });
}

function submit(form, start, event) {
    target(new FormLoader(form), event);
}

function age(input) {
    const range = document.querySelector(input.dataset.range);
    range.parentElement.hidden = !input.checked;

    input
        .closest('.searchForm-group')
        .querySelectorAll('input[type="radio"][name="' + input.name + '"]')
        .forEach(el => {
            el.addEventListener('change', e => {
                range.parentElement.hidden = !input.checked;
                range.disabled = !input.checked;
            });
        });
}

function output(output) {
    const range = document.querySelector(output.dataset.range);
    range.addEventListener('input', e => (output.innerText = range.value));
    output.innerText = range.value;
}

function handleRanges(input) {
    const output = input.parentNode.querySelector('output');
    input.addEventListener('input', () => (output.innerText = input.value));
    output.innerText = input.value;
}

function trending(select) {
    if (select.dataset.trending) {
        const trending = latestFilters.getOrCreate(select.name, JSON.parse(select.dataset.trending));

        trending.splice(3);

        const options = Array.from(select.options);

        //Botón "Todos"
        select.before(createTrendingButton(select, options[0]));

        //Botóns trending
        trending.forEach(topic => {
            const option = options.find(option => option.value === topic);

            if (option) {
                select.before(createTrendingButton(select, option));
            }
        });

        //Botón "ver máis"
        select.before(createOtherButton(select));

        select.addEventListener('change', e => {
            if (!trending.includes(select.value)) {
                trending.unshift(select.value);
                latestFilters.save();
            }
        });
    }
}

function createTrendingButton(select, option) {
    const btn = document.createElement('button');
    btn.type = 'submit';
    btn.name = select.name;
    btn.value = option.value;
    btn.classList.add('searchForm-option');
    btn.innerText = option.label;
    btn.addEventListener('click', e => {
        if (select.value === btn.value) {
            e.preventDefault();
            return;
        }

        selectButton(btn);
        select.value = btn.value;
        select.disabled = !btn.value;
    });

    if (btn.value === select.value) {
        btn.classList.add('is-selected');
    }

    return btn;
}

function createOtherButton(select) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.classList.add('searchForm-option');
    btn.classList.add('is-more');
    btn.innerText = 'Otro';

    btn.addEventListener('click', e => {
        selectButton(btn);
        select.disabled = false;
    });

    if (!select.parentElement.querySelector('.searchForm-option.is-selected')) {
        btn.classList.add('is-selected');
    }

    return btn;
}

function selectButton(btn) {
    btn.parentElement
        .querySelectorAll('.searchForm-option.is-selected')
        .forEach(el => el.classList.remove('is-selected'));
    btn.classList.add('is-selected');
}
