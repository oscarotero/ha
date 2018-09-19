export default function start(loader, event) {
    const color = getComputedStyle(document.body).getPropertyValue('--background-color');
    const div = document.createElement('div');

    div.style.backgroundColor = color;
    div.style.position = 'fixed';
    div.style.top = 0;
    div.style.left = 0;
    div.style.width = '100%';
    div.style.height = '100%';
    div.style.zIndex = 9;
    div.classList.add('js-transitioning');
    div.style.transformOrigin = 'left center';

    document.body.appendChild(div);

    const animation = new Promise(resolved => {
        if ('animate' in div) {
            const anim = div.animate([
                {opacity: 0},
                {opacity: 1}
            ], {
                duration: 666,
                easing: 'ease',
                fill: 'both'
            });

            anim.onfinish = resolved;
        } else {
            anime({
                targets: div,
                opacity: [0, 1],
                easing: 'easeInQuad',
                duration: 333,
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

        return page.replaceStyles()
            .then(page => {
                page.removeContent('body > :not(.js-transitioning)')
                    .replaceContent('meta[name="theme-color"]')
                    .appendContent('body');
                
                document.body.className = page.dom.body.className;
                document.body.classList.add('anim-transition');
                document.scrollingElement.scrollTop = 0;

                return new Promise(resolved => {
                    if ('animate' in div) {
                        const anim = div.animate([
                            {opacity: 1},
                            {opacity: 0}
                        ], {
                            duration: 666,
                            easing: 'ease',
                            fill: 'both'
                        });

                        anim.onfinish = () => {
                            div.remove();
                            resolved();
                        };
                    } else {
                        anime({
                                targets: div,
                                easing: 'easeInQuad',
                                duration: 333,
                                opacity: [1, 0],
                                complete: () => {
                                    div.remove();
                                    resolved();
                                }
                        });
                    }
                });
            })
    })
}
