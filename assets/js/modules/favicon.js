const size = 16 * window.devicePixelRatio;
const transparent = ['white', 'transparent', '#fff', '#ffffff'];

export default function changeFavicon(foreground, background) {
    return createLogo(foreground || '#333').then(img => {
        const canvas = document.createElement('canvas');
        canvas.width = size;
        canvas.height = size;

        const context = canvas.getContext('2d');

        if (background && transparent.indexOf(background.toLowerCase()) === -1) {
            context.fillStyle = background;
            context.fillRect(0, 0, size, size);
            const margin = window.devicePixelRatio;
            context.drawImage(img, margin, margin, size - margin * 2, size - margin * 2);
        } else {
            context.drawImage(img, 0, 0, size, size);
        }

        document.querySelectorAll('link[rel="icon"]').forEach(link => link.remove());

        const link = document.createElement('link');
        link.type = 'image/x-icon';
        link.rel = 'icon';
        document.head.appendChild(link);

        link.href = canvas.toDataURL();
    });
}

function createLogo(color) {
    const image = new Image();

    image.src =
        'data:image/svg+xml,' +
        escape(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 200" width="${size}" height="${size}" fill="${color}"><rect x="300" y="150" width="50" height="50"/><rect x="300" width="50" height="120"/><path d="M240,200h60L190,0H110V80H50V0H0V200H50V120h60v80h50V160h60Zm-80-80V40l40,80Z"/></svg>`
        );

    return new Promise((resolve, reject) => {
        image.onload = () => resolve(image);
        image.onerror = () => reject(image);
    });
}
