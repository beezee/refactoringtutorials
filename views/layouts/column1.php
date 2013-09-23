<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<section>
	<header>
		<h3><?php echo $this->pageTitle; ?></h3>
	</header>
	<div class="row-fluid">
		<?php echo $content; ?>
	</div>
</section>
<?php $this->endContent(); ?>