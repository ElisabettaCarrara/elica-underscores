/* global wp */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function () {
	if (typeof wp.customize !== 'undefined') {
		// Site title
		wp.customize('blogname', function (value) {
			value.bind(function (to) {
				var siteTitleLinks = document.querySelectorAll('.site-title a');
				siteTitleLinks.forEach(function (element) {
					element.textContent = to;
				});
			});
		});

		// Site description
		wp.customize('blogdescription', function (value) {
			value.bind(function (to) {
				var siteDesc = document.querySelectorAll('.site-description');
				siteDesc.forEach(function (element) {
					element.textContent = to;
				});
			});
		});

		// Header text color
		wp.customize('header_textcolor', function (value) {
			value.bind(function (to) {
				var titles = document.querySelectorAll('.site-title, .site-description');
				var titleLinksDesc = document.querySelectorAll('.site-title a, .site-description');

				if (to === 'blank') {
					titles.forEach(function (element) {
						element.style.clip = 'rect(1px, 1px, 1px, 1px)';
						element.style.position = 'absolute';
					});
				} else {
					titles.forEach(function (element) {
						element.style.clip = 'auto';
						element.style.position = 'relative';
					});
					titleLinksDesc.forEach(function (element) {
						element.style.color = to;
					});
				}
			});
		});
	}
})();
