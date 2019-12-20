
        $('.cont').click(function(e){
            e.preventDefault();
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var subject = document.getElementById("subject").value;
            var message = document.getElementById("message").value;
            var lang = document.getElementsByName('lang')['0'].value;
            var messageError = 'Please fill in all fields!';
            var messageSuccess = 'Your request is accepted!';

            console.log(lang);

            if (lang == 'ru-RU'){
                messageError = 'Пожалуйста заполните все поля';
                messageSuccess = 'Ваш запрос принят!';
            }

            if(typeof name == "" || email == "" || subject == "" || message == ""){
                $("#flash").empty();
                $('#flash').append('<div class="alert alert-danger" role="alert">\n' + messageError +
                    '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '            <span aria-hidden="true">&times;</span>\n' +
                    '        </button>\n' +
                    '        </div>');
                return 0;
            }


            $.ajax({
                url: '/message',
                data: {name: name, email: email, subject: subject, message: message},
                type: 'POST',
                success: function(data){
                    var arr = $.parseJSON(data);
                   if(arr==1){
                       $('#name').val('');
                       $('#email').val('');
                       $('#subject').val('');
                       $('#message').val('');
                       $("#flash").empty();
                       $('#flash').append(' <div class="alert alert-success" role="alert">\n' + messageSuccess +
                           '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                           '            <span aria-hidden="true">&times;</span>\n' +
                           '        </button>\n' +
                           '        </div>');
                   }
                },

            });
        });
