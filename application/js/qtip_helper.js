function errorQtip(error, element) {
		element.qtip({
			overwrite: false,
			content: error,
			show: {
				ready: true,
				event: false,
			},
			position: {
				my: 'left center',
				at: 'right center',
			},
			hide: false,
			style: {
				classes: 'qtip-red' // Make it red... the classic error colour!
			}					})
		// if we have a tooltip on this element already
		// just update it's content
}

function destroyQtip(element) {
	element.qtip('destroy');
}