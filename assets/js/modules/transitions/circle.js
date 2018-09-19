export default function start(loader, event, baseColor) {
    const color = getComputedStyle(event.target).getPropertyValue(baseColor ? '--base-background-color' : '--background-color');
    const svg = createSvg(event.clientX, event.clientY, color);
    svg.classList.add('js-transitioning');

    document.body.appendChild(svg);

    const animation = new Promise(resolved => {
        const el = svg.firstElementChild;

        if ('animate' in el) {
            const anim = svg.firstElementChild.animate([
                {transform: 'scale(.01)'},
                {transform: 'scale(1)'}
            ], {
                duration: 666,
                easing: 'ease',
                fill: 'both'
            });

            anim.onfinish = resolved;
        } else {
            anime({
                targets: el,
                scale: [.01, 1],
                easing: 'easeInQuad',
                duration: 666,
                complete: resolved
            })
        }
    });

    return Promise.all([
        loader.load(),
        animation
    ])
    .then(args => {
        const [page] = args;
        document.scrollingElement.scrollTop = 0;

        return page.replaceStyles()
            .then(page => {
                page.removeContent('body > :not(.js-transitioning)')
                    .replaceContent('meta[name="theme-color"]')
                    .appendContent('body');

                document.body.className = page.dom.body.className;
                document.body.classList.add('anim-transition');
                document.scrollingElement.scrollTop = 0;
                svg.remove();
            })
    })
}

function createSvg(x, y, color) {
    const width = window.innerWidth;
    const height = window.innerHeight;

    const svg = createNode('svg', {
        width: width,
        height: height,
        viewBox: `0 0 ${width} ${height}`,
        preserveAspectRatio: 'none',
        style: {
            fill: color,
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            zIndex: 9
        }
    });

    const r = Math.max(
        Math.hypot(x, y),
        Math.hypot(x, height - y),
        Math.hypot(width - x, y),
        Math.hypot(width - x, height - y)
    );

    svg.appendChild(createNode('circle', {
        cx: x,
        cy: y,
        r: r,
        style: {
            'transform-origin': `${x}px ${y}px`
        }
    }));

    return svg;
}

function createNode(name, properties = {}) {
    const node = document.createElementNS('http://www.w3.org/2000/svg', name);

    Object.keys(properties).forEach(name => {
        if (name === 'style') {
            Object.keys(properties[name]).forEach(propName =>
                node.style[propName] = properties[name][propName]
            );

            return;
        }

        node.setAttributeNS(null, name, properties[name]);
    });

    return node;
}
