export default (configuration) => ({
    show: true,
    resolution: '',
    init() {
        const closedAt = localStorage.getItem('envbar::closed')

        if (closedAt && Date.now() < parseInt(closedAt)) {
            this.show = false
        }

        if (Boolean(configuration.tailwind_breaking_points) === true) {
            this.breakpoint();

            window.addEventListener('resize', () => this.breakpoint());
        }
    },
    close() {
        const timeout = configuration.closable.timeout ?? null;

        this.show = false

        localStorage.removeItem('envbar::closed')

        if (!timeout) {
            return;
        }

        localStorage.setItem('envbar::closed', String(Date.now() + (parseInt(timeout) * 1000)))
    },
    breakpoint() {
        if (window.innerWidth < 640) {
            this.resolution = 'SM';

            return;
        }

        if (window.innerWidth >= 640 && window.innerWidth < 768) {
            this.resolution = 'MD';

            return;
        }

        if (window.innerWidth >= 768 && window.innerWidth < 1024) {
            this.resolution = 'LG';

            return;
        }
        if (window.innerWidth >= 1024 && window.innerWidth < 1280) {
            this.resolution = 'XL';

            return;
        }
        if (window.innerWidth >= 1280 && window.innerWidth < 1536) {
            this.resolution = '2XL';

            return;
        }

        this.resolution = '3XL';
    }
})
