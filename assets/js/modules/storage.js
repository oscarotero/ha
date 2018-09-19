class Storage {
    constructor(domain) {
        this.domain = domain;
        this.data = {};
        this.reload();
    }

    reload() {
        try {
            this.data = JSON.parse(localStorage.getItem(this.domain)) || {};
        } catch (err) {
            console.error(err);
        }

        return this;
    }

    has(name) {
        return name in this.data;
    }

    get(name) {
        return this.data[name];
    }

    getOrCreate(name, value) {
        if (!this.has(name)) {
            this.set(name, value);
        }

        return this.get(name);
    }

    set(name, value) {
        this.data[name] = value;
        return this;
    }

    remove(name) {
        delete this.data[name];
        return this;
    }

    save() {
        try {
            localStorage.setItem(this.domain, JSON.stringify(this.data));
        } catch (err) {
            console.error(err);
        }
    }
}

export default Storage;
