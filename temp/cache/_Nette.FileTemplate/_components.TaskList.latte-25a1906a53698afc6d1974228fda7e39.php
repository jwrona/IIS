<?php //netteCache[01]000378a:2:{s:4:"time";s:21:"0.96013200 1384597781";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:56:"/var/www/sandbox/app/templates/components/TaskList.latte";i:2;i:1384555083;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: /var/www/sandbox/app/templates/components/TaskList.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '6wj3shpepz')
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
<table>
    <thead>
    <tr>
        <th>Čas vytvoření</th>
        <th>Úkol</th>
        <th>Přiřazeno</th>
    </tr>
    </thead>
    <tbody>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($tasks) as $task): ?>
    <tr<?php if ($_l->tmp = array_filter(array($iterator->isOdd() ? 'odd' : 'even'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
        <td><?php echo Nette\Templating\Helpers::escapeHtml($template->date($task->created, 'j. n. Y'), ENT_NOQUOTES) ?></td>
        <td><?php echo Nette\Templating\Helpers::escapeHtml($task->text, ENT_NOQUOTES) ?></td>
        <td><?php echo Nette\Templating\Helpers::escapeHtml($task->user->name, ENT_NOQUOTES) ?></td>
    </tr>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
    </tbody>
</table>
