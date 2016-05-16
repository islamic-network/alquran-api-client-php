<?php

namespace AlQuranCloud\ApiClient;

/**
 * Class Client
 */
class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @const string
     */
    const FORMAT_JSON = 'json';

    /**
     * @const string
     */
    const FORMAT_ARRAY = 'array';

    /**
     * @const string
     */
    const BASE_URL_HTTP = 'http://api.alquran.cloud/';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->baseUrl = self::BASE_URL_HTTP;

        $this->client = new \GuzzleHttp\Client(
            [
                'headers' =>
                    [
                        'User-Agent' => 'AlQuranCloudPhpClient/1.0'
                    ],
                'base_uri' => $this->baseUrl
            ]
        );
    }

    /**
     * @param $endpoint
     * @param string $format
     * @return mixed|string
     */
    private function connect($endpoint, $format = self::FORMAT_ARRAY)
    {
        try {
            $apiResponse = $this->client->request('GET',
                $endpoint,
                [
                    'query' => []
                ]
            );
            $response = (string) $apiResponse->getBody()->getContents();

            if ($format == self::FORMAT_ARRAY) {
                return json_decode($response);
            }

            // Otherwise return the raw JSON from the API.
            return $response;

        } catch (Exception $e) {
            die('AlQuranCloudPhpClient ::: ALERT ::: Unable to connect to the Al Quran Cloud API');
        }
    }

    /**
     * @return mixed|string
     */
    public function editions()
    {
        return $this->connect('edition');
    }

    /**
     * @param $language
     * @return mixed
     */
    public function editionsByLanguage($language)
    {
        return $this->connect('edition/language/' . $language);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function editionsByType($type)
    {
        return $this->connect('edition/type/' . $type);
    }

    /**
     * @param $format
     * @return mixed
     */
    public function editionsByFormat($format)
    {
        return $this->connect('edition/format/' . $format);
    }

    /**
     * @return mixed
     */
    public function languages()
    {
        return $this->connect('edition/language');
    }

    /**
     * @return mixed
     */
    public function formats()
    {
        return $this->connect('edition/format');
    }

    /**
     * @return mixed
     */
    public function types()
    {
        return $this->connect('edition/type');
    }
    
    /**
     * @param bool|false $edition
     * @return mixed|string
     */
    public function quran($edition = false)
    {
        if ($edition) {
            return $this->connect('quran/' . $edition);
        }
        return $this->connect('quran');
    }

    /**
     * @param $reference
     * @param bool|false $edition
     * @return mixed|string
     */
    public function ayah($reference, $edition = false)
    {
        if ($edition) {
            return $this->connect('ayah/' . $reference . '/' . $edition);
        }

        return $this->connect('ayah/' . $reference);
    }

    /**
     * @param $keyword
     * @param bool|false $surah
     * @param bool|false $edition
     * @return mixed|string
     */
    public function search($keyword, $surah = false, $edition = false)
    {
        if ($surah) {
            if ($edition) {
                return $this->connect('search/' . $keyword . '/' . $surah . '/' . $edition);
            }

            return $this->connect('search/' . $keyword . '/' . $surah);

        } else {
            if ($edition) {
                return $this->connect('search/' . $keyword . '/' . 'all' . '/' . $edition);
            }

            return $this->connect('search/' . $keyword . '/' . 'all');
        }
    }

    /**
     * @param $keyword
     * @param $surah
     * @param bool|false $edition
     * @return mixed|string
     */
    public function searchSurah($keyword, $surah, $edition = false)
    {
        return $this->search($keyword, $surah, $edition);
    }

    /**
     * @param $number
     * @param bool|false $edition
     * @return mixed|string
     */
    public function surah($number, $edition = false)
    {
        if ($edition) {
            return $this->connect('surah/' . $number . '/' . $edition);
        }

        return $this->connect('surah/' . $number);
    }

    /**
     * @param $number
     * @param $edition
     * @return mixed|string
     */
    public function juz($number, $edition)
    {
        if ($edition) {
            return $this->connect('juz/' . $number . '/' . $edition);
        }

        return $this->connect('juz/' . $number);
    }
}
