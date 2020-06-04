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
    public function __construct($baseUrl = null)
    {
        if ($baseUrl === null) {
            $this->baseUrl = self::BASE_URL_HTTP;
        } else {
            $this->baseUrl = $baseUrl;
        }

        $this->client = new \GuzzleHttp\Client(
            [
                'headers' =>
                    [
                        'User-Agent' => 'AlQuranCloudPhpClient/1.0',
                        'Referer' => gethostname(),
                    ],
                'base_url' => $this->baseUrl
            ]
        );
    }

    /**
     * @param $endpoint
     * @param string $format
     * @return mixed|string
     */
    private function connect($endpoint, $params = null, $format = self::FORMAT_ARRAY)
    {
        $params = $params == null ? [] : $params;
        try {
            $apiResponse = $this->client->request('GET',
                $endpoint,
                [
                    'query' => $params
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
    public function editions($language = null, $type = null , $format = null)
    {
        if ($language !== null) {
            $params['language'] = $language;    
        }
        
        if ($type !== null) {
            $params['type'] = $type;    
        }
        
        if ($format !== null) {
            $params['format'] = $format;    
        }
        
        
        if (!empty($params)) {
            return $this->connect($this->baseUrl . 'edition', $params);
        } else {
            return $this->connect($this->baseUrl . 'edition');
        }
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
        return $this->connect($this->baseUrl . 'edition/type/' . $type);
    }

    /**
     * @param $format
     * @return mixed
     */
    public function editionsByFormat($format)
    {
        return $this->connect($this->baseUrl . 'edition/format/' . $format);
    }

    /**
     * @return mixed
     */
    public function languages()
    {
        return $this->connect($this->baseUrl . 'edition/language');
    }

    /**
     * @return mixed
     */
    public function formats()
    {
        return $this->connect($this->baseUrl . 'edition/format');
    }

    /**
     * @return mixed
     */
    public function types()
    {
        return $this->connect($this->baseUrl . 'edition/type');
    }

    /**
     * @param bool|false $edition
     * @return mixed|string
     */
    public function quran($edition = false)
    {
        if ($edition) {
            return $this->connect($this->baseUrl . 'quran/' . $edition);
        }
        return $this->connect($this->baseUrl . 'quran');
    }

    /**
     * @param $reference
     * @param bool|false $edition
     * @return mixed|string
     */
    public function ayah($reference, $edition = false)
    {
        if ($edition) {
            return $this->connect($this->baseUrl . 'ayah/' . $reference . '/' . $edition);
        }

        return $this->connect($this->baseUrl . 'ayah/' . $reference);
    }

    /**
     * @param $keyword
     * @param bool|false $surah
     * @param bool|false $edition
     * @return mixed|string
     */
    public function search($keyword, $surah = null, $edition = null)
    {
        if ($surah) {
            if ($edition !== null) {
                return $this->connect($this->baseUrl . 'search/' . $keyword . '/' . $surah . '/' . $edition);
            }

            return $this->connect($this->baseUrl . 'search/' . $keyword . '/' . $surah);

        } else {
            if ($edition !== null) {
                return $this->connect($this->baseUrl . 'search/' . $keyword . '/' . 'all' . '/' . $edition);
            }

            return $this->connect($this->baseUrl . 'search/' . $keyword . '/' . 'all');
        }
    }

    /**
     * @param $keyword
     * @param $surah
     * @param bool|false $edition
     * @return mixed|string
     */
    public function searchSurah($keyword, $surah, $edition = null)
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
            return $this->connect($this->baseUrl . 'surah/' . $number . '/' . $edition);
        }

        return $this->connect($this->baseUrl . 'surah/' . $number);
    }
    
    /**
     * Returns list of surahs
     * 
     * @return mixed|string
     */
    public function surahs()
    {
        return $this->connect($this->baseUrl . 'surah');
    }

    /**
     * @param $number
     * @param $edition
     * @return mixed|string
     */
    public function juz($number, $edition)
    {
        if ($edition) {
            return $this->connect($this->baseUrl . 'juz/' . $number . '/' . $edition);
        }

        return $this->connect($this->baseUrl . 'juz/' . $number);
    }
}
