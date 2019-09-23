<?php
/**
 * JSON datatype output
 */
class Json implements DataOutput
{
    /**
     * 캐릭터 타입
     * 
     * @var string 
     */
    private static $detectOrder = 'EUC-KR,UTF-8';

    /**
     * JSON OUT
     *
     * @param $data
     * @return false|string|object
     */
    public static function out($data)
    {
        if (is_array($data) || is_object($data)) {
            return self::encode($data);
        } elseif (is_string($data)) {
            return self::decode($data);
        } else {
            return false;
        }
    }

    /**
     * Data(array|string) -> Json Parse
     *
     * @param $data
     * @param $detectedOrder
     * @return array|false|string
     */
    public static function parseEncode($data, $detectedOrder)
    {
        if (is_array($data)) {
            foreach ($data as $key => $item) {
                $data[$key] = self::parseEncode($item, $detectedOrder);
            }
        } elseif (is_string($data)) {
            $detected = mb_detect_encoding($data, $detectedOrder);
            if ($detected != 'UTF-8') {
                $data = iconv($detected, 'UTF-8', $data);
            }
        }

        return $data;
    }

    /**
     * Json -> Data(array) Parse
     *
     * @param $data
     * @param $detectedOrder
     * @return array|false|string
     */
    public static function parseDecode($data, $detectedOrder)
    {
        if (is_array($data)) {
            foreach ($data as $key => $item) {
                $data[$key] = self::parseDecode($item, $detectedOrder);
            }
        } elseif (is_string($data)) {
            $detected = mb_detect_encoding($data, $detectedOrder);
            if ($detected != 'EUC-KR') {
                $data = iconv($detected, 'EUC-KR', $data);
            }
        }

        return $data;
    }

    /**
     * Encoding
     *
     * @param $data
     * @param null $detectedOrder
     * @return false|string
     */
    public static function encode($data, $detectedOrder = null)
    {
        if ($detectedOrder === null) {
            $detectedOrder = self::$detectOrder;
        }
        return json_encode(self::parseEncode($data, $detectedOrder));
    }

    /**
     * Decoding
     *
     * @param $data
     * @param null $detectedOrder
     * @return array|false|string
     */
    public static function decode($data, $detectedOrder = null)
    {
        if ($detectedOrder === null) {
            $detectedOrder = 'UTF-8';
        }
        return self::parseDecode(json_decode($data), $detectedOrder);
    }
}