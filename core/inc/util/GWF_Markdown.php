<?php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\MarkdownConverter;
/**
 * Wrapper for CommonMarkConverter.
 * @author gizmore
 * @since 23.Jun.2023
 */
class GWF_Markdown
{

    public static function parse($markdown)
    {
        $parser = self::getParser();
        $marked = $parser->convert($markdown)->getContent();
        return "<div class=\"marked-down\">{$marked}</div>";
    }

    private static function getParser()
    {
        static $parser;
        if (!isset($parser))
        {
            $parser = self::createParser();
        }
        return $parser;
    }

    private static function createParser()
    {
        spl_autoload_register([self::class, 'autoload']);

        $config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => '',
                'apply_id_to_heading' => false,
                'heading_class' => '',
                'fragment_prefix' => '',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => HeadingPermalinkRenderer::DEFAULT_SYMBOL,
                'aria_hidden' => true,
            ],
        ];

        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $converter = new MarkdownConverter($environment);
        return $converter;
    }

    /**
     * Autoloader shim for commonmark without composer
     */
    public static function autoload($classname)
    {
        if ($path = Common::substrFrom($classname, 'League\\CommonMark\\'))
        {
            $path = GWF_CORE_PATH . 'inc/3p/commonmark/src/' . str_replace('\\', '/', $path) . '.php';
            require $path;
        }
        elseif ($path = Common::substrFrom($classname, 'League\\Config\\'))
        {
            $path = GWF_CORE_PATH . 'inc/3p/config/src/' . str_replace('\\', '/', $path) . '.php';
            require $path;
        }
        elseif ($path = Common::substrFrom($classname, 'Psr\\EventDispatcher\\'))
        {
            $path = GWF_CORE_PATH . 'inc/3p/event-dispatcher/src/' . str_replace('\\', '/', $path) . '.php';
            require $path;
        }
        elseif ($path = Common::substrFrom($classname, 'Nette\\Schema\\'))
        {
            $path = GWF_CORE_PATH . 'inc/3p/schema/src/Schema/' . str_replace('\\', '/', $path) . '.php';
            require $path;
        }
        elseif ($path = Common::substrFrom($classname, 'Nette\\'))
        {
            $path = GWF_CORE_PATH . 'inc/3p/utils/src/' . str_replace('\\', '/', $path) . '.php';
            require $path;
        }
        elseif ($path = Common::substrFrom($classname, 'Dflydev\\DotAccessData\\'))
        {
            $path = GWF_CORE_PATH . 'inc/3p/dflydev-dot-access-data/src/' . str_replace('\\', '/', $path) . '.php';
            require $path;
        }
        else
        {
            echo $classname;
        }
    }

}