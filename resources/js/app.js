import envbar from "./modules/envbar.js";

document.addEventListener('alpine:init', () => {
    Alpine.data('envbar', envbar);
});
