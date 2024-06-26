<?php

/**
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @license    https://choosealicense.com/licenses/gpl-3.0/ GNU General Public License v3.0
 * @copyright  Copyright (c) 2023 Brand Oriented sp. z o.o. (https://brandoriented.pl)
 * @copyright  Copyright (c) 2021 CI HUB GmbH (https://ci-hub.com)
 */

namespace CIHub\Bundle\SimpleRESTAdapterBundle\Utils;

final class DiffArray
{
    /**
     * Recursively computes the difference of arrays with additional index check.
     * This is a version of array_diff_assoc() that supports multidimensional arrays.
     *
     * @param array<int|string, mixed> $array1 – The array to compare from
     * @param array<int|string, mixed> $array2 – The array to compare to
     *
     * @return array<int|string, mixed> – Returns an array containing all the values from array1
     *                                  that are not present in array2
     */
    public static function diffAssocRecursive(array $array1, array $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (\is_array($value)) {
                if (!\array_key_exists($key, $array2) || !\is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = self::diffAssocRecursive($value, $array2[$key]);
                    if ([] !== $new_diff) {
                        $difference[$key] = $new_diff;
                    }
                }
            } elseif (!\array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }
}
