[![CircleCI](https://circleci.com/gh/meezaan/alquran-api-client-php.svg?style=shield)](https://circleci.com/gh/meezaan/alquran-api-client-php)

### AlQuran Cloud API Client (PHP)
This is a PHP API client that uses the rest API at alquran.cloud to fetch Quran Ayahs, Surahs Juzs or the entire Quran..


### Installation
The API Client is a composer package. To use it, you need to run the following:
```
composer require alquran/api-client
```

### Usage

#### Instantiate the Client
```
$t = new \AlQuranCloud\ApiClient\Client();
```

#### Getting an Ayah
To get a single ayah, use:
```
$t->ayah(765); // This will return Ayah 765
$t->ayah(765, 'en.pickthall'); // This will return Ayah 765 with Marmaduke Pickthall's English translation
$t->ayah('2:255'); // This will return Surah 2, Ayah 255 (which is Ayat Al Kursi)
```

#### Getting a Surah
To get a surah, use:
```
$t->surah(36); // This will return Surah Yaseen
$t->surah(36, 'en.asad'); // This will return Surah Yaseen with Muhammad Asad's English translation
```

#### Getting a Juz
To get a juz, use:
```
$t->juz(30); // This will return Juz 30 (there are only 30!)
```

#### Getting Editions, Searching and more...
Please see the complete documentation in docs/index.html (Clone the repo and open the file in a browser).

### Authors and Contributors
Meezaan-ud-Din Abdu Dhil-Jalali Wal-Ikram (@meezaan).

### Support or Contact
For support, please visit http://alquran.cloud/api or http://alquran.cloud/contact.
