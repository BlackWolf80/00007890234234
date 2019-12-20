
<param name="lang" value="<?=\Yii::$app->language?>">
<div id="flash"></div>
<?php if(\Yii::$app->language == 'ru-RU'):?>
<form id="contact-form" >
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    Имя</label>
                <input type="text" class="form-control" id="name" placeholder="Введите имя" required="required" />
            </div>
            <div class="form-group">
                <label for="email">
                    E-mail</label>
                <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                    <input type="email" class="form-control" id="email" placeholder="Введите  e-mail" required="required" /></div>
            </div>
            <div class="form-group">
                <label for="subject">
                    Тема</label>
                <select id="subject" name="subject" class="form-control" required="required">
                    <option value="service" selected="">Общее обслуживание клиентов</option>
                    <option value="suggestions">Предложения</option>
                    <option value="product">Поддержка продукта</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    Сообщение</label>
                <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                          placeholder="Введите текст сообщения"></textarea>
            </div>
        </div>
        <div class="col-md-12">

            <a href="#" class="cont" ><button  class="btn btn-primary pull-right" >
                Отправить сообщение</button> </a>

        </div>
    </div>
</form>
<?php else:?>
    <form id="contact-form" >
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">
                        Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                </div>
                <div class="form-group">
                    <label for="email">
                        Email Address</label>
                    <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
                </div>
                <div class="form-group">
                    <label for="subject">
                        Subject</label>
                    <select id="subject" name="subject" class="form-control" required="required">
                        <option value="service" selected="">General Customer Service</option>
                        <option value="suggestions">Suggestions</option>
                        <option value="product">Product Support</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">
                        Message</label>
                    <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                              placeholder="Message"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <!--<button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                    Send Message</button>-->
                <a href="#" class="cont" ><button  class="btn btn-primary pull-right" >
                        Send Message</button> </a>

            </div>
        </div>
    </form>
<?php endif;?>
