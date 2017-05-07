var modalContents = "",
    modalContentsContainer = $("#modal").find(".modal-contents");

$("#modal").hide();

$('#detroit').on('click', function(){
    fireModal(); 
});

$('#ann-arbor').on('click', function(){
    fireModal();
});

$('#grand-rapids').on('click', function(){
    modalContents = $("#page-grand_rapids").html();
    fireModal();
});

$('#holland').on('click', function(){
    fireModal();
});

$('#kalamazoo').on('click', function(){
    fireModal();
});

$('#traverse-city').on('click', function(){
    fireModal();
});

$('#charlevoix').on('click', function(){
    fireModal();
});

$('#mackinac-island').on('click', function(){
    fireModal();
});

$('#munising').on('click', function(){
    fireModal();
});

$('#exit').on('click', function(){
	$('#modal').hide();
});


var pages = [
    {
        id: 'detroit',
        path: 'cities/detroit.html'
    },
    {
        id: 'grand_rapids',
        path: 'cities/grand_rapids.html'
    }
];

pages.forEach(function(item, index, array) {
    console.log(item, index);
    var div = "<div class='page' id='page-" + item.id + "'></div>";
    $(".pages").append(div);
    $("#page-" + item.id).load(item.path + ' .site');
});

function fireModal() {
    modalContentsContainer.html(modalContents);
    $("#modal").show();
}
