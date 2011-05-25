/* Author: Claus Beerta
    
*/

$(document).ready(function() 
{
	$( ".todo#sortable" ).sortable(
	{ 
	    handle: 'img.todo_move', 
	    opacity: 0.6,
        update : function () {
            $.post("/todo_sort", { todo_order: $('.todo#sortable').sortable("serialize") });      
        }
    });
    
	$( "#sortable" ).disableSelection();
	
    $('#todo_save').submit(function() {
        var task = $('#todo_task').attr('value');  
        $.ajax({  
            type: "POST",
            url: "/todo_save",
            data: "value=" + task,
            success: function(id){
                $('#todo_task').attr('value', '');
                $.post('/todo_load/formatted', { 'id' : id } , function ( data ) {
                    $(data).insertAfter("#todolist_first");
                    activate_editable();
                });
            }
        });          
        return false;
    });

    /* Load Calendar contents */
    load_calendar( document.today );

    activate_editable();
});

$('.todo_done').click(function() 
{
    var id = $(this).parent().attr('id');
    $.get("/todo_complete/" + id, function(data) {
        $("#todo_order_" + data).remove();
        load_calendar( document.today  );
    });
});

function activate_editable()
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
}

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




