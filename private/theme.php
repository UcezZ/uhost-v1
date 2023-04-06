<?php

class Theme
{
    private static $data = null;

    private static function getData()
    {
        if (!isset(self::$data)) {
            self::$data = json_decode(file_get_contents(__DIR__ . '/theme.json'), true);
        }
        return self::$data;
    }

    public static function gatherTheme(?string $theme = null)
    {
        if ($theme) {
            $theme = strtolower($theme);
            if (isset(self::getData()[$theme])) {
                return $theme;
            } else {
                return 'dark';
            }
        }

        $user = User::getUser();

        return self::gatherTheme(isset($user) ? $user->getTheme() : 'dark');
    }

    public static function getLink()
    {
        return self::getData()[self::gatherTheme()]['css'];
    }

    public static function getSupportedThemes()
    {
        $themes = [];
        foreach (self::getData() as $key => $theme) {
            $themes[$key] = Locale::getValue('theme.' . $key);
        }
        return $themes;
    }
}
