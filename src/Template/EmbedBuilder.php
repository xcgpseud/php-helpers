<?php

namespace Helpers\Template;

class EmbedBuilder
{
    /** @var array */
    private $values;

    /** @var EmbedType */
    private $type;

    /**
     * @param EmbedType $type
     * @return EmbedBuilder
     */
    public static function start(EmbedType $type): self
    {
        return new self($type);
    }

    /**
     * EmbedBuilder constructor.
     * @param EmbedType $type
     */
    private function __construct(EmbedType $type)
    {
        $this->type = $type;
    }

    /**
     * @param $key
     * @param $value
     * @return EmbedBuilder
     */
    public function __call($key, $value)
    {
        $this->values[$key] = reset($value);
        return $this;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->formatString();
    }

    /**
     * Format the string from the array
     *
     * @return string
     */
    private function formatString()
    {
        list($start, $end) = $this->getEmbedStartAndEnd();

        foreach ($this->values as $key => $value) {
            $start .= $key;
            $start .= !empty($value) ? sprintf('="%s" ', $value) : ' ';
        }

        return rtrim($start, ' ') . $end;
    }

    /**
     * Return, as a tuple, the start and end of an embed depending on the type
     *
     * @return array
     */
    private function getEmbedStartAndEnd()
    {
        switch ($this->type->getValue()) {
            case EmbedType::CSS():
                $start = "<link ";
                $end = "/>";
                break;
            case EmbedType::JS():
                $start = "<script ";
                $end = "></script>";
                break;
            default:
                $start = $end = "";
        }

        return [$start, $end];
    }
}