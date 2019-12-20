<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-address-card"></i>
        <span class="badge badge-warning navbar-badge"><?=count($parkings)?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"><?=count($parkings)?> заявок на активацию</span>
        <div style="font-size: 11px;padding-left: 10px;">
        <?php if(!empty($parkings)):?>
                <?php foreach ($parkings as $parking):?>
                <i class="fas fa-envelope mr-2"></i> <?=$parking->address?>
                <div class="dropdown-divider"></div>
                <?php endforeach;?>
        <?php endif;?>
    </div>
        <?=\yii\helpers\Html::a('Посмотреть все заявки','/parkings/activations',['class'=>'dropdown-item dropdown-footer'])?>
    </div>
</li>