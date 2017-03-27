<div class="container">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css" />


	<!-- Mobile Car Slider -->
                    <div class="mobile-vehicle-slider visible-xs visible-sm">
                        <?php if (!empty($vehicles)) { ?><?php foreach ($vehicles as $v) { ?>
	                        <?php $active = ($v->keyword == 'sedan') ? 'slick-current slick-active' : ''; ?>
	                        <img class="img img-responsive <?php echo $active;?>" src="<?php echo Yii::getAlias('@web'); ?>/img/<?php echo $v->photo; ?>" rel="<?php echo $v->keyword; ?>" alt="<?php echo $v->name; ?>">
                        <?php } ?><?php } ?>
                    </div>
					<div class="vehicle-select-container text-center visible-sm visible-xs">
		<a id="item-title-slick" class="link vehicle-select-btn" href="<?php echo $referralUrl; ?>" data-method="POST" data-params="{'vehicle': 'sedan'}" style="opacity: 1;">I Want a Sedan</a>
                    </div>



<div class="vehicle-picker-container not-animating hidden-xs hidden-sm">
                        <div id="vehicle-picker">
	                        <div id="showcase" class="noselect">
		                        <?php if(!empty($vehicles)){ ?>
		                            <?php foreach($vehicles as $v) { ?>
				                        <img class="cloud9-item" src="<?php echo Yii::getAlias('@web'); ?>/img/<?php echo $v->photo;?>" rel="<?php echo $v->keyword;?>" alt="<?php echo $v->name;?>">
                                    <?php } ?>
		                        <?php } ?>
						    </div>
                        </div>
                        <div class="vehicle-control-buttons hide-for-sm-only">
                            <div class="prev-btn">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </div>
                            <div class="next-btn">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
	<div class="vehicle-select-container text-center hidden-xs hidden-sm">
		<a id="item-title" class="link vehicle-select-btn" href="<?php echo $referralUrl ;?>" data-method="POST" data-params="{'vehicle': 'sedan'}" style="opacity: 1;">I Want a Sedan</a>
                    </div>
</div>
<div class="text-center container" style="margin-bottom: 15px;">
				<?php echo $content['description']; ?>
			</div>
