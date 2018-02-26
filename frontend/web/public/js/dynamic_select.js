$(document).ready(function () {
    $('#category_id').on('change', function () {
        var categoryId = $(this).val();
        $('#subcat_id').html('');

        $.ajax({
            url: "/article/subcategory",
            type: 'post',
            data: {category_id:categoryId},
            success: function (data) {
                if (data.success){
                    $('.second_select').show();
                    $('#subcat_id').html(data['option']);

               console.log(data['option']);

                }else{
                    $('.second_select').hide();

                }
            }

        });
    })
    });