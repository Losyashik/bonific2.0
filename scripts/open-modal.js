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
        $('.count').attr('style','');
        $('.count').html(localStorage.counter)

}
function finalPrice(dataBasket){
    let summ = 0;
    for(let key in dataBasket){
        summ+=dataBasket[key]['count']*dataBasket[key]['price'];
    }
    return summ;
}
function productPrice(dataBasket,id){
    let summ = dataBasket[id]['count'] * dataBasket[id]['price'];
    return summ;
}
$(document).on('click', '.submit', event => {
    counter('add');
    productId = $(event.currentTarget).data('id')
    price  = $(event.currentTarget).data('price')
    if (typeof $(event.currentTarget).data('size') !== 'undefined') {
        size = $(event.currentTarget).data('size')
        if (productId + '_' + size in dataBasket) {
            for (let key in dataBasket) {
                if (key == productId + '_' + size && dataBasket[key]['size'] == size) {
                    dataBasket[key]['count']++;
                    $('.price[data-basket-id="'+key+'"]').html(productPrice(dataBasket,key));
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
                    $('.price[data-basket-id="'+key+'"]').html(productPrice(dataBasket,key));
                    break;
                }
            }
        }
        else {
            dataBasket[productId] = { id: productId, count: 1, price: price};
        }
    }
    localStorage.setItem('basket',JSON.stringify(dataBasket));
    console.log(finalPrice(dataBasket));
    $('.output_final_prise').html(finalPrice(dataBasket)+" ₽");
    ajaxBasket(dataBasket,'scripts/basket.php');
})
$(document).on('click', '.counter__minus', event=>{
    id = event.currentTarget.dataset.basketId;
    dataBasket[id]['count']--;
    counter('remove');
    
    if(dataBasket[id]['count']==0){
        delete dataBasket[id];
        localStorage.setItem('basket',JSON.stringify(dataBasket));
        ajaxBasket(dataBasket,'scripts/basket.php');
    }
    else{
        $('.price[data-basket-id="'+id+'"]').html(productPrice(dataBasket,id));
        $('.counter__count[data-basket-id="'+id+'"]').html(dataBasket[id]['count'])
        localStorage.setItem('basket',JSON.stringify(dataBasket));
    }
    $('.output_final_prise').html(finalPrice(dataBasket)+" ₽");
})
$(document).on('click', '.counter__plus', event=>{
    id = event.currentTarget.dataset.basketId;
    dataBasket[id]['count']++;
    counter('add');
    $('.price[data-basket-id="'+id+'"]').html(productPrice(dataBasket,id));
    $('.output_final_prise').html(finalPrice(dataBasket)+" ₽");
    $('.counter__count[data-basket-id="'+id+'"]').html(dataBasket[id]['count'])
    localStorage.setItem('basket',JSON.stringify(dataBasket));
})