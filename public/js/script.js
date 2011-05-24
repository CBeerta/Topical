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
    
});

$('.todo_done').click(function() 
{
    var id = $(this).attr('id');
    $.get("/todo_complete/" + id);
    $("#" + id).fadeOut("slow");
});

