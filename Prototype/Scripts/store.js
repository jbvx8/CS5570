function showDiv(id){
    document.getElementById(id).style.display="block";
}

var confirm = document.getElementbyId('editForm');
confirm.addEventListener('submit', function() {
    return confirm("Are you sure you want to make these changes to the database?");
}, false);



$(document).ready(function(){
    $('.btnRemove').click(function(){
        var clickBtnValue = $(this).val();
        var url = '../prototype/cart_remove.php'
        //data = {'action': clickBtnValue};
        var form = $(this).parent();
        var data = form.serialize();
        data += "&action=remove";
        console.log(data);
        $.post(url, data, function(response) {
            //alert("item removed from cart");
        });
    });
});



