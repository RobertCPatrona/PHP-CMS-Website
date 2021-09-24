// Summernote text editor
$(document).ready(function () {
    $('#summernote').summernote({
        height: 200
    });
});

// For selecting or Deselecting all boxes in admin posts
$(document).ready(function () {
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {

            $('.checkBoxes').each(function () {
                this.checked = true;
            })

        } else {

            $('.checkBoxes').each(function () {
                this.checked = false;
            })

        }
    })
})
