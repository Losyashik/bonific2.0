count = 0;
function ajaxBasket(data) {
    $.ajax({
        url: 'scripts/basket.php',
        method: 'post',
        data: { products: data },
        success: function (text) {
            $('.products').html(text);
        }
    })
}
function ajaxPrev(id) {
    $.ajax({
        url: 'scripts/product.php',
        method: 'post',
        data: { product: id },
        success: function (text) {
            $('.product').html(text);
            $('#product').show();
        }
    })
}
if (typeof dataBasket === 'undefined' && localStorage.getItem('basket') === null) {
    var dataBasket = {};
    localStorage.counter = 0;
} else if (localStorage.getItem('basket') !== null) {
    var dataBasket = JSON.parse(localStorage.getItem('basket'));
    console.log(dataBasket);
}

function adimin_on() {
    if (event.shiftKey && event.ctrlKey) {
        event.preventDefault()
        window.open('admin.php');
    }
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
    let item = $(event.target)[0];
    let parentBlock = $(item).parent()[0];
    let price = $(parentBlock).next()[0];
    if ($(event.currentTarget).hasClass('prev')) {
        add = $('.submit.prev')[0];
    }
    else {
        add = $(price).next()[0];
    }
    /*работа переключалок, изменение стилей*/
    $(parentBlock).children().removeClass('check_on');
    $(item).addClass('check_on');
    /*изменение цены*/
    $(price).html($(item).data('price') + " ₽");
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
    else {
        $('.count').attr('style', '');
        $('.count').html(localStorage.counter)
    }

}
function finalPrice(dataBasket) {
    let summ = 0;
    for (let key in dataBasket) {
        summ += dataBasket[key]['count'] * dataBasket[key]['price'];
    }
    return summ;
}
function productPrice(dataBasket, id) {
    let summ = dataBasket[id]['count'] * dataBasket[id]['price'];
    return summ;
}
$(document).on('click', '.submit', event => {
    counter('add');
    let productId = $(event.currentTarget).data('id')
    let price = $(event.currentTarget).data('price')
    if (typeof $(event.currentTarget).data('size') !== 'undefined') {
        let size = $(event.currentTarget).data('size')
        if (productId + '_' + size in dataBasket) {
            for (let key in dataBasket) {
                if (key == productId + '_' + size && dataBasket[key]['size'] == size) {
                    dataBasket[key]['count']++;
                    $('.price[data-basket-id="' + key + '"]').html(productPrice(dataBasket, key));
                    break;
                }
            }
        }
        else {
            dataBasket[productId + '_' + size] = { id: productId, count: 1, size: size, price: price };
        }
    }
    else {
        if (productId in dataBasket) {
            for (let key in dataBasket) {
                if (key == productId) {
                    dataBasket[key]['count']++;
                    $('.price[data-basket-id="' + key + '"]').html(productPrice(dataBasket, key));
                    break;
                }
            }
        }
        else {
            dataBasket[productId] = { id: productId, count: 1, price: price };
        }
    }
    localStorage.setItem('basket', JSON.stringify(dataBasket));
    $('.output_final_prise').html(finalPrice(dataBasket) + " ₽");
    ajaxBasket(dataBasket);
})
$(document).on('click', '.counter__minus', event => {
    let id = event.currentTarget.dataset.basketId;
    dataBasket[id]['count']--;
    counter('remove');

    if (dataBasket[id]['count'] == 0) {
        delete dataBasket[id];
        localStorage.setItem('basket', JSON.stringify(dataBasket));
        ajaxBasket(dataBasket);
    }
    else {
        $('.price[data-basket-id="' + id + '"]').html(productPrice(dataBasket, id) + " ₽");
        $('.counter__count[data-basket-id="' + id + '"]').html(dataBasket[id]['count'])
        localStorage.setItem('basket', JSON.stringify(dataBasket));
    }
    $('.output_final_prise').html(finalPrice(dataBasket) + " ₽");
})
$(document).on('click', '.counter__plus', event => {
    let id = event.currentTarget.dataset.basketId;
    dataBasket[id]['count']++;
    counter('add');
    $('.price[data-basket-id="' + id + '"]').html(productPrice(dataBasket, id) + " ₽");
    $('.output_final_prise').html(finalPrice(dataBasket) + " ₽");
    $('.counter__count[data-basket-id="' + id + '"]').html(dataBasket[id]['count'])
    localStorage.setItem('basket', JSON.stringify(dataBasket));
})
$(document).on('click', '.basket_delete', event => {
    let id = event.currentTarget.dataset.basketId;
    localStorage.counter -= dataBasket[id]['count'];
    delete dataBasket[id];
    counter();
    localStorage.setItem('basket', JSON.stringify(dataBasket));
    ajaxBasket(dataBasket);
    $('.output_final_prise').html(finalPrice(dataBasket) + " ₽");
})
$('.next').click(event => {
    event.preventDefault();
    $(event.target).parent().hide();
    $(event.target).parent().next().show();
})
$('#back').click(event => {
    event.preventDefault();
    $(event.target).parent().parent().hide();
    $(event.target).parent().parent().prev().show();
})
$(document).on('click', '.con_item', event => {
    if ($('.submit').has(event.target).length === 0 && $('.check').has(event.target).length === 0) {
        id = event.currentTarget.dataset.id;
        ajaxPrev(id);
    }
});
window.onload = () => {
    updateContent(1, 'scripts/ajax.php');
    ajaxBasket(dataBasket);
    $('.output_final_prise').html(finalPrice(dataBasket) + " ₽");
    counter();
}

