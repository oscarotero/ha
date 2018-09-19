export default function start(loader, event) {
    const target = (event.target.tagName === 'A' || event.target.tagName === 'FORM') ? event.target : event.target.closest('a');
    const targetSelector = target.dataset.targetSelector;
    const targetElement = document.querySelector(targetSelector);

    targetElement.style.animationName = 'fadeOut';
    targetElement.style.animationDuration = '.3s';
    targetElement.style.animationFillMode = 'both';

    return loader.load(true)
        .then(page => {
            page.replaceContent(targetSelector);
            document.querySelector('.matomo')
                .setAttribute('src',
                    'https://analytics.historia-arte.com/img.php?' + 
                    new URLSearchParams([['idsite', 1], ['rec', 1], ['url', document.location.href]])
                )
        })
        .catch(err => loader.fallback())
}
