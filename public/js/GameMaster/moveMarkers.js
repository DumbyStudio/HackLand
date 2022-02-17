var selectPlayerMarker;
var playerMarkerFollow = false;
var selectNpcMarker;
var npcMarkerFollow = false;

$(".NpcMarker").mousedown(function() {
    if(!playerMarkerFollow && !npcMarkerFollow)
    {
        //select npc
        if(selectNpcMarker != undefined) {
            selectNpcMarker.removeClass("selectedMarker");
        }
        selectNpcMarker = $(this);
        $("#NpcToggle").prop('checked', !selectNpcMarker.hasClass("HiddenMarker"));
        selectNpcMarker.addClass("selectedMarker");

        //move npc
        if($(this).is(selectNpcMarker)) {
            npcMarkerFollow = true;
            moveMarkersToMouse();
        }
    }
});

$(".PlayerMarker").mousedown(function() {
    if(!playerMarkerFollow && !npcMarkerFollow)
    {
        //select player
        if(selectPlayerMarker != undefined) {
            selectPlayerMarker.removeClass("selectedMarker");
            selectPlayerMarker.children().remove();
        }
        selectPlayerMarker = $(this);
        $("#selectPlayerName").html(selectPlayerMarker.attr("name"));
        selectPlayerMarker.addClass("selectedMarker");

        //move player
        if($(this).is(selectPlayerMarker)) {
            playerMarkerFollow = true;
        }

        //put element to last position in parent
        selectPlayerMarker.parent().append(selectPlayerMarker);

        //display name of current player
        selectPlayerMarker.append("<span class='playerName'>" + selectPlayerMarker.attr("name") + "</span>");

        moveMarkersToMouse();
    }
});

$("body").mouseup(function() {
    npcMarkerFollow = false;
    playerMarkerFollow = false;
});

$("#map").mousemove(function() {
    moveMarkersToMouse();
});

function moveMarkersToMouse() {
    var map = $("#map");
    var mapLeft = map.offset().left + 13;
    var mapTop = map.offset().top + 13;
    var mapRight = map.offset().right - 13;
    var mapBottom = map.offset().bottom - 13;

    var relX = event.pageX - mapLeft;
    var relY = event.pageY - mapTop;

    if(playerMarkerFollow) {
        if(relX < mapLeft || relX > mapRight) { //bloquage horizontal
            relX = selectPlayerMarker.attr("left");
        }
        if(relY < mapTop || relY > mapBottom) { //bloquage vertical
            relY = selectPlayerMarker.attr("top");
        }
        players[selectPlayerMarker.attr("id")].move(relX, relY);
    } else
    if(npcMarkerFollow) {
        if(relX < mapLeft || relX > mapRight) { //bloquage horizontal
            relX = selectNpcMarker.attr("left");
        }
        if(relY < mapTop || relY > mapBottom) { //bloquage vertical
            relY = selectNpcMarker.attr("top");
        }
        selectNpcMarker.css( { left: relX, top: relY } );
    }
}