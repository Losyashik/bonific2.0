function updateContent(type, url) {
    blockContent = $(".conteiner")
    $.ajax({
        url: url,
        method: 'post',
        data: { type: type },
        success: function(text) {
            blockContent.html(text)
        }
    })
}