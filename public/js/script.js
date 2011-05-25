/* Author: 

*/

$(document).ready(function() 
{
    $('.todo_edit').editable('/todo_save', 
    {
        loadurl     : '/todo_load',
        loadtype    : 'POST',
        type        : "autogrow",
        submit      : "Save",
        indicator   : '<img src="img/indicator.gif">',
        tooltip     : 'Click to edit...',
        onblur      : 'ignore',
        width       : 'auto',
        style       : "display: inline",
        autogrow    : {
           lineHeight : 20,
           minHeight  : 100
        }
    });
    
	$( ".todo#sortable" ).sortable(
	{ 
	    handle: 'img.todo_move', 
	    opacity: 0.6,
        update : function () {
            $.post("/todo_sort", { todo_order: $('.todo#sortable').sortable("serialize") });      
        }
    });
    
	$( "#sortable" ).disableSelection();

    /* Load Calendar contents */
    load_calendar( document.today );
    
});

$('.todo_done').click(function() 
{
    var id = $(this).attr('id');
    $.get("/todo_complete/" + id);
    //$("#todo_order_" + id).slideUp("fast");
    $("#todo_order_" + id).remove();
    load_calendar( document.today  );
});

function load_calendar( day ) 
{
    $.ajax({
        url: '/calendar_hours/' + day,
        dataType: 'json',
        success: function(data) {
            document.today=data['today'];
            document.tomorrow=data['tomorrow'];
            document.yesterday=data['yesterday'];
        
            //unescape(self.document.location.hash.substring(1))
            self.document.location.hash = day;
            
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
                    //$(".completed_todo").slideDown("fast");
                }
            }
        
        }
    });
}
