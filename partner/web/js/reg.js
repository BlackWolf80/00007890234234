//DOM/////////////////////////////////////////

$(document).ready(function(){

    var name = null,
        phone = null,
        type = null,
        typeText = null,
        address = null,
        size = 0,
        hold = 0,
        lat = 0,
        lng = 0,
        start_time = 0,
        end_time = 0,
        price = 0,
        currency = 'rub',
        seat_guarantee = 0,
        limit_heights = 3,
        around_the_clock = 0,
        wDays = [],
        chOptions = [],
        validVehicles =[];

    //yandex map init
    if (document.querySelector(".map")) {
        ymaps.ready(init);
    }

    //alert box
    $('#alert_close').click(function(){
        $( "#alert_box" ).fadeOut( "slow", function() {
        });
    });

//далее
    $('#fr-plus').click(function(e){
        e.preventDefault();
        console.log('ok');
        var i = 1;

        var  blocks = document.getElementsByClassName('reg-block');

        $.each(blocks,function(index,value){
            if(value.style.display == 'block'){
                if(index >= 0){
                    $('#fr-minus').css({ 'display': 'inline-block'});
                }
                console.log(index);
                if(index == 4){
                    // console.log(index);
                    $('#fr-plus').css({ 'display': 'none'});
                    // address = $('#address').value();
                    getWday();
                    getOptions();
                    getChekers();

                    console.log(name);
                    console.log(phone);
                    console.log(type);
                    console.log(size);
                    console.log(address);
                    console.log(start_time);
                    console.log(end_time);
                    console.log(seat_guarantee);
                    console.log(limit_heights);

                    if(name !=null && phone != null && type != 0  && size != 0 && address !=null && start_time != 0 && end_time !=0){

                        // getWday();
                       $('#submit').css({'display': 'inline-block'});
                    }else{
                        $('#submit').css({'display': 'none'});
                    }
                }

                value.style.display ='none';
                i = index + i;
                blocks[i].style.display ='block';


                return false;
            }
        });

    });

// назад
    $('#fr-minus').click(function(e){
        e.preventDefault();
        var i = 1;

        var  blocks = document.getElementsByClassName('reg-block');

        $.each(blocks,function(index,value){

            if(value.style.display == 'block'){
                if(index < 2){
                    $('#fr-minus').css({ 'display': 'none'});
                }

                if(index > 2){
                    // console.log(index);
                    $('#fr-plus').css({ 'display': 'inline-block'});
                }

                if(index !=3 ){
                    $('#submit').css({'display': 'none'});
                }

                value.style.display ='none';
                i = index - i;
                blocks[i].style.display ='block';
                return false;
            }
        });

    });

// submit
    $('#submit').click(function(e){
        e.preventDefault();

        if(name !=null && phone != null && type != 0  && size != 0 && address != null && lat != 0 && lng != 0){
            $('.sub-progress').css({'display': 'block'});
            // var file = $("#avatar").prop('files')[0];
            $.ajax({
                url: '/reg',
                data: {saving : {
                        "name":name,
                        "phone":phone,
                        "options":chOptions,
                        "type":type,
                        "size":size,
                        "busy": hold,
                        "address":address,
                        "lat": lat,
                        "lng":lng,
                        "start_time": start_time,
                        "end_time": end_time,
                        "w_days": wDays,
                        "price": price,
                        "currency": currency,
                        "seat_guarantee": seat_guarantee,
                        "limit_heights": limit_heights,
                        "around_the_clock": around_the_clock,
                        "valid_vehicles": validVehicles,


                    },
                    processData: false,
                    contentType: false,
                },
                type: 'POST',
                success: function(data){
                    if(data == 'exist'){
                        $('#alert_box').css({'display': 'block'});
                        $('.message').empty();
                        $('.message').append('Такой номер телефона уже зарегистрирован');
                    }

                }

            });
        }else{
            $('#alert_box').css({'display': 'block'});
        }
    });

// шаг первый
    document.body.querySelector('#type').addEventListener('change', event => {
    var opt = document.getElementById("type").options.selectedIndex;
    // console.log(opt);

            if(opt == 0){
                $(".type_parking_options").empty();
            }else{
                $(".type_parking_options").empty();
                $.ajax({
                    url: '/reg',
                    data: {change_options : {"opt":opt}},
                    type: 'POST',
                    success: function(data){
                        var arr = $.parseJSON(data);

                        $.each(arr,function(index,value){

                            $('.type_parking_options').append(
                                '<li><label><input type="checkbox" class="chk-opt" id="'+ index +'" /><span>'+value+'</span></label></li>'
                            );

                        });
                    }
                });
            }
    },
        false);

    $('#name').change('input', function() {
        name = this.value;
        if(name != ''){
            $('.label_name').css({'color':'#262626'});
        }else{
            $('.label_name').css({'color':'red'});
            name = null;
        }
        $('.name').empty();
        $('.name').append(name);
    });

    $('#phone').change('input', function() {
        phone = this.value;
        if(this.value != ''){
            $('.label_phone').css({'color':'#262626'});
        }else{
            $('.label_phone').css({'color':'red'});
            phone=null;
        }
        $('.phone').empty();
        $('.phone').append(phone);
    });


    $('#type').change('input', function() {
        type = this.selectedIndex;
        typeText = this.options[this.selectedIndex].text;
        if(this.value != ''){
            $('.label_type').css({'color':'#262626'});
        }else{
            $('.label_type').css({'color':'red'});
            type =null;
        }
        $('.type').empty();
        $('.type').append(typeText);
    });


// шаг второй
    document.body.querySelector('#size').addEventListener('change', event => {
            var opt = document.getElementById("size").options.selectedIndex;
            var i=1;

            if(opt == 0 || opt ==1 ){
                $("#hold").empty();
            }else{
                $("#hold").empty();
                    while (i<=opt){
                        $('#hold').append(
                            '<option value="'+i+'">'+i+'</option>'
                        );
                        i++;
                    }
            }

        },
        false);

    $('#size').change('input', function() {
        console.log(this.value);

        if(this.value!= 0){
            size = this.value;
            console.log(size);
            $('.label_size').css({'color':'#262626'});
            $('.size').empty();
            $('.size').append(size);
            hold = 1;

            $('.hold').empty();
            $('.hold').append(hold);
            $('.label_hold').css({'color':'#262626'});
        }else{
            $('.label_size').css({'color':'red'});
            $('.label_hold').css({'color':'red'});
            $('.hold').empty();
            $('.size').empty();
            size = 0;
            hold=0;
        }

    });

    $('#hold').change('input', function() {

        hold = this.value;
        if(this.value != ''){
            $('.label_hold').css({'color':'#262626'});
        }else{
            $('.label_hold').css({'color':'red'});
            hold=0;
        }
        $('.hold').empty();
        $('.hold').append(hold);
    });

//шаг третий
    $('#address').change('input', function() {

        address = this.value;
        if(this.value != ''){
            $('.label_address').css({'color':'#262626'});
        }else{
            $('.label_address').css({'color':'red'});
            address =null;
        }
        $('.address').empty();
        $('.address').append(address);
    });

//шаг четвертый
    $('#start_time').change('input', function() {
        start_time = this.options[this.selectedIndex].text;
        if(end_time <= start_time){
            $('#alert_box').css({'display': 'block'});
            $('.message').empty();
            $('.message').append('Время начала рабочего дня не может быть меньше или равно времени конца рабочего дня');
        }else{
            $('#alert_box').css({'display': 'none'});
            $('.message').empty();
        }

        setTimeWork(start_time,end_time);
    });

    $('#end_time').change('input', function() {
        end_time = this.options[this.selectedIndex].text;


        if(end_time <= start_time){
            $('#alert_box').css({'display': 'block'});
            $('.message').empty();
            $('.message').append('Время начала рабочего дня не может быть меньше или равно времени конца рабочего дня');
        }else{
            $('#alert_box').css({'display': 'none'});
            $('.message').empty();
        }
        setTimeWork(start_time,end_time);
    });

    $('#around_the_clock').change(function(){
        if(this.checked == true)
        {
            $('#start_time').css({'display': 'none'});
            $('#end_time').css({'display': 'none'});
                start_time = '00:00';
                end_time = '23:59';
            setTimeWork(start_time,end_time);

        }else{
            start_time = 0;
            end_time = 0;
            setTimeWork(0,0);
            $('#start_time').css({'display': 'block'});
            $('#end_time').css({'display': 'block'});
        }
    });

//шаг пятый
    var filesExt = ['jpeg','jpg', 'gif', 'png']; // массив расширений
    $('input[type=file]').change(function(){
        var parts = $(this).val().split('.');
        if(filesExt.join().search(parts[parts.length - 1]) != -1){
            $('#alert_box').css({'display': 'none'});
            $('.message').empty();
        } else {
            $('#alert_box').css({'display': 'block'});
            $('.message').empty();
            $('.message').append('Файл должен иметь расширение jpeg, jpg или png');
        }
    });

    $('#price').change('input', function() {
        price = this.options[this.selectedIndex].text;

        if(this.options[this.selectedIndex].index != 0){
            $('.label_price').css({'color':'#262626'});
            $('.price').css({'color':'#262626'});
            $('.price').empty();
            $('.price').append(price);
        }else{
            $('.price').empty();
            $('.price').css({'color':'red'});
            price =0;
        }
        setTimeWork(start_time,end_time);
    });


    $('#currency').change('input', function() {
        price = this.options[this.selectedIndex].text;

        if(this.options[this.selectedIndex].index != 0){
            $('.currency_price').css({'color':'#262626'});
            $('.currency').css({'color':'#262626'});
            $('.currency').empty();
            $('.currency').append(price);
        }else{
            $('.currency').empty();
            $('.currency').css({'color':'red'});
            currency =0;
        }
        setTimeWork(start_time,end_time);
    });



//время
    function setTimeWork(start,end) {
        if(start != 0 && end != 0){
            $('.label_time').css({'color':'#262626'});
            $('.start_time').empty();
            $('.end_time').empty();
            $('.start_time').append(start);
            $('.end_time').append(end);
        }else{
            $('.start_time').empty();
            $('.end_time').empty();
            $('.label_time').css({'color':'red'});
        }

    }

//обработка чекеров дней недели
    function getWday(){
        var w_days = $('.w_day');
        var id, ind = 0;
        wDays.length = 0;
        w_days.each(function(i, obj) {
            if(obj.checked ==true){
                id = obj.id.replace('d', '');
                wDays[ind] = id;
                ind++;
            }
        });
        if(wDays.length != 0){
            $('.label_wdays').css({'color':'#262626'});
            $('.wdays').empty();

            wDays.forEach(function(item, i, arr) {
                $('.wdays').append('['+item+']');
            });
        }else{
            $('.wdays').empty();
            $('.label_wdays').css({'color':'red'});
            wDays.length = 0;
        }
    }

//обработка чекеров опций
    function getOptions(){
        var options = $('.chk-opt');
        var id, ind = 0;
        chOptions.length = 0;
        $('.options').empty();
        options.each(function(i, obj) {
            console.log($(this).next().text());
            if(obj.checked ==true){
                id = obj.id.replace('d', '');
                chOptions[ind] = id;
                $('.options').append(' ['+$(this).next().text()+'] ');
                ind++;
            }
        });
        console.log(chOptions);
    }

//обработка
    function getChekers(){
        var chkBox = document.getElementById('seat_guarantee');
        if (chkBox.checked){seat_guarantee = 1;}
        limit_heights = $("#limit_heights").val();


        var options = $('.valid_vehicles');
        var id, ind = 0;
        validVehicles.length = 0;
        $('.ts').empty();
        options.each(function(i, obj) {
            // console.log($(this).next().text());
            if(obj.checked ==true){
                id = obj.id.replace('d', '');
                validVehicles[ind] = $(this).next().text();
                $('.ts').append(' ['+$(this).next().text()+']');
                ind++;
            }
        });
        // console.log(chOptions);

    }

//yandex maps
    function init() {

        var slat = 45.039758;
        var slng = 38.980007;

        $("#map").empty();

        var myPlacemark,
            myMap = new ymaps.Map('map', {
                center: [slat, slng],
                zoom: 13
            }, {
                searchControlProvider: 'yandex#search'
            });

        // поставим курсор "стрелка" над картой
        myMap.cursors.push('arrow');

        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            // console.log('click');
            var coords = e.get('coords');
            // console.log(coords['0']);
        // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                // myPlacemark.events.add('dragend', function () {
                    // getAddress(myPlacemark.geometry.getCoordinates());
                // });
                // getAddress(myPlacemark.geometry.getCoordinates());
            }
            // getAddress(coords);
            getAddressGoo(coords);

            // document.getElementById('lat').value =coords['0'].toFixed(8);
            // document.getElementById('lng').value =coords['1'].toFixed(8);
            lat = coords['0'].toFixed(8);
            lng = coords['1'].toFixed(8);



            $('.coords').empty();
            $('.coords').append('['+lat+' - '+lng+']');
            $('.label_coords').css({'color':'#262626'});
            $('.label_coords').empty();
            $('.label_coords').append('Координаты вашей парковки');
        });


// Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        // Определяем адрес по координатам (обратное геокодирование google).
        function getAddressGoo(coords){
            // console.log(coords);
            myPlacemark.properties.set('iconCaption', 'поиск...');
            var lat = coords['0'];
            var lng = coords['1'];
            $.ajax({
                url: '/geo',
                data: {lat : lat,lng : lng},
                type: 'GET',
                success: function(data){
                    var arr = $.parseJSON(data);
                    address = arr.results[0]['formatted_address'];
                    address = address.substr(0, address.lastIndexOf(","));
                    // console.log(address);

                    $('.label_address').css({'color':'#262626'});
                    $('.address').empty();
                    $('.address').append(address);

                    document.getElementById('address').value = address;


                        myPlacemark.properties.set('iconCaption', address);
                }
            });

        }

// Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                document.getElementById('address').value = firstGeoObject.getAddressLine();
                address = firstGeoObject.getAddressLine();
                $('.label_address').css({'color':'#262626'});
                $('.address').empty();
                $('.address').append(address);
                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }
    }
});

//DOM/////////////////////////////////////////