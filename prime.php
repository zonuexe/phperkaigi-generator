<?php

function find_divisour(int $n, int $test_divisour): int
{
    if ($test_divisour ** 2 > $n) {
        return $n;
    } elseif ($n % $test_divisour === 0) {
        return $test_divisour;
    }

    return find_divisour($n, $test_divisour + 1);
}

function smallest_division(int $n): int
{
    return find_divisour($n, 2);
}

function is_prime(int $n): bool
{
    return $n === smallest_division($n);
}

function sum_primes(int $a, int $b): int
{
    $iter = function (int $count, int $accum) use ($a, $b, &$iter) {
        if ($count > $b) {
            return $accum;
        } elseif (is_prime($count)) {
            return $iter($count + 1, $count + $accum);
        }

        return $iter($count + 1, $accum);
    };

    return $iter($a, 0);
}

function sum_primes2(int $a, int $b): int
{
    return array_reduce(
        array_filter(range($a, $b), 'is_prime'),
        fn ($x, $y) => $x + $y,
        0
    );
}
