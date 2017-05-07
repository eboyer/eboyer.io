$(function() {

	var pages = ["page2.html", "page3.html", "page4.html"];

	pages.forEach(function(item, index, array) {
		console.log(item, index);

		$.ajax({
			url: item,
			type: 'GET',
			dataType: 'html',
			success: function(html) {
				console.log(html);
				// var div = $('.site', $(html)).addClass('done');
				console.log($(html).find('.site'));
				// $('.modals').append(div);
				// $(".modals").html(html);
				console.log($('.modals'));
			}
		});
	});
});
