showPlayerInfos = true;
showNpcInfos = true;
showQuestInfos = true;

$(".ToggleInfos").mousedown(function() {
    var infosDiv = $(this).parent();
    var infosBlock = infosDiv.children(".infos");
    var id = infosDiv.attr("id");

    if(id == "PlayerInfos")
    {
        if(showPlayerInfos)
        {
            infosBlock.addClass("infosHide");
            $(this).children(":first").html(">");
        }
        else
        {
            infosBlock.removeClass("infosHide");
            $(this).children(":first").html("<");
        }
        showPlayerInfos = !showPlayerInfos;
    }

    if(id == "NpcInfos")
    {
        if(showNpcInfos)
        {
            infosBlock.addClass("infosHide");
            $(this).children(":first").html(">");
        }
        else
        {
            infosBlock.removeClass("infosHide");
            $(this).children(":first").html("<");
        }
        showNpcInfos = !showNpcInfos;
    }

    if(id == "QuestInfos")
    {
        if(showQuestInfos)
        {
            infosBlock.addClass("infosHide");
            $(this).children(":first").html("<");
        }
        else
        {
            infosBlock.removeClass("infosHide");
            $(this).children(":first").html(">");
        }
        showQuestInfos = !showQuestInfos;
    }

});