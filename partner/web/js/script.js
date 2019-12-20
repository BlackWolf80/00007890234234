$(document).ready(function(){
    var idUrl = document.location.pathname;
    function trim( str ) {
        return str.replace(/^\s+|\s+$/g, "");
    }


    // подключаем внешние скрипты
    function include(url) {
        $('head').append('<script src="'+url+'"></script>');
    }

    include('/js/materialize.min.js');

    if(trim(idUrl) == '/reg'){
        include('/js/reg.js');
    }


    $('.timepicker').timepicker({
        twelvehour: false, // Use AM/PM or 24-hour format
    });

    // if (document.querySelector(".map")) {
    //     ymaps.ready(init);
    // }


    $('.bt').click(function(e){
        e.preventDefault();
        var btn = this.getAttribute("id");
        // console.log(btn);
        $.ajax({
            url: '/parking',
            data: {btn : btn},
            type: 'POST',
        });
    });

    $('#set-price').click(function(e){
        e.preventDefault();
        var price = document.getElementById('price').value;
        if(price < 100) price = 100;
        if(price > 9999) price = 9999;
        $.ajax({
            url: '/change-price',
            data: {price : price},
            type: 'POST',
            success: function(data){
                // console.log(data);

                document.getElementById('price').value ="";
                $("#price-label").empty();
                $("#price-label").append('<h5>'+ data +' ₽</h5>');

            }
        });

    });



    $('#set-pin').click(function(e){
        e.preventDefault();
        var secret_key = document.getElementById('pin').value;

        $.ajax({
            url: '/pin',
            data: {secret_key : secret_key},
            type: 'POST',
            success: function(data){

                document.getElementById('pin').value ="";
                $("#pin-label").empty();
                if(data == '{"secret_key":"wrong"}'){
                    $("#pin-label").append('<h6 class="red"> Пин-код непринят</h6>');
                }else{
                    $("#pin-label").append('<h6 class="green"> Заказ закрыт</h6>');
                }




            }
        });

    });







});

// function init() {
//
//     var lat = 45.039758;
//     var lng = 38.980007;
//
//     $("#map").empty();
//
//     var myPlacemark,
//         myMap = new ymaps.Map('map', {
//             center: [lat, lng],
//             zoom: 13
//         }, {
//             searchControlProvider: 'yandex#search'
//         });
//
//     // поставим курсор "стрелка" над картой
//     myMap.cursors.push('arrow');
//
//     // Слушаем клик на карте.
//     myMap.events.add('click', function (e) {
//         var coords = e.get('coords');
//         // console.log(coords);
// // Если метка уже создана – просто передвигаем ее.
//         if (myPlacemark) {
//             myPlacemark.geometry.setCoordinates(coords);
//         }
//         // Если нет – создаем.
//         else {
//             myPlacemark = createPlacemark(coords);
//             myMap.geoObjects.add(myPlacemark);
//             // Слушаем событие окончания перетаскивания на метке.
//             myPlacemark.events.add('dragend', function () {
//                 getAddress(myPlacemark.geometry.getCoordinates());
//             });
//         }
//         // getAddress(coords);
//         console.log('ok');
//         getAddressGoo(coords);
//
//         document.getElementById('parkings-lat').value =coords['0'].toFixed(8);
//         document.getElementById('parkings-lng').value =coords['1'].toFixed(8);
//     });
//
//
// // Создание метки.
//     function createPlacemark(coords) {
//         return new ymaps.Placemark(coords, {
//             iconCaption: 'поиск...'
//         }, {
//             preset: 'islands#violetDotIconWithCaption',
//             draggable: true
//         });
//     }
//
// // Определяем адрес по координатам (обратное геокодирование google).
//     function getAddressGoo(coords){
//
//        var lat = coords['0'];
//        var lng = coord['1'];
//         $.ajax({
//             url: '/geo',
//             data: {lat : lat,lng : lng},
//             type: 'POST',
//             success: function(data){
//
//                 console.log(data);
//             }
//         });
//
//     }
//
//
// // Определяем адрес по координатам (обратное геокодирование яндекс).
//     function getAddress(coords) {
//         myPlacemark.properties.set('iconCaption', 'поиск...');
//         ymaps.geocode(coords).then(function (res) {
//             var firstGeoObject = res.geoObjects.get(0);
//             document.getElementById('parkings-address').value = firstGeoObject.getAddressLine();
//             myPlacemark.properties
//                 .set({
//                     // Формируем строку с данными об объекте.
//                     iconCaption: [
//                         // Название населенного пункта или вышестоящее административно-территориальное образование.
//                         firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
//                         // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
//                         firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
//                     ].filter(Boolean).join(', '),
//                     // В качестве контента балуна задаем строку с адресом объекта.
//                     balloonContent: firstGeoObject.getAddressLine()
//                 });
//         });
//     }
// }