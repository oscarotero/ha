(function() {
    const polyfills = [
        {
            file: '/js/polyfills/smoothscroll-polyfill/smoothscroll.js',
            test: () => 'scroll' in document.documentElement && 'scrollBehavior' in document.documentElement.style
        },
        {
            file: '/js/polyfills/@webcomponents/custom-elements/custom-elements.min.js',
            test: () => 'customElements' in window
        },
        {
            file: '/js/polyfills/animejs/anime.min.js',
            test: () => 'animate' in document.documentElement
        }
    ];

    window.polyfillsLoaded = Promise.all(
        polyfills.filter(polyfill => !polyfill.test()).map(polyfill => {
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = polyfill.file;
                document.head.appendChild(script);
                script.addEventListener('load', () => {
                    console.info(`Polyfill script "${script.src}" loaded successfully`);
                    resolve();
                });

                script.addEventListener('error', () => {
                    console.error(`Error loading polyfill script "${script.src}"`);
                    reject();
                });
            });
        })
    );
})();
