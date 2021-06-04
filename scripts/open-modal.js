count = 0;
function ajaxBasket(data, url) {
    blockContent = $(".conteiner")
    $.ajax({
        url: url,
        method: 'post',
        data: {products:data},
        success: function (text) {
            $('.products').html(text);
        }
    })
}
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
function counter(action) {
    if (action == 'add')
        localStorage.counter++;
    else if (action == 'remove')
        localStorage.counter--;
    if (localStorage.counter > 9 && localStorage.counter < 99) {
        $('.count').css({ 'font-size': '80%', left: '57%' })
        $('.count').html(localStorage.counter)
    }
    else if (localStorage.counter > 99) {
        $('.count').css({ top: '-9.3vh', 'font-size': '85%', left: '3.3vw' })
        $('.count').html('. . .');
    }
    else
        $('.count').html(localStorage.counter)

}
$(document).on('click', '.submit', event => {
    counter('add');
    productId = $(event.currentTarget).data('id')
    if (typeof $(event.currentTarget).data('size') !== 'undefined') {
        size = $(event.currentTarget).data('size')
        if (productId + '_' + size in dataBasket) {
            for (let key in dataBasket) {
                productData = dataBasket[key];
                if (key == productId + '_' + size && productData['size'] == size) {
                    productData['count']++;
                    dataBasket[key] = productData;
                    break;
                }
            }
        }
        else {
            dataBasket[productId + '_' + size] = { id: productId, count: 1, size: size };
        }
    }
    else {
        dataBasket[productId] = { id: productId, count: 1 };
        if (productId in dataBasket) {
            for (let key in dataBasket) {
                productData = dataBasket[key];
                if (key == productId) {
                    productData['count']++;
                    dataBasket[key] = productData;
                    break;
                }
            }
        }
        else {
            dataBasket[productId] = { id: productId, count: 1 };
        }
    }
    localStorage.setItem('basket',JSON.stringify(dataBasket));
    ajaxBasket(dataBasket,'scripts/basket.php');
})