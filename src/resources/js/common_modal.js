document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('modalTrigger');
    const overlay = document.getElementById('modalOverlay');
    const closeBtn = document.getElementById('modalClose');

    if (trigger && overlay && closeBtn) {
        trigger.addEventListener('click', function () {
            overlay.classList.add('active');
        });
        closeBtn.addEventListener('click', function () {
            overlay.classList.remove('active');
        });
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                overlay.classList.remove('active');
            }
        });
    }
});