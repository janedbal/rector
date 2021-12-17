<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20211217\Symfony\Component\String;

use RectorPrefix20211217\Symfony\Component\String\Exception\ExceptionInterface;
use RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException;
/**
 * Represents a string of Unicode code points encoded as UTF-8.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Hugo Hamon <hugohamon@neuf.fr>
 *
 * @throws ExceptionInterface
 */
class CodePointString extends \RectorPrefix20211217\Symfony\Component\String\AbstractUnicodeString
{
    public function __construct(string $string = '')
    {
        if ('' !== $string && !\preg_match('//u', $string)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        $this->string = $string;
    }
    /**
     * @return $this
     */
    public function append(string ...$suffix)
    {
        $str = clone $this;
        $str->string .= 1 >= \count($suffix) ? $suffix[0] ?? '' : \implode('', $suffix);
        if (!\preg_match('//u', $str->string)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        return $str;
    }
    public function chunk(int $length = 1) : array
    {
        if (1 > $length) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('The chunk length must be greater than zero.');
        }
        if ('' === $this->string) {
            return [];
        }
        $rx = '/(';
        while (65535 < $length) {
            $rx .= '.{65535}';
            $length -= 65535;
        }
        $rx .= '.{' . $length . '})/us';
        $str = clone $this;
        $chunks = [];
        foreach (\preg_split($rx, $this->string, -1, \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY) as $chunk) {
            $str->string = $chunk;
            $chunks[] = clone $str;
        }
        return $chunks;
    }
    public function codePointsAt(int $offset) : array
    {
        $str = $offset ? $this->slice($offset, 1) : $this;
        return '' === $str->string ? [] : [\mb_ord($str->string, 'UTF-8')];
    }
    /**
     * @param mixed[]|string|\Symfony\Component\String\AbstractString $suffix
     */
    public function endsWith($suffix) : bool
    {
        if ($suffix instanceof \RectorPrefix20211217\Symfony\Component\String\AbstractString) {
            $suffix = $suffix->string;
        } elseif (!\is_string($suffix)) {
            return parent::endsWith($suffix);
        }
        if ('' === $suffix || !\preg_match('//u', $suffix)) {
            return \false;
        }
        if ($this->ignoreCase) {
            return \preg_match('{' . \preg_quote($suffix) . '$}iuD', $this->string);
        }
        return \strlen($this->string) >= \strlen($suffix) && 0 === \substr_compare($this->string, $suffix, -\strlen($suffix));
    }
    /**
     * @param mixed[]|string|\Symfony\Component\String\AbstractString $string
     */
    public function equalsTo($string) : bool
    {
        if ($string instanceof \RectorPrefix20211217\Symfony\Component\String\AbstractString) {
            $string = $string->string;
        } elseif (!\is_string($string)) {
            return parent::equalsTo($string);
        }
        if ('' !== $string && $this->ignoreCase) {
            return \strlen($string) === \strlen($this->string) && 0 === \mb_stripos($this->string, $string, 0, 'UTF-8');
        }
        return $string === $this->string;
    }
    /**
     * @param mixed[]|string|\Symfony\Component\String\AbstractString $needle
     */
    public function indexOf($needle, int $offset = 0) : ?int
    {
        if ($needle instanceof \RectorPrefix20211217\Symfony\Component\String\AbstractString) {
            $needle = $needle->string;
        } elseif (!\is_string($needle)) {
            return parent::indexOf($needle, $offset);
        }
        if ('' === $needle) {
            return null;
        }
        $i = $this->ignoreCase ? \mb_stripos($this->string, $needle, $offset, 'UTF-8') : \mb_strpos($this->string, $needle, $offset, 'UTF-8');
        return \false === $i ? null : $i;
    }
    /**
     * @param mixed[]|string|\Symfony\Component\String\AbstractString $needle
     */
    public function indexOfLast($needle, int $offset = 0) : ?int
    {
        if ($needle instanceof \RectorPrefix20211217\Symfony\Component\String\AbstractString) {
            $needle = $needle->string;
        } elseif (!\is_string($needle)) {
            return parent::indexOfLast($needle, $offset);
        }
        if ('' === $needle) {
            return null;
        }
        $i = $this->ignoreCase ? \mb_strripos($this->string, $needle, $offset, 'UTF-8') : \mb_strrpos($this->string, $needle, $offset, 'UTF-8');
        return \false === $i ? null : $i;
    }
    public function length() : int
    {
        return \mb_strlen($this->string, 'UTF-8');
    }
    /**
     * @return $this
     */
    public function prepend(string ...$prefix)
    {
        $str = clone $this;
        $str->string = (1 >= \count($prefix) ? $prefix[0] ?? '' : \implode('', $prefix)) . $this->string;
        if (!\preg_match('//u', $str->string)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        return $str;
    }
    /**
     * @return $this
     */
    public function replace(string $from, string $to)
    {
        $str = clone $this;
        if ('' === $from || !\preg_match('//u', $from)) {
            return $str;
        }
        if ('' !== $to && !\preg_match('//u', $to)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        if ($this->ignoreCase) {
            $str->string = \implode($to, \preg_split('{' . \preg_quote($from) . '}iuD', $this->string));
        } else {
            $str->string = \str_replace($from, $to, $this->string);
        }
        return $str;
    }
    /**
     * @return $this
     */
    public function slice(int $start = 0, int $length = null)
    {
        $str = clone $this;
        $str->string = \mb_substr($this->string, $start, $length, 'UTF-8');
        return $str;
    }
    /**
     * @return $this
     */
    public function splice(string $replacement, int $start = 0, int $length = null)
    {
        if (!\preg_match('//u', $replacement)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        $str = clone $this;
        $start = $start ? \strlen(\mb_substr($this->string, 0, $start, 'UTF-8')) : 0;
        $length = $length ? \strlen(\mb_substr($this->string, $start, $length, 'UTF-8')) : $length;
        $str->string = \substr_replace($this->string, $replacement, $start, $length ?? \PHP_INT_MAX);
        return $str;
    }
    public function split(string $delimiter, int $limit = null, int $flags = null) : array
    {
        if (1 > ($limit = $limit ?? \PHP_INT_MAX)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Split limit must be a positive integer.');
        }
        if ('' === $delimiter) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Split delimiter is empty.');
        }
        if (null !== $flags) {
            return parent::split($delimiter . 'u', $limit, $flags);
        }
        if (!\preg_match('//u', $delimiter)) {
            throw new \RectorPrefix20211217\Symfony\Component\String\Exception\InvalidArgumentException('Split delimiter is not a valid UTF-8 string.');
        }
        $str = clone $this;
        $chunks = $this->ignoreCase ? \preg_split('{' . \preg_quote($delimiter) . '}iuD', $this->string, $limit) : \explode($delimiter, $this->string, $limit);
        foreach ($chunks as &$chunk) {
            $str->string = $chunk;
            $chunk = clone $str;
        }
        return $chunks;
    }
    /**
     * @param mixed[]|string|\Symfony\Component\String\AbstractString $prefix
     */
    public function startsWith($prefix) : bool
    {
        if ($prefix instanceof \RectorPrefix20211217\Symfony\Component\String\AbstractString) {
            $prefix = $prefix->string;
        } elseif (!\is_string($prefix)) {
            return parent::startsWith($prefix);
        }
        if ('' === $prefix || !\preg_match('//u', $prefix)) {
            return \false;
        }
        if ($this->ignoreCase) {
            return 0 === \mb_stripos($this->string, $prefix, 0, 'UTF-8');
        }
        return 0 === \strncmp($this->string, $prefix, \strlen($prefix));
    }
}
