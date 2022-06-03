$(".taskbar-task").click(function() {
    $(".taskbar-task-selected").removeClass("taskbar-task-selected");
    $(this).parent().addClass("taskbar-task-selected");
});

$('div').on( "click", function() {
    console.log($(this).prop('nodeName'));
});

$(document).on( 'click', '.taskbar-task', function () {
    $(".taskbar-task-selected").removeClass("taskbar-task-selected");
    $(this).addClass("taskbar-task-selected");
});

var taskOver = false;
$('.taskbar-task').on('mouseenter', function() {taskHover = $(this);console.log("enter task")});
$('.taskbar-task').on('mouseleave', function() {taskHover = false;console.log("leave task")});