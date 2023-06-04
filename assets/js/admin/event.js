let selectType        = $('#Event_type');
let url               = selectType.attr('data-get-template-url');
let val               = selectType.val();
// let editorComposition = document.querySelector("trix-editor").editor.composition;
let editorComposition = CKEDITOR.instances['Event_content'];
let title             = $('#Event_title');
let theme             = $('#Event_theme');
$('#Event_duration').addClass('row');


// setTypeData(val, true);
selectType.on('change', function () {
    let val = $(this).val();
    setTypeData(val, false);
})

switchRrule($('#Event_has_rrule').prop('checked'));
$('#Event_has_rrule').on('change', function () {
    switchRrule($(this).prop('checked'));
})


function setTypeData(typeValue, isFirst) {
    $.ajax({
            url: url,
            type: 'POST',
            data: {
                id: typeValue,
            },
        })
        .done(function (data) {
            editorComposition.setData(data.template);
            // editorComposition.replaceHTML(data.template);
            title.val(data.title);
            theme.val(data.title);
            $('.ea-vich-image').find('img').remove();
            let src = '/images/event/default.webp';
            if(null !== data.image) {
                src = `/uploads/images/event-type/${data.image}`;
            }
            $('.ea-vich-image').prepend(`<img src="${src}">`);
        })
}

function switchRrule(hasRrule) {
    if(hasRrule) {
        $('.no-rrule-date').addClass('d-none');
        $('.rrule-date').removeClass('d-none');
        return false;
    }
    $('.no-rrule-date').removeClass('d-none');
    $('.rrule-date').addClass('d-none');
}
