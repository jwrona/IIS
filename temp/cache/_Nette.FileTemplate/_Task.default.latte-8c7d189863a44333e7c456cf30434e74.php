<?php //netteCache[01]000371a:2:{s:4:"time";s:21:"0.91275700 1384597781";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:49:"/var/www/sandbox/app/templates/Task/default.latte";i:2;i:1384597771;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: /var/www/sandbox/app/templates/Task/default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '1o6gq0yhsd')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb2f378535a2_content')) { function _lb2f378535a2_content($_l, $_args) { extract($_args)
;call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>

<fieldset>
    <legend>Přidat úkol</legend>

<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("taskForm") ? "taskForm" : $_control["taskForm"]), array()) ?>
<div class="task-form">
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>

    <?php $_input = is_object("text") ? "text" : $_form["text"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
 <?php $_input = (is_object("text") ? "text" : $_form["text"]); echo $_input->getControl()->addAttributes(array('size' => 30, 'autofocus' => true)) ?>
 <?php $_input = is_object("userId") ? "userId" : $_form["userId"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
 <?php $_input = (is_object("userId") ? "userId" : $_form["userId"]); echo $_input->getControl()->addAttributes(array()) ?>
 <?php $_input = (is_object("create") ? "create" : $_form["create"]); echo $_input->getControl()->addAttributes(array()) ?>

</div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
</fieldset>

<?php $_ctrl = $_control->getComponent("taskList"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>

<?php
}}

//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbf8cee81cdb_title')) { function _lbf8cee81cdb_title($_l, $_args) { extract($_args)
?><h1><?php echo Nette\Templating\Helpers::escapeHtml($list->title, ENT_NOQUOTES) ?></h1>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>

<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 