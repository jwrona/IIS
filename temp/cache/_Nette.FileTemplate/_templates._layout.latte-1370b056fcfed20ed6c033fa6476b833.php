<?php //netteCache[01]000366a:2:{s:4:"time";s:21:"0.81004500 1384809145";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:44:"/var/www/projekt/app/templates/@layout.latte";i:2;i:1384809142;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: /var/www/projekt/app/templates/@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '8s0d74u30d')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb11703adb40_title')) { function _lb11703adb40_title($_l, $_args) { extract($_args)
;
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb4f3b10fa17_head')) { function _lb4f3b10fa17_head($_l, $_args) { extract($_args)
;
}}

//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb4dc3945e60_scripts')) { function _lb4dc3945e60_scripts($_l, $_args) { extract($_args)
?>        <script src="<?php echo htmlSpecialChars($basePath) ?>/js/jquery.js"></script>
        <script src="<?php echo htmlSpecialChars($basePath) ?>/js/netteForms.js"></script>
        <script src="<?php echo htmlSpecialChars($basePath) ?>/js/main.js"></script>
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="" />
<?php if (isset($robots)): ?>        <meta name="robots" content="<?php echo htmlSpecialChars($robots) ?>" />
<?php endif ?>

        <title><?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
ob_start(); call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()); echo $template->trim($template->stripTags(ob_get_clean()))  ?> | IS Nemocnice</title>

        <link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/screen.css" />
        <link rel="shortcut icon" href="<?php echo htmlSpecialChars($basePath) ?>/favicon.ico" />
        <?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>

    </head>

    <body>
        <!-- Hlavicka -->
        <div id="header">
            <div id="header-inner">
                <div class="title"><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>">IS Nemocnice</a></div>

<?php if ($user->isLoggedIn()): ?>
                    <div class="user">
                        <span class="icon user"></span>
                        <a href="<?php echo htmlSpecialChars($_control->link("Zamestnanec:")) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($user->getIdentity()->username, ENT_NOQUOTES) ?></a> |
                        <a href="<?php echo htmlSpecialChars($_control->link("Zamestnanec:password")) ?>
">Změna hesla</a> |
                        <a href="<?php echo htmlSpecialChars($_control->link("signOut!")) ?>
">Odhlásit se</a>
                    </div>
<?php endif ?>
            </div>
        </div>

<!-- Zobrazeni obsahu -->
        <div id="container">

<!-- navigacni panel -->
            <div id="sidebar">
<?php if ($user->isLoggedIn()): ?>
                    <h2>Zaměstnanec</h2>
                    <ul>
                        <li><a href="<?php echo htmlSpecialChars($_control->link("Pacienti:")) ?>
">Pacienti</a>
                        <li><a href="<?php echo htmlSpecialChars($_control->link("Hospitalizace:")) ?>
">Hospitalizace</a>
                        <li><a href="<?php echo htmlSpecialChars($_control->link("Leky:")) ?>
">Databáze léků</a>
                    </ul>
<?php endif ?>
            </div>

            <!-- Vyzadovany obsah stranky -->
            <div id="content">
<?php $iterations = 0; foreach ($flashes as $flash): ?>                <div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; endforeach ;Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ?>
            </div>

            <div id="footer">

            </div>
        </div>

<?php call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars())  ?>
    </body>
</html>
