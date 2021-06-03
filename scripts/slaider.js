$(document).ready(function(){
    $('.slider').slick({
        arrow: true,//стрелки
        dots: true,//кнопки-точки
        slidesToShow: 1,//кол-во слайдов
        speed:1100,//скорость пролистывания
        autoplay:true,//авто проигрывание
        autoplaySpeed:3000,//скорость автопроигрывания
        pauseOnHover:true,//остановка проигрывания при наведении курсором на слайд
        pauseOnDotsHover:true//остановка проигрывания при наведении курсором на кнопки-точки
    });
});