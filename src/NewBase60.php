<?php
/*
 * Tantek Çelik's NewBase60.
 *     http://tantek.com/
 *     http://tantek.pbworks.com/NewBase60
 *
 * Roughly translated from CASSIS to PHP by Jared Howland <newbase60@jaredhowland.com>
 *
 * Released under CC BY-SA 3.0:
 *     http://creativecommons.org/licenses/by-sa/3.0/
 */

namespace NewBase60;

class NewBase60
{
    ///////////////////////////
    // New Base 60 Functions //
    ///////////////////////////

    /**
     * Convert from a base 10 to new base 60.
     *
     * @param string $n String in base 10 to be converted into new base 60
     *
     * @return string String version of base 10 integer in new base 60
     */
    public static function toNewBase60(string $n): string
    {
        $m = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ_abcdefghijkmnopqrstuvwxyz';
        $p = '';
        $s = '';
        if ($n === '' || $n === 0) {
            return '0';
        }
        if ($n < 0) {
            $n = -$n;
            $p = '-';
        }
        while ($n > 0) {
            $d = bcmod($n, 60);
            $s = $m[$d].$s;
            $n = bcdiv(bcsub($n, $d), 60);
        }

        return self::stringConcatenate($p, $s);
    }

    /**
     * Convert from a base 10 integer to new base 60 with leading zeroes.
     *
     * @param string $n String in base 10 to be converted into new base 60
     * @param int    $f Number of zeroes with which to pad new base 60 string. Default: `1`
     *
     * @return string String version of base 10 integer in new base 60
     */
    public static function toNewBase60WithLeadingZeroes(string $n, int $f = 1): string
    {
        return self::stringPadLeft(self::toNewBase60($n), $f, '0');
    }

    /**
     * Convert from new base 60 to base 10.
     *
     * @param string $s String in new base 60 to be converted into base 10
     *
     * @return string String version of new base 60 in base 10
     */
    public static function toBase10(string $s): string
    {
        $j = strlen($s);
        $m = 1;
        $n = 0;
        if (strpos($s, '-') === 0) {
            $m = -1;
            --$j;
            $s = substr($s, 1, $j);
        }
        for ($i = 0; $i < $j; ++$i) { // Iterate from first to last character of `$s`
            $c = ord($s[$i]); // Put current ASCII of character into `$c`
            if ($c >= 48 && $c <= 57) {
                $c -= 48;
            } elseif ($c >= 65 && $c <= 72) {
                $c -= 55;
            } elseif ($c === 73 || $c === 108) {
                // Error correct typo capital `I` or lowercase `l` to 1
                $c = 1;
            } elseif ($c >= 74 && $c <= 78) {
                $c -= 56;
            } elseif ($c === 79) {
                // Error correct typo capital `O` to 0
                $c = 0;
            } elseif ($c >= 80 && $c <= 90) {
                $c -= 57;
            } elseif ($c === 95 || $c === 45) {
                // Error correct type `_` underscore and `-` hyphen to `_` underscore
                $c = 34;
            } elseif ($c >= 97 && $c <= 107) {
                $c -= 62;
            } elseif ($c >= 109 && $c <= 122) {
                $c -= 63;
            } else {
                // Treat all other noise as 0
                break;
            }
            $n = bcadd(bcmul(60, $n), $c);
        }

        return $n * $m;
    }

    /**
     * Convert from new base 60 to base 10.
     *
     * @param string $s String to convert
     * @param int    $f Number of characters to pad out. Default: `1`
     *
     * @return string String version of new base 60 as base 10
     */
    public static function toBase10WithLeadingZeroes(string $s, int $f = 1): string
    {
        return self::stringPadLeft(self::toBase10($s), $f, '0');
    }

    //////////////////////
    // String Functions //
    //////////////////////

    /**
     * Concatenate strings together.
     *
     * @param string ...$args Strings to concatenate together
     *
     * @return string Concatenated string
     */
    private static function stringConcatenate(...$args): string
    {
        $r = '';
        for ($i = count($args) - 1; $i >= 0; --$i) {
            $r = $args[$i].$r;
        }

        return $r;
    }

    /**
     * Pad string on left side.
     *
     * @param string $s1 String to pad
     * @param int    $n  How many characters to pad out. Default: `1`
     * @param string $s2 Character to pad with. Default: `0`
     *
     * @return string Left-padded string
     */
    private static function stringPadLeft(string $s1, int $n = 1, string $s2 = '0'): string
    {
        return str_pad($s1, $n, $s2, STR_PAD_LEFT);
    }
}
