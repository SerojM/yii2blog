$(document).ready(function () {
$('.confirm_article').one('click',function () {
  var id = $(this).data('id');


    $.ajax({
        url: "/back/admin/article/confirm-article",
        type: 'post',
        data: {id:id},
        success: function (data) {
            console.log(data);
            if (data.success){
                $("article[data-id='" + id + "']").remove();
            }else{
                console.log('Error in confirm!')
            }
        }

    });
})
;$('.delete_article').one('click',function () {
  var id = $(this).data('id');

if(confirm('Delete this article ?')){
    $.ajax({
        url: "/back/admin/article/delete-article",
        type: 'post',
        data: {id:id},
        success: function (data) {
            console.log(data);
            if (data.success){
                $("article[data-id='" + id + "']").remove();
            }else{
                console.log('Error in delete!')
            }
        }

    });
}
});

});