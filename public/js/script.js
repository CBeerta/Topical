/**
* @author: Claus Beerta
*
*/

$(document).ready(function() 
{
    $(document.documentElement).keyup(function(event) 
    {
        //console.log(event.which);
        if ($(event.target).is(':not(input, textarea)'))
        {
            switch (event.which)
            {
                case 65: // a
                case 78: // n
                    $("input#todo_task").focus();
                    break;
                case 72: // h
                    toggle_help();
                    break;
                case 37: //left
                    load_calendar(document.yesterday);
                    break;
                case 39: //right
                    load_calendar(document.tomorrow);
                    break;
                case 36: //pos1
                    load_calendar('today');
                    break;
            }
        }
    });

	$(".todo#sortable").sortable(
	{ 
	    handle: 'img#todo_move', 
	    opacity: 1.0,
	    axis: 'y',
        update : function () {
            $.post("?/todo/sort", { todo_order: $('.todo#sortable').sortable("serialize") });      
        }
    });
    
    $('.help').click(toggle_help);
    
	$("#sortable").disableSelection();
	
    $("#todo_save").submit(function() 
    {
        $("input#todo_task").blur();
        var task = $('#todo_task').attr('value');  
        $.ajax({  
            type: "POST",
            url: "?/todo/save",
            data: { 'value': task },
            success: function(id)
            {
                $("#todo_task").attr('value', '');
                $.post('?/todo/load/formatted', { 'id' : id } , function ( data ) 
                {
                    $(data).insertAfter("#todolist_first");
                    activate_editable();
                });
            }
        });          
        return false;
    });

    /* Load Calendar contents */
    var hash = unescape(self.document.location.hash.substring(1));
    if ( hash != '' )
    {
        load_calendar( hash );
    }
    else
    {
        load_calendar( document.today );
    }

    activate_editable();
});

function toggle_help()
{
    if ( ! document.help_loaded )
    {   
        // Load help on demand, no use dragging that huge help text along if it isnt used
        console.log("need to load");
        $.get("?/help/", function(ret)
        {
            $(".help #helptext").append(ret);
            $('.help #helptext').slideToggle('fast')
            document.help_loaded = true;
        });
    }
    else
    {
        $('.help #helptext').slideToggle('fast')
    }
}

/** click() function for then an item gets completed/deleted **/
function todo_complete(action, id) 
{
    $.ajax({  
        type: "POST",
        url: "?/todo/" + action,
        data: { 'id': id },
        success: function(data) {
            $("#todo_order_" + data).hide("blind");
            load_calendar( document.today  );
        }
    });
}

function activate_editable()
{
    $('.todo_edit').editable('?/todo/save', 
    {
        loadurl     : '?/todo/load',
        loadtype    : 'POST',
        type        : "autogrow",
        submit      : "Save",
        indicator   : '<img src="public/img/indicator.gif">',
        tooltip     : 'Click to edit.',
        onblur      : 'cancel',
        width       : 'auto',
        style       : "display: inline",
        autogrow    : {
           lineHeight : 16 /*,
           minHeight  : 100*/
        }
    });
}

function load_calendar( day ) 
{
    $.ajax({
        url: '?/calendar/hours/' + day,
        dataType: 'json',
        success: function(data) 
        {
            document.today=data['today'];
            document.tomorrow=data['tomorrow'];
            document.yesterday=data['yesterday'];
        
            self.document.location.hash = document.today;
            
            $("#calendar_date").text(data['date']);
            
            /* Remove any That might be there */
            $(".completed_todo").remove();
            
            /* Then reset them all again. Browser CPU is cheap :-) */
            for (var hour in data['items'])
            {
                for (var i in data['items'][hour])
                {
                    var task = data['items'][hour][i];
                    $(".calendar_hour#" + task.hour).append(task.content);
                    $("tr#hour_" + task.hour).css('display', '');
                }
            }
            activate_editable();
        }
    });
}

