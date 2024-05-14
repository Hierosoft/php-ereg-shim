<?php
// Hierosoft LLC fork of php-ereg-shim
// License & other info: See php-ereg-shim/ or https://github.com/Hierosoft/php-ereg-shim
// Changes:
// - 2024-05-13: Converted to procedural (to avoid composer) by Hierosoft LLC

function convertPattern($pattern, $i)
{
    return sprintf('/%s/%s', addcslashes($pattern, '/'), $i ? 'i' : '');
}

function runPregMatch($pattern, $string, &$regs = null)
{
    $result = preg_match($pattern, $string, $matches);
    if (!$result) {
        return false;
    }

    if (func_num_args() === 2) {
        return 1;
    }

    $regs = array_map(
        static function ($match) {
            return $match === '' ? false : $match;
        },
        $matches
    );

    return max(1, strlen($matches[0]));
}

function ereg($pattern, $string, &$regs = null)
{
    if ($pattern === '' || $pattern === null) {
        trigger_error('ereg(): REG_EMPTY', E_USER_WARNING);

        return false;
    }

    $pattern = convertPattern($pattern, false);

    return func_num_args() === 2
        ? runPregMatch($pattern, $string)
        : runPregMatch($pattern, $string, $regs);
}

function eregi($pattern, $string, &$regs = null)
{
    if ($pattern === '' || $pattern === null) {
        trigger_error('eregi(): REG_EMPTY', E_USER_WARNING);

        return false;
    }

    $pattern = convertPattern($pattern, true);

    return func_num_args() === 2
        ? runPregMatch($pattern, $string)
        : runPregMatch($pattern, $string, $regs);
}

function ereg_replace($pattern, $replacement, $string)
{
    if ($pattern === '' || $pattern === null) {
        trigger_error('ereg_replace(): REG_EMPTY', E_USER_WARNING);

        return false;
    }

    return preg_replace(convertPattern($pattern, false), $replacement, $string);
}

function eregi_replace($pattern, $replacement, $string)
{
    if ($pattern === '' || $pattern === null) {
        trigger_error('eregi_replace(): REG_EMPTY', E_USER_WARNING);

        return false;
    }

    return preg_replace(convertPattern($pattern, true), $replacement, $string);
}

function split($pattern, $string, $limit = -1)
{
    if ($pattern === '' || $pattern === null) {
        trigger_error('split(): REG_EMPTY', E_USER_WARNING);

        return false;
    }

    return preg_split(convertPattern($pattern, false), $string, $limit);
}

function spliti($pattern, $string, $limit = -1)
{
    if ($pattern === '' || $pattern === null) {
        trigger_error('spliti(): REG_EMPTY', E_USER_WARNING);

        return false;
    }

    return preg_split(convertPattern($pattern, true), $string, $limit);
}

?>
