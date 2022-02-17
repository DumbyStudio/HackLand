$("#NpcToggle").mousedown(function() {
    hidden = false;
    if(selectNpcMarker.hasClass("HiddenMarker"))
    {
        hidden = true;
    }

    if(hidden == true)
    {
        selectNpcMarker.removeClass("HiddenMarker");
        if(selectNpcMarker.hasClass("_PacifistNpc"))
        {
            selectNpcMarker.removeClass("_PacifistNpc");
            selectNpcMarker.addClass("PacifistNpc");
        }
        if(selectNpcMarker.hasClass("_NeutralNpc"))
        {
            selectNpcMarker.removeClass("_NeutralNpc");
            selectNpcMarker.addClass("NeutralNpc");
        }
        if(selectNpcMarker.hasClass("_EvilNpc"))
        {
            selectNpcMarker.removeClass("_EvilNpc");
            selectNpcMarker.addClass("EvilNpc");
        }
    }
    else
    {
        selectNpcMarker.addClass("HiddenMarker");
        if(selectNpcMarker.hasClass("PacifistNpc"))
        {
            selectNpcMarker.removeClass("PacifistNpc");
            selectNpcMarker.addClass("_PacifistNpc");
        }
        if(selectNpcMarker.hasClass("NeutralNpc"))
        {
            selectNpcMarker.removeClass("NeutralNpc");
            selectNpcMarker.addClass("_NeutralNpc");
        }
        if(selectNpcMarker.hasClass("EvilNpc"))
        {
            selectNpcMarker.removeClass("EvilNpc");
            selectNpcMarker.addClass("_EvilNpc");
        }
    }
});