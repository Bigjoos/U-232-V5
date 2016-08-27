$('.collapse').on('hidden.bs.collapse', function (e) {
	e.stopPropagation();
	if (this.id) {
		localStorage[this.id] = 'true';
	}
}).on('shown.bs.collapse', function(e) {
	e.stopPropagation();
	if (this.id) {
		localStorage.removeItem(this.id);
	}
}).each(function() {
//	localStorage.removeItem(this.id);
	if (this.id && localStorage[this.id] === 'true') {
		$(this).collapse('hide');
	}
});
