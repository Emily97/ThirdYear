$(document).ready(function(){
    $('#btn-submit').on('click', function(){
        var form = $(this).closest('form').get(0);  $('div').get(0)
        var formData = $(form).serializeArray();
        var data = {};
        formData.map(function(x){
            data[x.name] = x.value;
        });
        var x = $.ajax(
            'api/books',
            {
                data: JSON.stringify(data),
                method: 'POST',
                success: function (response) {
                    if (response.status === 200) {
                        
                    } 
                    else if (response.status === 422) {
                        
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            }
        );
    });
});
