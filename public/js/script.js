/* Author: 

*/

$(document).ready(function() 
{
    $('.todo_edit').editable('/todo_save', 
    {
        loadurl     : '/todo_load',
        loadtype    : 'POST',
        type        : 'textarea',
        submit      : "Save",        
        indicator   : '<img src="img/indicator.gif">',
        tooltip     : 'Click to edit...',
        rows        : 5,
        cols        : 40,
        style       : "inherit"
    });
    
    
});

$('.todo_done').click(function() {
    var id = $(this).attr('id');
    $.get("/todo_complete/" + id);
    $("#" + id).fadeOut("slow");
});
