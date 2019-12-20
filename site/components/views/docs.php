

<div id="modal" class="row">
    <div class="col-xs-12 col-md-12">
            <?php foreach ($docs as $doc):?>
                <a href="#" style="font-size: 12px" data-toggle="modal" data-target="#myModal<?=$doc['id']?>d"><?=$doc['title']?></a>
                <?php if($doc['id']== 2) echo '<br>'?>
                <div class="modal fade" id="myModal<?=$doc['id']?>d" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2><?=$doc['title']?></h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </div>
                            <div class="modal-body">
                                <?=$doc['content']?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
    </div>
</div>