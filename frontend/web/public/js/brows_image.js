$(document).ready(function () {
    function readURL(input) {

        if (input.files[0] == undefined) {
            $('#brows_image').hide();
            $('#img_inp').val(null);
            $('.hidden_val').val(null);
            $('#delete_img').hide();
        }
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#brows_image').show()
                    .attr('src', e.target.result)
                    .width(194)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#img_inp").on('click', function () {
        $("#img_inp").change(function () {
            $('#delete_img').show();
            readURL(this);
        });
    });

    $('#delete_img').on('click', function () {
        $('#brows_image').hide();
        $('#img_inp').val(null);
        $('.hidden_val').val(null);
        $('#delete_img').hide();
    })
});