<?php //netteCache[01]000378a:2:{s:4:"time";s:21:"0.23535900 1384859441";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:56:"/var/www/projekt/app/templates/Zamestnanec/default.latte";i:2;i:1384859266;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: /var/www/projekt/app/templates/Zamestnanec/default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '1v4ym6m2da')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb776a911d47_content')) { function _lb776a911d47_content($_l, $_args) { extract($_args)
?><!-- <h1 n:block="title">Přehled úkolů</h1> -->

<h2><?php echo Nette\Templating\Helpers::escapeHtml($user->getIdentity()->jmeno, ENT_NOQUOTES) ?>
 <?php echo Nette\Templating\Helpers::escapeHtml($user->getIdentity()->prijmeni, ENT_NOQUOTES) ?></h2>

<?php $_ctrl = $_control->getComponent("userDetailForm"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>

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