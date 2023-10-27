<?php

$textStorage = array();

function add(array &$textStorage, string $title, string $text): void
{
    $newText = array('title' => $title, 'text' => $text);
    $textStorage[] = $newText;
}

main($textStorage);
function remove(&$textStorage, int $index): bool
{
    if (isset($textStorage[$index])) {
        unset($textStorage[$index]);
        return true;
    } else {
        return false;
    }
}

remove($textStorage,5);

function edit(array &$textStorage, string $newTitle, string $newText, int $index): bool
{
    if (isset($textStorage[$index])) {
        $textStorage[$index]['title'] = $newTitle;
        $textStorage[$index]['text'] = $newText;
        return true;
    } else {
        return false;
    }
}

edit($textStorage, 0, 'Заголовок', 'Текст');
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
