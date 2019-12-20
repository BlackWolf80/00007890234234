<div class="container">
    <div class="row">
        <div class="col-md-9 col-lg-9">

            <?php if (isset($blogBg) && !empty($blogBg)):?>
            <?php foreach ($blogBg as $blogB):?>
                <article class="blog-item">
                    <img class="pull-left img-responsive" style="width: 36%" src="/images/upload/<?=$blogB['img']?>">
                    <div class="text">
                        <h3><a href="#" data-toggle="modal" data-target="#myModal<?=$blogB['id']?>"><?=$blogB['title']?> </a></h3>
                        <?php
                        $string = strip_tags($blogB['post']);
                        $string = substr($string, 0, 500);
                        $string = rtrim($string, "!,.-");
                        $string = substr($string, 0, strrpos($string, ' '));
                        echo $string."… ";
                        ?>
                        <h4><a href="#" data-toggle="modal" data-target="#myModal<?=$blogB['id']?>">
                                <?php
                                if(\Yii::$app->language == 'ru-RU'){
                                    echo('Подробнее');
                                }else{
                                    echo('Learn more');
                                }?>... </a></h4>
                    </div>
                    <div class="clearfix"></div>
                </article>
                <hr />
                <!-- Модальное окно -->
                <div class="modal fade" id="myModal<?=$blogB['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header"><img class="pull-left img-responsive" style="width: 94%"  src="/images/upload/<?=$blogB['img']?>">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h2><?=$blogB['title']?></h2><br />
                                <?=$blogB['post']?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach;?>
            <?php endif;?>
        </div>

        <div class="col-md-3 col-lg-3">
            <?php if (isset($blogSm) && !empty($blogSm)):?>
            <?php foreach ($blogSm as $blogS):?>
                <div class="blog-item small-blog-item"><img class="img-responsive" src="upload/blog/<?=$blogS['img']?>">
                    <h4><a href="#"  data-toggle="modal" data-target="#myModal<?=$blogS['id']?>"><?=$blogS['title']?></a></h4>
                    <?php
                    $strings = strip_tags($blogS['post']);
                    $strings = substr($strings, 0, 200);
                    $strings = rtrim($strings, "!,.-");
                    $strings = substr($strings, 0, strrpos($strings, ' '));
                    echo $strings."… ";
                    ?>
                </div><br />
                <!-- Модальное окно -->
                <div class="modal fade" id="myModal<?=$blogS['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <img class="pull-left img-responsive" src="upload/blog/<?=$blogS['img']?>">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                            <div class="modal-body">
                                <h2><?=$blogS['title']?></h2><br />
                                <?=$blogS['post']?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <?php endif;?>
    </div>
</div>

