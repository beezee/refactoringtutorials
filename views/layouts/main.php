<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo Yii::App()->name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="<?php echo Yii::App()->baseUrl; ?>/static/css/inspiritas.css" rel="stylesheet">
    <style>
	#content{
		min-height:350px;
	}
	#editor{
		min-height:300px;
		position: relative;
	}
    </style>
</head>

<body>

<!-- Navbar
  ================================================== -->
<div class="navbar navbar-static-top navbar-inverse">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <a class="brand" href="<?php
	echo Yii::App()->baseUrl; ?>"><?php echo Yii::App()->name; ?></a>

      <div class="nav-collapse collapse" id="main-menu">
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row-fluid">
        <div class="span3">
            <aside>
                <nav>
                    <?php $this->widget('zii.widgets.CMenu', array(
			'items' => array(
				array('label' => 'Extract Method',
				      'url' => array('refactoring/index',
						     'refactoringSlug' => 'extract-method'),
				      'active' => Yii::App()->request->getQuery('refactoringSlug')
						=== 'extract-method'),
				array('label' => 'Move Method',
				      'url' => array('refactoring/index',
						     'refactoringSlug' => 'move-method'),
				      'active' => Yii::App()->request->getQuery('refactoringSlug')
						=== 'move-method'),
			),
			'activeCssClass' => 'selected',
			'htmlOptions' => array('class' => 'nav'),
		    )); ?>
                </nav>
            </aside>
        </div>
        <div class="span9" id="content-wrapper">
            <div id="content">
		<?php echo $content; ?>
            </div>
        </div>
    </div>
</div><!-- /container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


  </body>
</html>