<?php

namespace Dgame\Filter;

/**
 * @param array $data
 *
 * @return Filter
 */
function prepare(array $data): Filter
{
    return new Filter($data);
}