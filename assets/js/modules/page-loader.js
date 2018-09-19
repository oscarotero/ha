import Navigator from '../vendor/@oom/page-loader/navigator.js';
import circle from './transitions/circle.js';
import square from './transitions/square.js';
import target from './transitions/target.js';

export default function init(start) {
    const nav = new Navigator((loader, event) => {
        const transition = getTransition(loader.url, event);

        transition(loader, event)
            .then(() => {
                const t = transition === target ? document.querySelector(getTarget(event)) : document.body;
                start(t);
            })
            .catch(err => {
                console.error(err);
                loader.fallback();
            });
    });

    return nav.init();
}

function getTransition(to, event) {
    if (getTarget(event)) {
        return target;
    }

    const { host, protocol } = document.location;

    to = to
        .replace(protocol, '')
        .replace(host, '')
        .replace('///', '')
        .split('/', 2);

    if (event.clientX && event.clientY) {
        if (getLink(event).matches('.suggestion a')) {
            return square;
        }

        if ((to[0] === 'obras' || to[0] === 'articulos') && to[1]) {
            return circle;
        }

        return (loader, event) => circle(loader, event, true);
    }

    return square;
}

function getLink(event) {
    let el = event.target;

    if (el === window) {
        return;
    }

    return el.tagName === 'A' ? el : el.closest('a');
}

function getTarget(event) {
    const el = getLink(event);

    return el ? el.dataset.targetSelector : undefined;
}
