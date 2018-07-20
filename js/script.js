(function($){
	$(document).ready(function(){
		var pdfWidth = ( $('.container').width() <= 460 ) ? $('.container').width() : $('.container').width() / 2;
		var pdfHeight = ( $('.container').width() <= 460 ) ? 400 : 600;
		$('a.media').media({width: pdfWidth, height: pdfHeight});
	}); // End document ready
})(this.jQuery);