/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

(function () {
	const siteNavigation = document.getElementById('site-navigation');
	// Return early if the navigation doesn't exist.
	if (!siteNavigation) {
		return;
	}

	const button = siteNavigation.querySelector('button');
	// Return early if the button doesn't exist.
	if (typeof button === 'undefined' || button === null) {
		return;
	}

	const menu = siteNavigation.querySelector('ul');
	// Hide menu toggle button if menu is empty and return early.
	if (typeof menu === 'undefined' || menu === null) {
		button.style.display = 'none';
		return;
	}

	if (!menu.classList.contains('nav-menu')) {
		menu.classList.add('nav-menu');
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener('click', function () {
		siteNavigation.classList.toggle('toggled');
		const expanded = button.getAttribute('aria-expanded') === 'true';
		button.setAttribute('aria-expanded', expanded ? 'false' : 'true');
	});

	// Remove the .toggled class and set aria-expanded to false when clicking outside the navigation.
	document.addEventListener('click', function (event) {
		if (!siteNavigation.contains(event.target)) {
			siteNavigation.classList.remove('toggled');
			button.setAttribute('aria-expanded', 'false');
		}
	});

	// Get all the link elements within the menu.
	const links = menu.querySelectorAll('a');
	// Get all the link elements with children within the menu.
	const linksWithChildren = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

	// Toggle focus each time a menu link is focused or blurred.
	links.forEach(function (link) {
		link.addEventListener('focus', toggleFocus, true);
		link.addEventListener('blur', toggleFocus, true);
	});

	// Toggle focus each time a menu link with children receives a touch event.
	linksWithChildren.forEach(function (link) {
		link.addEventListener('touchstart', toggleFocus, false);
	});

	/**
	 * Sets or removes .focus class on an element based on event type and context.
	 */
	function toggleFocus(event) {
		if (!event) {
			event = window.event;
		}
		if (event.type === 'focus' || event.type === 'blur') {
			let self = this;
			// Move up through the ancestors of the current link until .nav-menu is found.
			while (self && !self.classList.contains('nav-menu')) {
				// On <li> elements, toggle the .focus class.
				if (self.tagName && self.tagName.toLowerCase() === 'li') {
					self.classList.toggle('focus');
				}
				self = self.parentNode;
			}
		}
		if (event.type === 'touchstart') {
			const menuItem = this.parentNode;
			event.preventDefault();
			// Remove .focus from other siblings.
			Array.prototype.forEach.call(menuItem.parentNode.children, function (child) {
				if (menuItem !== child) {
					child.classList.remove('focus');
				}
			});
			menuItem.classList.toggle('focus');
		}
	}
})();
