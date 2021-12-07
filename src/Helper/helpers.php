<?php

use Eumeda\Helpers\BusinessDayHelpers;
use Eumeda\Helpers\StringHelpers;
use Stringy\Stringy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

if (! function_exists('ifNotArrayConvertToArray')) {
    function ifNotArrayConvertToArray($array)
    {
        return (isset($array[0]) and is_array($array)) ? $array : [$array];
    }
}

if (! function_exists('object2array')) {
    function object2array($obj)
    {
        return is_array($obj) ? $obj : [$obj];
    }
}

if (! function_exists('object2null')) {
    function object2null($obj)
    {
        return $obj ?? null;
    }
}

if (! function_exists('parseJson')) {
    function parseJson($result)
    {
        return json_decode(json_encode($result), true);
    }
}

if (! function_exists('make_bkm_order_id')) {
    function make_bkm_order_id($paymentOrderId)
    {
        return gmp_strval(gmp_init($paymentOrderId, 16), 62);
    }
}

if (! function_exists('generatePaymentMasterOrderId')) {
    /**
     * Create payment master order Id.
     *
     * @return string
     */
    function generatePaymentMasterOrderId()
    {
        $uid = uniqid('CID', true);

        return str_replace('.', '', $uid);
    }
}

if (! function_exists('config')) {
    /**
     * Get the config value by key.
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    function config($name, $default = null)
    {
        static $config;

        if (isset($config[$name])) {
            return $config[$name];
        }

        try {
            $value = container()->getParameter($name);
        } catch (InvalidArgumentException $e) {
        }

        return $config[$name] = ($value ?? $default);
    }
}

if (! function_exists('container')) {
    /**
     * Get the implementation of Container.
     *
     * @return ContainerInterface
     */
    function container()
    {
        return kernel()->getContainer();
    }
}

if (! function_exists('date_increase_day')) {
    /**
     * Calculate increased date for given parameters.
     *
     * @param int  $days
     * @param bool $onlyBusinessDays
     *
     * @return DateTime
     */
    function date_increase_day(DateTime $date, $days, $onlyBusinessDays = true)
    {
        return (new BusinessDayHelpers())->increaseDay($date, $days, $onlyBusinessDays);
    }
}

if (! function_exists('is_base64')) {
    /**
     * Returns true if the string is base64 encoded, false otherwise.
     *
     * @param string $value
     *
     * @return bool
     */
    function is_base64($value)
    {
        return (new Stringy($value))->isBase64();
    }
}

if (! function_exists('is_json')) {
    /**
     * Returns true if the string is JSON, false otherwise. Unlike json_decode
     * in PHP 5.x, this method is consistent with PHP 7 and other JSON parsers,
     * in that an empty string is not considered valid JSON.
     *
     * @param string $value
     *
     * @return bool
     */
    function is_json($value)
    {
        return (new Stringy($value))->isJson();
    }
}

if (! function_exists('is_serialized')) {
    /**
     * Returns true if the string is serialized, false otherwise.
     *
     * @param string $value
     *
     * @return bool
     */
    function is_serialized($value)
    {
        return (new Stringy($value))->isSerialized();
    }
}

if (! function_exists('kernel')) {
    /**
     * Get the implementation of Kernel.
     *
     * @return KernelInterface
     */
    function kernel()
    {
        global $kernel;

        if (! ($kernel instanceof KernelInterface)) {
            throw new RuntimeException('Kernel must be implementation of KernelInterface');
        }

        return $kernel;
    }
}

if (! function_exists('serializer')) {
    /**
     * Serialize given data.
     *
     * @param mixed  $data
     * @param string $type
     *
     * @return string
     */
    function serializer($data, $type = 'json')
    {
        return container()->get('jms_serializer')->serialize($data, $type);
    }
}

if (! function_exists('str_append')) {
    /**
     * Returns a new string with $string appended.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_append($value, $needle)
    {
        return (string) (new Stringy($value))->append($needle);
    }
}

if (! function_exists('str_at')) {
    /**
     * Returns the character at $index, with indexes starting at 0.
     *
     * @param string $value
     * @param int    $index
     *
     * @return string
     */
    function str_at($value, $index = 0)
    {
        return (new Stringy($value))->at($index);
    }
}

if (! function_exists('str_between')) {
    /**
     * Returns the substring between $start and $end, if found, or an empty
     * string. An optional offset may be supplied from which to begin the
     * search for the start string.
     *
     * @param string $value
     * @param string $start
     * @param string $end
     * @param int    $offset
     *
     * @return string
     */
    function str_between($value, $start, $end, $offset = 0)
    {
        return (new Stringy($value))->between($start, $end, $offset);
    }
}

if (! function_exists('str_camelize')) {
    /**
     * Returns a camelCase version of the string. Trims surrounding spaces,
     * capitalizes letters following digits, spaces, dashes and underscores,
     * and removes spaces, dashes, as well as underscores.
     *
     * @param string $value
     *
     * @return string
     */
    function str_camelize($value)
    {
        return (new Stringy($value))->camelize();
    }
}

if (! function_exists('str_chars')) {
    /**
     * Returns an array consisting of the characters in the string.
     *
     * @param string $value
     *
     * @return array
     */
    function str_chars($value)
    {
        return (new Stringy($value))->chars();
    }
}

if (! function_exists('str_collapse_whitespace')) {
    /**
     * Trims the string and replaces consecutive whitespace characters with a
     * single space. This includes tabs and newline characters, as well as
     * multibyte whitespace such as the thin space and ideographic space.
     *
     * @param string $value
     *
     * @return string
     */
    function str_collapse_whitespace($value)
    {
        return (new Stringy($value))->collapseWhitespace();
    }
}

if (! function_exists('str_contains')) {
    /**
     * Returns true if the string contains $needle, false otherwise. By default
     * the comparison is case-sensitive, but can be made insensitive by setting
     * $caseSensitive to false.
     *
     * @param string $value
     * @param string $needle
     * @param bool   $caseSensitive
     *
     * @return bool
     */
    function str_contains($value, $needle, $caseSensitive = true)
    {
        return (new Stringy($value))->contains($needle, $caseSensitive);
    }
}

if (! function_exists('str_contains_all')) {
    /**
     * Returns true if the string contains all $needles, false otherwise. By
     * default the comparison is case-sensitive, but can be made insensitive by
     * setting $caseSensitive to false.
     *
     * @param string $value
     * @param bool   $caseSensitive
     *
     * @return bool
     */
    function str_contains_all($value, array $needles, $caseSensitive = true)
    {
        return (new Stringy($value))->containsAll($needles, $caseSensitive);
    }
}

if (! function_exists('str_contains_any')) {
    /**
     * Returns true if the string contains any $needles, false otherwise. By
     * default the comparison is case-sensitive, but can be made insensitive by
     * setting $caseSensitive to false.
     *
     * @param string $value
     * @param bool   $caseSensitive
     *
     * @return bool
     */
    function str_contains_any($value, array $needles, $caseSensitive = true)
    {
        return (new Stringy($value))->containsAny($needles, $caseSensitive);
    }
}

if (! function_exists('str_dasherize')) {
    /**
     * Returns a lowercase and trimmed string separated by dashes. Dashes are
     * inserted before uppercase characters (with the exception of the first
     * character of the string), and in place of spaces as well as underscores.
     *
     * @param string $value
     *
     * @return string
     */
    function str_dasherize($value)
    {
        return (string) (new Stringy($value))->dasherize();
    }
}

if (! function_exists('str_delimit')) {
    /**
     * Returns a lowercase and trimmed string separated by the given delimiter.
     * Delimiters are inserted before uppercase characters (with the exception
     * of the first character of the string), and in place of spaces, dashes,
     * and underscores. Alpha delimiters are not converted to lowercase.
     *
     * @param string $value
     * @param string $delimeter
     *
     * @return string
     */
    function str_delimit($value, $delimeter = '-')
    {
        return (string) (new Stringy($value))->delimit($delimeter);
    }
}

if (! function_exists('str_ends_with')) {
    /**
     * Returns true if the string ends with $substring, false otherwise. By
     * default, the comparison is case-sensitive, but can be made insensitive
     * by setting $caseSensitive to false.
     *
     * @param string $value
     * @param string $needle
     * @param bool   $caseSensitive
     *
     * @return bool
     */
    function str_ends_with($value, $needle, $caseSensitive = true)
    {
        return (new Stringy($value))->endsWith($needle, $caseSensitive);
    }
}

if (! function_exists('str_ensure_left')) {
    /**
     * Ensures that the string begins with $substring. If it doesn't, it's
     * prepended.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_ensure_left($value, $needle)
    {
        return (string) (new Stringy($value))->ensureLeft($needle);
    }
}

if (! function_exists('str_ensure_right')) {
    /**
     * Ensures that the string ends with $substring. If it doesn't, it's
     * appended.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_ensure_right($value, $needle)
    {
        return (string) (new Stringy($value))->ensureRight($needle);
    }
}

if (! function_exists('str_first')) {
    /**
     * Returns the first $n characters of the string.
     *
     * @param string $value
     * @param int    $index
     *
     * @return string
     */
    function str_first($value, $index)
    {
        return (string) (new Stringy($value))->first($index);
    }
}

if (! function_exists('str_humanize')) {
    /**
     * Capitalizes the first word of the string, replaces underscores with
     * spaces, and strips '_id'.
     *
     * @param string $value
     *
     * @return string
     */
    function str_humanize($value)
    {
        return (new Stringy($value))->humanize();
    }
}

if (! function_exists('str_insert')) {
    /**
     * Inserts $substring into the string at the $index provided.
     *
     * @param string $value
     * @param string $needle
     * @param int    $index
     *
     * @return string
     */
    function str_insert($value, $needle, $index)
    {
        return (string) (new Stringy($value))->insert($needle, $index);
    }
}

if (! function_exists('str_last')) {
    /**
     * Returns the last $n characters of the string.
     *
     * @param string $value
     * @param int    $index
     *
     * @return string
     */
    function str_last($value, $index)
    {
        return (new Stringy($value))->last($index);
    }
}

if (! function_exists('str_length')) {
    /**
     * Returns the length of the string. An alias for PHP's mb_strlen() function.
     *
     * @param string $value
     *
     * @return int
     */
    function str_length($value)
    {
        return (new Stringy($value))->length();
    }
}

if (! function_exists('str_lines')) {
    /**
     * Splits on newlines and carriage returns, returning an array of Stringy
     * objects corresponding to the lines in the string.
     *
     * @param string $value
     *
     * @return array
     */
    function str_lines($value)
    {
        return (new Stringy($value))->lines();
    }
}

if (! function_exists('str_pad_left')) {
    /**
     * Returns a new string of a given length such that the beginning of the
     * string is padded. Alias for pad() with a $padType of 'left'.
     *
     * @param string $value
     * @param int    $length
     * @param string $needle
     *
     * @return string
     */
    function str_pad_left($value, $length, $needle = ' ')
    {
        return (string) (new Stringy($value))->padLeft($length, $needle);
    }
}

if (! function_exists('str_pad_right')) {
    /**
     * Returns a new string of a given length such that the end of the string
     * is padded. Alias for pad() with a $padType of 'right'.
     *
     * @param string $value
     * @param int    $length
     * @param string $needle
     *
     * @return string
     */
    function str_pad_right($value, $length, $needle = ' ')
    {
        return (string) (new Stringy($value))->padRight($length, $needle);
    }
}

if (! function_exists('str_prepend')) {
    /**
     * Returns a new string starting with $string.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_prepend($value, $needle)
    {
        return (string) (new Stringy($value))->prepend($needle);
    }
}

if (! function_exists('str_remove_left')) {
    /**
     * Returns a new string with the prefix $substring removed, if present.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_remove_left($value, $needle)
    {
        return (string) (new Stringy($value))->removeLeft($needle);
    }
}

if (! function_exists('str_remove_right')) {
    /**
     * Returns a new string with the suffix $substring removed, if present.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_remove_right($value, $needle)
    {
        return (string) (new Stringy($value))->removeRight($needle);
    }
}

if (! function_exists('str_reverse')) {
    /**
     * Returns a reversed string. A multibyte version of strrev().
     *
     * @param string $value
     *
     * @return string
     */
    function str_reverse($value)
    {
        return (string) (new Stringy($value))->reverse();
    }
}

if (! function_exists('str_safe_truncate')) {
    /**
     * Truncates the string to a given length, while ensuring that it does not
     * split words. If $substring is provided, and truncating occurs, the
     * string is further truncated so that the substring may be appended without
     * exceeding the desired length.
     *
     * @param string $value
     * @param int    $length
     * @param string $end
     *
     * @return string
     */
    function str_safe_truncate($value, $length, $end = '...')
    {
        return (string) (new Stringy($value))->safeTruncate($length, $end);
    }
}

if (! function_exists('str_slugify')) {
    /**
     * Converts the string into an URL slug. This includes replacing non-ASCII
     * characters with their closest ASCII equivalents, removing remaining
     * non-ASCII and non-alphanumeric characters, and replacing whitespace with
     * $replacement. The replacement defaults to a single dash, and the string
     * is also converted to lowercase.
     *
     * @param string $value
     * @param string $needle
     *
     * @return string
     */
    function str_slugify($value, $needle)
    {
        return (string) (new Stringy($value))->slugify($needle);
    }
}

if (! function_exists('str_starts_with')) {
    /**
     * Returns true if the string begins with $substring, false otherwise. By
     * default, the comparison is case-sensitive, but can be made insensitive
     * by setting $caseSensitive to false.
     *
     * @param string $value
     * @param string $needle
     *
     * @return bool
     */
    function str_starts_with($value, $needle)
    {
        return (new Stringy($value))->startsWith($needle);
    }
}

if (! function_exists('str_slice')) {
    /**
     * Returns the substring beginning at $start, and up to, but not including
     * the index specified by $end. If $end is omitted, the function extracts
     * the remaining string. If $end is negative, it is computed from the end
     * of the string.
     *
     * @param string $value
     * @param int    $start
     * @param int    $end
     *
     * @return string
     */
    function str_slice($value, $start, $end = null)
    {
        return (string) (new Stringy($value))->slice($start, $end);
    }
}

if (! function_exists('quick_random')) {
    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param int $length
     *
     * @return string
     */
    function quick_random($length = 16)
    {
        return (new StringHelpers())->quickRandom($length);
    }
}
