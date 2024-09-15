export default () => ({
    show: true,
    init() {
        const closedAt = localStorage.getItem('envbar::closed')

        if (closedAt && Date.now() < parseInt(closedAt)) {
            this.show = false
        }
    },
    close(timeout = null) {
        this.show = false

        localStorage.setItem('envbar::closed', String(Date.now() + 300000))
    }
})
