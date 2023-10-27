<?php


$textStorage = array();

function add(array &$textStorage, string $title, string $text): void
{
    $newText = array('title' => $title, 'text' => $text);
    $textStorage[] = $newText;
}

function remove(&$textStorage, int $index): bool
{
    if (isset($textStorage[$index])) {
        unset($textStorage[$index]);
        return true;
    } else {
        return false;
    }
}

function edit(array &$textStorage, int $index, string $newTitle, string $newText): bool
{
    if (isset($textStorage[$index])) {
        $textStorage[$index]['title'] = $newTitle;
        $textStorage[$index]['text'] = $newText;
        return true;
    } else {
        return false;
    }
}

function main(&$textStorage): void
{
    while (true) {
        $title = readline('Введите заголовок: ');
        $text = readline('Введите текст: ');

        if ($title === '' || $text === '') {
            break;
        }

        add($textStorage, $title, $text);
    }
}

main($textStorage);
remove($textStorage, 5);
edit($textStorage, 0, 'Заголовок', 'Текст');
print_r($textStorage);