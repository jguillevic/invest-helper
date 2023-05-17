$(document).ready(function()
{
    $(".add-dayschedulesection-button").click(function(event)
    {
        event.preventDefault();

        var dayId = $(this).attr("data-dayid");
        var dayScheduleId = $(this).attr("data-dayscheduleid");

        var sections = $("[id^=dayschedulesection-" + dayId + "]");

        var sectionsContainer = $("#dayschedulesections-container-" + dayId);

        var maxDayScheduleSectionId = 0;
        if (sections.length > 0)
        {
            $(sections).each(function()
            {
                var attrId = $(this).attr("id");
                var dayScheduleSectionId = parseInt(attrId.split("-")[2]);
                
                if (dayScheduleSectionId >= maxDayScheduleSectionId)
                {
                    maxDayScheduleSectionId = dayScheduleSectionId + 1;
                }
            });
        }

        var startingTimeInput = "store-schedule-dayschedule-id:" + dayScheduleId + "-dayid:" + dayId + "-dayschedulesection-id:" + maxDayScheduleSectionId + "-startingtime";
        var endingTimeInput = "store-schedule-dayschedule-id:" + dayScheduleId + "-dayid:" + dayId + "-dayschedulesection-id:" + maxDayScheduleSectionId + "-endingtime";
        var html = "<section id=\"dayschedulesection-dayid:" + dayId + "-dayschedulesectionid:" + maxDayScheduleSectionId + "\">";
        html += "<input type=\"time\" id=\"" + startingTimeInput + "\" name=\"" + startingTimeInput + "\" required>";
        html += "-";
        html += "<input type=\"time\" id=\"" + endingTimeInput + "\" name=\"" + endingTimeInput + "\" required>";
        html += "<button class=\"delete-dayschedulesection-button\" data-dayid=\"" + dayId + "\" data-dayschedulesectionid=\"" + maxDayScheduleSectionId + "\">x</button>";
        html += "</section>";
        sectionsContainer.append(html);

        $("#dayschedulesection-dayid\\:" + dayId + "-dayschedulesectionid\\:" + maxDayScheduleSectionId).find("button").click(function(event)
        {
            onDeleteDayScheduleSectionButtonClick(event, $(this));
        });
    });

    $(".delete-dayschedulesection-button").click(function(event)
    {
        onDeleteDayScheduleSectionButtonClick(event, $(this));
    });

    function onDeleteDayScheduleSectionButtonClick(event, elt)
    {
        event.preventDefault();

        var dayId = $(elt).attr("data-dayid")
        var dayScheduleSectionId = $(elt).attr("data-dayschedulesectionid");
        
        var section = $("#dayschedulesection-dayid\\:" + dayId + "-dayschedulesectionid\\:" + dayScheduleSectionId);
        
        section.fadeOut(600, function() { $(this).remove(); });
    }
});