$(document).ready(function() {
    $('#example').DataTable({
        "order": [
            [0, 'desc']
        ]
    });
});
$('#button').click(function() {
    $("input[type='file']").trigger('click');
});
$("input[type='file']").change(function() {
    $('#val').text(this.value.replace(/C:\\fakepath\\/i, ''));
})
