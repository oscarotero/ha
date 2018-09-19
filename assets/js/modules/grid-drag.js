export default class GridDrag extends HTMLElement {
    static get observedAttributes() {
        return ['gridx', 'gridy'];
    }

    constructor() {
        super();
        this.dragging = false;
        this.grid = { x: 100, y: 100 };
        this.gridItems = {};
    }

    connectedCallback() {
        this.addEventListener('dragstart', ev => {
            const target = ev.target;

            if (target && target.draggable) {
                this.dragging = target;
                ev.dataTransfer.dropEffect = 'copy';
                ev.dataTransfer.setData(
                    'text/plain',
                    JSON.stringify({
                        left: ev.offsetX,
                        top: ev.offsetY
                    })
                );
            }
        });

        this.addEventListener('dragend', ev => {
            this.dragging = false;
            ev.preventDefault();
        });

        this.addEventListener('dragover', ev => ev.preventDefault());

        this.addEventListener('drop', ev => {
            if (this.dragging) {
                const position = JSON.parse(ev.dataTransfer.getData('text/plain'));
                const clone = this.dragging.cloneNode(true);
                const rect = this.getBoundingClientRect();
                const top = calculate(ev.y - position.top - rect.top, this.grid.y);
                const left = calculate(ev.x - position.left - rect.left, this.grid.x);

                if (top !== false && left !== false) {
                    clone.style.top = `${top}px`;
                    clone.style.left = `${left}px`;
                    this.appendChild(clone);
                    const key = `${top}x${left}`;

                    if (this.gridItems[key]) {
                        this.gridItems[key].remove();
                    }

                    this.gridItems[key] = clone;
                }
            }

            ev.preventDefault();
        });
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === 'gridx') {
            this.grid.x = parseInt(newValue);
        } else if (name === 'gridy') {
            this.grid.y = parseInt(newValue);
        }
    }
}

function calculate(coord, grid) {
    return Math.round(coord / grid) * grid;
}
