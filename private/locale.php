<?php

class Locale
{
    private static $data = null;

    private static function getData()
    {
        if (!isset(self::$data)) {
            self::$data = json_decode(file_get_contents(__DIR__ . '/locale.json'), true);
        }
        return self::$data;
    }

    public static function gatherLocale(?string $locale = null)
    {
        if ($locale) {
            $locale = strtolower($locale);
            if (isset(self::getData()[$locale])) {
                return $locale;
            }
        }

        $user = User::getUser();
        return self::gatherLocale(isset($user) ? $user->getLocale() : self::parseBrowserLocale());
    }

    public static function parseBrowserLocale()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLocale = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $idx = strlen($browserLocale);
            $locale = '';
            foreach (self::getSupportedLocales() as $key => $value) {
                $curidx = strpos($browserLocale, $key);
                if ($curidx !== false && $curidx < $idx) {
                    $idx = $curidx;
                    $locale = $key;
                }
            }
            return strlen($locale) ? $locale : 'en';
        } else {
            return 'en';
        }
    }

    public static function getValue(string $alias, ?string $locale = null)
    {
        $alias = strtolower($alias);
        return self::getData()[self::gatherLocale($locale)]['data'][$alias] ??
            self::getData()['en']['data'][$alias] ??
            $alias;
    }

    public static function getSupportedLocales()
    {
        $locales = [];
        foreach (self::getData() as $key => $locale) {
            $locales[$key] = $locale['caption'];
        }
        return $locales;
    }
}
