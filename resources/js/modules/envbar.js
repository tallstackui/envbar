export default (configuration, show) => ({
    init() {
        let closedAt = localStorage.getItem('envbar::closed');

        if (show === true) {
            closedAt = null;

            localStorage.removeItem('envbar::closed');
        }

        if (closedAt && Date.now() < parseInt(closedAt)) {
            this.element().style.display = 'none';
        }

        // We remove the storage item if the time has passed
        if (closedAt && Date.now() > parseInt(closedAt)) {
            localStorage.removeItem('envbar::closed');
        }

        if (Boolean(configuration.tailwind_breaking_points) === true) {
            this.breakpoint();

            window.addEventListener('resize', () => this.breakpoint());
        }
    },

    close() {
        const timeout = configuration.closable.timeout ?? null;

        this.element().style.display = 'none';

        localStorage.removeItem('envbar::closed');

        if (!timeout) {
            return;
        }

        localStorage.setItem('envbar::closed', String(Date.now() + parseInt(timeout) * 60000));
    },

    breakpoint () {
        const width = window.innerWidth;
        const span = this.element('resolution');

        if (width < 640) {
            return span.innerText = 'SM';
        }

        if (width >= 640 && width < 768) {
            return span.innerText = 'MD';
        }

        if (width >= 768 && width < 1024) {
            return span.innerText = 'LG';
        }

        if (width >= 1024 && width < 1280) {
            return span.innerText = 'XL';
        }

        if (width >= 1280 && width < 1536) {
            return span.innerText = '2XL';
        }

        return span.innerText = '> 2XL';
    },

    element (what = '') {
        let id = `envbar`;

        if (what) {
            id += `-${what}`;
        }

        return document.getElementById(id);
    },
})
