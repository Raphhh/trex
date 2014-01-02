<?php
namespace TRex\Core;

use TRex\Serialization\DataToArrayCaster;

/**
 * Class Json
 * @package TRex\Core
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Json extends Object
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $options = 0;

    /**
     * @param string $json
     * @return Json
     * @throws \UnexpectedValueException
     */
    public static function createFromString($json)
    {
        $data = json_decode($json, true);
        if (is_array($data)) {
            return new self($data);
        }

        throw new \UnexpectedValueException(
            sprintf(
                'JSON string can not be decoded: "%s" (Error: #%s - %s)',
                $json,
                json_last_error(),
                self::getErrorMessage(json_last_error())
            )
        );
    }

    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->setData((new DataToArrayCaster())->cast($data));
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function __toString()
    {
        return (string)json_encode($this->getData(), $this->getOptions());
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getData();
    }

    /**
     * @return int
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param int $options
     */
    public function setOptions($options)
    {
        $this->options = (int)$options;
    }

    /**
     * @return array
     */
    private function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    private function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $errorNo
     * @return string
     */
    private static function getErrorMessage($errorNo)
    {
        switch ($errorNo) {
            case JSON_ERROR_NONE:
                return 'No errors';

            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';

            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';

            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';

            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';

            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';

            default:
                return 'Unknown error';
        }
    }
}
