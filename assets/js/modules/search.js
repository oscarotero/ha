import { AjaxSuggestions, Suggestion, Group } from '../vendor/@oom/suggestions/suggestions.js';

import Storage from './storage.js';

class DetailSuggestion extends Suggestion {
    render(element) {
        element.classList.add('suggestion');
        const detail = this.data.detail ? `<p class="suggestion-detail">${this.data.detail}</p>` : '';

        element.innerHTML = `
            <a href="${this.data.value}">
                <div class="suggestion-header">
                    <h5 class="suggestion-title">${this.data.label}</h5>
                    ${detail}
                </div>
            </a>
        `;
    }
}

class ImageSuggestion extends Suggestion {
    render(element) {
        this.allowSave = true;

        element.classList.add('suggestion');
        const detail = this.data.detail ? `<p class="suggestion-detail">${this.data.detail}</p>` : '';

        element.innerHTML = `
            <a href="${this.data.value}">
                <div class="suggestion-image">
                    <img src="${this.data.img}">
                </div>
                <div class="suggestion-header">
                    <h5 class="suggestion-title">${this.data.label}</h5>
                    ${detail}
                </div>
            </a>
        `;
    }
}

class ArtworkSuggestion extends ImageSuggestion {
    render(element) {
        super.render(element);
        element.style = `--background-color: ${this.data.background}; --foreground-color: ${this.data.foreground}`;
    }
}

class TagSuggestion extends Suggestion {
    render(element) {
        element.classList.add('suggestion');
        element.innerHTML = `
            <a href="${this.data.value}" class="tag is-suggestion">
                ${this.data.label}
            </a>
        `;
    }
}

class MenuSuggestion extends Suggestion {
    render(element) {
        element.classList.add('suggestion', 'is-menu');
        element.innerHTML = `
            <a href="${this.data.value}">
                ${this.data.label}
            </a>
        `;
    }
}

class HaGroup extends Group {
    render(element) {
        element.classList.add('suggestions-group');
        element.classList.add(`has-${this.data.type}`);
        element.innerHTML = `<h4 class="suggestions-group-title">${this.data.label}</h4>`;
    }
    createSuggestion(data) {
        switch (data.type || this.data.type) {
            case 'artist':
            case 'reportage':
            case 'technique':
            case 'movement':
            case 'country':
                return new ImageSuggestion(data, this);

            case 'artwork':
                return new ArtworkSuggestion(data, this);

            case 'museum':
                return new DetailSuggestion(data, this);

            case 'tag':
                return new TagSuggestion(data, this);

            case 'menu':
                return new MenuSuggestion(data, this);
        }
    }
}

class HaAjaxSuggestions extends AjaxSuggestions {
    createGroup(data) {
        return new HaGroup(data, this);
    }
}

export default function search(form, go) {
    const body = document.body;
    const input = form.querySelector('.js-search-input');
    const close = form.querySelector('.js-search-close');
    const results = document.querySelector('.js-results');
    const source = new HaAjaxSuggestions(input.dataset.source, results);

    source.attachInput(input);

    const storage = new Storage('search');
    const latestSearches = storage.getOrCreate('latests', []);
    latestSearches.splice(5);

    form.addEventListener('submit', event => {
        if (input.value.trim().length < 3) {
            event.preventDefault();
            input.focus();
        }
    });

    input.addEventListener('focus', openSearch);
    close.addEventListener('click', closeSearch);

    input.addEventListener('keydown', e => {
        if (e.keyCode === 27) {
            //Esc
            input.value = '';
            input.blur();
            closeSearch();
        }
    });

    input.addEventListener('suggestions:select', e => {
        input.value = source.query || '';
        const suggestion = e.detail;

        if (suggestion.allowSave) {
            const key = latestSearches.findIndex(s => s.value == suggestion.data.value);

            if (key !== -1) {
                latestSearches.splice(key, 1);
            }

            latestSearches.unshift(
                Object.assign(
                    {},
                    suggestion.data,
                    { type: suggestion.data.type || suggestion.parent.data.type }
                )
            );

            storage.save();
        }

        closeSearch();
        go(suggestion.data.value, e);
        // document.location = suggestion.data.value;
    });

    if (document.activeElement === input) {
        input.blur();
        openSearch();
        input.focus();
    }

    function displayHome() {
        source
            .load([
                {
                    label: 'Menú',
                    type: 'menu',
                    options: [
                        {
                            label: 'Obras',
                            value: '/obras'
                        },
                        {
                            label: 'Artistas',
                            value: '/artistas'
                        },
                        {
                            label: 'Artículos',
                            value: '/articulos'
                        },
                        {
                            label: 'Movimientos',
                            value: '/movimientos'
                        },
                        {
                            label: 'Técnicas',
                            value: '/tecnicas'
                        },
                        {
                            label: 'Países',
                            value: '/paises'
                        },
                        {
                            label: 'Museos',
                            value: '/museos'
                        }
                    ]
                },
                {
                    label: 'Buscado recientemente',
                    options: latestSearches
                }
            ])
            .refresh(() => true);
    }

    function openSearch() {
        body.classList.add('has-search-opened');

        if (!input.value) {
            displayHome();
        }
    }

    function closeSearch() {
        body.classList.remove('has-search-opened');
    }
}
