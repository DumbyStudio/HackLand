var players = [];
var PlayersNumber = 4;

$( document ).ready(function() {
    createCharacters();
    randomizePos();
});

randomizePos = function() {
    var map = $("#map");
    for(let i = 1; i <= PlayersNumber; i ++) {
        var posX = Math.random() * map.width();
        var posY = Math.random() * map.height();
        players["Player"+i].move(posX, posY);
    }
}

createCharacters = function() {
    var map = $("#map");
    for(let i = 1; i <= PlayersNumber; i ++)
    {
        let element = $("#Player"+i);
        players['Player'+i] = new Player(element, element.attr('name'), 0, 0);
    }
}