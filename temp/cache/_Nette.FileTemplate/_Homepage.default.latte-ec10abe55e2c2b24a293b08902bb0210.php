<?php //netteCache[01]000400a:2:{s:4:"time";s:21:"0.07714600 1384950535";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:78:"/home/users/xw/xwrona00/WWW/nette/projekt/app/templates/Homepage/default.latte";i:2;i:1384944490;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: /home/users/xw/xwrona00/WWW/nette/projekt/app/templates/Homepage/default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '3d6298h9ys')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb892726a080_content')) { function _lb892726a080_content($_l, $_args) { extract($_args)
?><!-- <h1 n:block="title">Přehled úkolů</h1> -->

<?php if ($user->isLoggedIn()): ?>
    <h2>Informační systém nemocnice poskytuje následující činnosti:</h2>
    <ul>
        <li><a href="<?php echo htmlSpecialChars($_control->link("Pacienti:")) ?>
">Databáze registrovaných pacientů</a>
        <li><a href="<?php echo htmlSpecialChars($_control->link("Hospitalizace:")) ?>
">Aktuálně hospitalizovaní pacienti</a>
<?php if ($user->isInRole('lekar') or $user->isInRole('administrator')): ?>
            <li><a href="<?php echo htmlSpecialChars($_control->link("Leky:")) ?>
">Databáze léků</a>
<?php endif ;if ($user->isInRole('administrator')): ?>
            <li><a href="<?php echo htmlSpecialChars($_control->link("Zamestnanec:all")) ?>
">Přehled všech zaměstnanců</a>
<?php endif ?>
    </ul>
<?php endif ?>

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