/**
 * Customizer live preview bindings (no-reload updates).
 *
 * @package PulseLyft
 */
(function () {
	'use strict';
	if (!window.wp || !wp.customize) {
		return;
	}

	var map = {
		pulselyft_hero_sub: '.pl-hero__sub',
		pulselyft_cta_title: '#pl-cta-title',
		pulselyft_cta_sub: '.pl-cta__sub',
		pulselyft_cta_button: '.pl-cta__panel .pl-btn',
		pulselyft_book_title: '#pl-book-title',
		pulselyft_contact_title: '#pl-contact-title'
	};

	Object.keys(map).forEach(function (setting) {
		wp.customize(setting, function (value) {
			value.bind(function (to) {
				var el = document.querySelector(map[setting]);
				if (el) {
					el.textContent = to;
				}
			});
		});
	});
})();
