<?php

$textStorage = array();

function add(array &$textStorage, string $title, string $text): void
{
    $newText = array('title' => $title, 'text' => $text);
    $textStorage[] = $newText;
}

main($textStorage);
function remove(&$textStorage): bool
{
    if (isset($textStorage)) {
        unset($textStorage[5]);
        return true;
    } else {
        return false;
    }
}

remove($textStorage);

function edit(array &$textStorage, string $newTitle, string $newText): bool
{
    if (isset($textStorage[0])) {
        $textStorage[0]['title'] = $newTitle;
        $textStorage[0]['text'] = $newText;
        return true;
    } else {
        return false;
    }
}

edit($textStorage, 'Заголовок', 'Текст');
print_r($textStorage);


function main(&$textStorage): void
{
    $title = readline('Введите заголовок: ');
    $text = readline('Введите текст: ');
    while ($title !== '' && $text !== '') {
        add($textStorage, $title, $text);
        $title = readline('Введите заголовок: ');
        $text = readline('Введите текст: ');
    }
}
