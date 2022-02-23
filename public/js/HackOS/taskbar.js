$(".taskbar-task").click(function() {
    $(".taskbar-task-selected").removeClass("taskbar-task-selected");
    $(this).parent().addClass("taskbar-task-selected");
});

$('div').on( "click", function() {
    console.log($(this).prop('nodeName'));
});

$(document).on( 'click', '.taskbar-task-logo', function () { 
    alert('clicked');
});

/*$(".taskbar-task").on('click', function () {
    alert('clicked');
});*/