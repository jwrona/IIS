<?php //netteCache[01]000368a:2:{s:4:"time";s:21:"0.57711100 1384698757";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:46:"/var/www/projekt/app/components/TaskList.latte";i:2;i:1384599114;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: /var/www/projekt/app/components/TaskList.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'r8flja7i4h')
;
// prolog Nette\Latte\Macros\UIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<table class="tasks">
    <thead>
    <tr>
        <th class="created">&nbsp;</th>
<?php if ($displayList): ?>        <th class="list">Seznam</th>
<?php endif ?>
        <th class="text">Úkol</th>
<?php if ($displayUser): ?>        <th class="user">Přiřazeno</th>
<?php endif ?>
        <th class="action">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($tasks) as $task): ?>
    <tr<?php if ($_l->tmp = array_filter(array($iterator->isOdd() ? 'odd' : 'even', $task->done ? 'done':null))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
        <td class="created"><?php echo Nette\Templating\Helpers::escapeHtml($template->date($task->created, 'j. n. Y'), ENT_NOQUOTES) ?></td>
<?php if ($displayList): ?>        <td class="list"><?php echo Nette\Templating\Helpers::escapeHtml($task->list->title, ENT_NOQUOTES) ?></td>
<?php endif ?>
        <td class="text"><?php echo Nette\Templating\Helpers::escapeHtml($task->text, ENT_NOQUOTES) ?></td>
<?php if ($displayUser): ?>        <td class="user"><?php echo Nette\Templating\Helpers::escapeHtml($task->user->name, ENT_NOQUOTES) ?></td>
<?php endif ?>
        <td class="action"><?php if (!$task->done): ?><a class="icon tick" href="<?php echo htmlSpecialChars($_control->link("markDone!", array($task->id))) ?>
">hotovo</a><?php endif ?>
</td>
    </tr>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
    </tbody>
</table>
