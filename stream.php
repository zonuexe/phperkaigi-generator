<?php

class stream
{
    private $car;
    private ?Closure $cdr;

    public function __construct($a, ?Closure $b)
    {
        $this->car = $a;
        $this->cdr = $b;
    }

    public function car()
    {
        return $this->car;
    }

    public function cdr(): ?stream
    {
        return $this->cdr ? ($this->cdr)() : null;
    }
}

function cons_stream($x, Closure $y): stream
{
    return new stream($x, $y);
}

function stream_car(stream $stream)
{
    return $stream->car();
}

function stream_cdr(stream $stream): ?stream
{
    return $stream->cdr();
}

function stream_ref(stream $s, int $n)
{
    return ($n === 0) ? $s->car() : stream_ref($s->cdr(), $n - 1);
}

function stream_map(Closure $proc, ?stream $s): ?stream
{
    if ($s === null) {
        return null;
    }

    return cons_stream($proc($s->car), fn() => stream_map($proc, stream_cdr));
}

function stream_filter(Closure $pred, ?stream $stream): ?stream
{
    if ($stream === null) {
        return null;
    } elseif ($pred($stream->car())) {
        return cons_stream($stream->car(), fn() => stream_filter($pred, $stream->cdr()));
    }

    return stream_filter($pred, $stream->cdr());
}

function stream_foreach(Closure $proc, ?stream $s)
{
    if ($s === null) {
        return 'done';
    }

    $ret = $proc($s->car());

    stream_foreach($proc, $s->cdr());

    return $ret;
}

function stream_enumerate_interval(int $low, int $high): ?stream
{
    if ($low > $high) {
        return null;
    }

    return cons_stream($low, fn() => stream_enumerate_interval($low + 1, $high));
}
