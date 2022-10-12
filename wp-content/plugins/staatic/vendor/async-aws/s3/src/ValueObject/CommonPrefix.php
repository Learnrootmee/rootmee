<?php

namespace Staatic\Vendor\AsyncAws\S3\ValueObject;

final class CommonPrefix
{
    private $prefix;
    public function __construct(array $input)
    {
        $this->prefix = $input['Prefix'] ?? null;
    }
    public static function create($input) : self
    {
        return $input instanceof self ? $input : new self($input);
    }
    /**
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
