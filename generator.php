<?php

// https://www.php.net/manual/ja/language.generators.overview.php
function xrange(int $start, int $limit, $step = 1): Generator
{
    if ($start <= $limit) {
        if ($step <= 0) {
            throw new LogicException('Step must be positive');
        }

        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i;
        }
    } else {
        if ($step >= 0) {
            throw new LogicException('Step must be negative');
        }

        for ($i = $start; $i >= $limit; $i += $step) {
            yield $i;
        }
    }
}

function xfirst(iterable $iter)
{
    foreach ($iter as $i) {
        return $i;
    }
}

function xlast(iterable $iter)
{
    foreach ($iter as $i) {}

    return $i;
}

function xfilter(Closure $callback, iterable $iter)
{
    foreach ($iter as $k => $i) {
        if ($callback($i)) {
            yield $k => $i;
        }
    }
}

function xmap(Closure $callback, iterable $iter)
{
    foreach ($iter as $k => $i) {
        yield $k => $callback($i);
    }
}
