import PhotoSwipeLightbox from './photoswipe-lightbox.esm.min.js';
const lightbox = new PhotoSwipeLightbox({
	gallery: '.pswp-gallery',
	children: 'a',
	pswpModule: () => import('./photoswipe.esm.min.js')
});
lightbox.on('uiRegister', function() {
	lightbox.pswp.ui.registerElement({
		name: 'custom-caption',
		order: 9,
		isButton: false,
		appendTo: 'root',
		html: 'Caption text',
		onInit: (el, pswp) => {
			lightbox.pswp.on('change', () => {
				const currSlideElement = lightbox.pswp.currSlide.data.element;
				let captionHTML = '';
				if (currSlideElement) {
					const captionElement = currSlideElement.parentNode.querySelector('.wp-element-caption');
					if (captionElement) {
						// get caption from element with class wp-element-caption
						captionHTML = captionElement.innerHTML;
					} else {
						// get caption from alt attribute
						captionHTML = currSlideElement.querySelector('img').getAttribute('alt');
					}
				}
				el.innerHTML = captionHTML || '';
			});
		}
	});
});
lightbox.init();
