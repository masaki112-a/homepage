import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Alpine from 'alpinejs';
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

window.Alpine = Alpine;
Alpine.start();


['postModal', 'confirmModal'].forEach(id => {
    document.getElementById(id)?.addEventListener('hide.bs.modal', function () {
        document.activeElement.blur();
    });
});

import './schedule-popup.js'
import './common_modal.js'