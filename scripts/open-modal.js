count = 0;
$('.open_modal_window').on('click', event => {
    moadlId = event.target.dataset.id;
    $('#' + moadlId).show()
})
$('.modal_window form img, .hiden_block').on('click', event => {
    moadlId = event.target.getAttribute('data')
    $('#' + moadlId).hide()
})

/*кнопки переключалка вытаскивание*/
$(document).on('click', '.check_price', event => {
    item = $(event.target)[0];
    parentBlock = $(item).parent()[0];
    price = $(parentBlock).next()[0];
    add = $(price).next()[0];
    /*работа переключалок, изменение стилей*/
    $(parentBlock).children().removeClass('check_on');
    $(item).addClass('check_on');
    /*изменение цены*/
    $(price).html($(item).data('price'));
    /*изменение данных в корзину*/
    $(add).data({ price: $(item).data('price'), size: $(item).data('size') });
})
$(document).on('click', '.submit', event => {
    count++;
    if(count>9 && count<99){
        $('.count').css({'font-size': '80%',left: '57%'})
        $('.count').html(count)
    }
    else if(count>99){
        $('.count').css({top: '-9.3vh','font-size': '85%',left: '3.3vw'})
        $('.count').html('. . .');
    }
    else
        $('.count').html(count)
    console.log($(event.currentTarget).data());
})