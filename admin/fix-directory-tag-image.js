(function($) {
    $(document).ready(function() {
        const observer = new MutationObserver(function() {
            const $btn = $('.media-button-select');
            if ($btn.length && $btn.is(':visible') && $btn.width() === 0) {
                console.log('⚠️ Detected 0-width Select button. Forcing visible layout.');
                $btn.css({
                    'display': 'inline-block',
                    'min-width': '100px',
                    'min-height': '40px',
                    'padding': '0.5rem 1rem',
                    'font-size': '14px',
                    'z-index': 10000
                });
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
})(jQuery);
