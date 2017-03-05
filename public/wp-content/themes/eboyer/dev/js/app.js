var mcgg = {};

mcgg.init = function() {
	mcgg.homeFiltering();
	mcgg.videos();
};

mcgg.homeFiltering = function(){
	$(window).on("scroll", function(){
		var header = $(".js-North"),
				changeOffest = 0;

		if($(this).scrollTop() > changeOffest){
			header.addClass("_scrolled");
		}
		else{
			header.removeClass("_scrolled");
		}
	});
}

mcgg.videos = function(){
	$(".js-Video").each(function(){
		$(this).fitVids();
	});
}

$(function() { mcgg.init(); });
