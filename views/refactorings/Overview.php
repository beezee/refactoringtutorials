<?php $this->pageTitle = $this->widget->title.' - Overview';

$this->renderPartial($this->widget->stepView);

echo CHtml::link('Get started with this refactoring',
        array('refactoring/step',
              'refactoringSlug' => Yii::App()->request->getQuery('refactoringSlug'),
              'stepNumber' => 1),
        array('class' => 'pull-right btn btn-primary'));