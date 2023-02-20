<?php

function tStart()
{
    return microtime(true);
}

function tTotal($start)
{
    return microtime(true) - $start;
}

