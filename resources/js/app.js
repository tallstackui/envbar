import envbar from "./modules/envbar.js";

window.addEventListener('load', function () {
    if (typeof Alpine === 'undefined') {
        let divs = document.querySelectorAll('div[id^="envbar"]');

        divs = Array.from(divs).filter(envbar => envbar.id.includes('right-side'));

        divs.forEach(envbar => envbar.style.display = 'none');
    }
});

document.addEventListener('alpine:init', () => {
    Alpine.data('envbar', envbar);
});
