<?php declare(strict_types = 1);

namespace MailPoet\Premium\Config;

if (!defined('ABSPATH')) exit;


use MailPoet\Config\TwigEnvironment;
use MailPoet\Config\TwigFileSystemCache;
use MailPoet\Twig;
use MailPoet\WP\Functions as WPFunctions;
use MailPoetVendor\Twig\Environment as TwigEnv;
use MailPoetVendor\Twig\Extension\DebugExtension;
use MailPoetVendor\Twig\Lexer as TwigLexer;
use MailPoetVendor\Twig\Loader\FilesystemLoader as TwigFileSystem;

class Renderer {
  protected $cachePath;
  protected $cachingEnabled;
  protected $debuggingEnabled;
  protected $renderer;
  public $assetsManifestJs;
  public $assetsManifestCss;

  public function __construct(
    $cachingEnabled = false,
    $debuggingEnabled = false,
    $autoReload = false
  ) {
    $this->cachingEnabled = $cachingEnabled;
    $this->debuggingEnabled = $debuggingEnabled;
    $this->cachePath = Env::$cachePath;

    $fileSystem = new TwigFileSystem(Env::$viewsPath);
    $this->renderer = new TwigEnvironment(
      $fileSystem,
      [
        'cache' => new TwigFileSystemCache($this->cachePath),
        'debug' => $this->debuggingEnabled,
        'auto_reload' => $autoReload,
      ]
    );

    $this->assetsManifestJs = $this->getAssetManifest(Env::$assetsPath . '/dist/js/manifest.json');
    $this->assetsManifestCss = $this->getAssetManifest(Env::$assetsPath . '/dist/css/manifest.json');

    $this->setupDebug();
    $this->setupTranslations();
    $this->setupFunctions();
    $this->setupFilters();
    $this->setupHandlebars();
    $this->setupHelpscout();
    $this->setupGlobalVariables();
    $this->setupSyntax();
  }

  public function getTwig(): TwigEnv {
    return $this->renderer;
  }

  public function setupTranslations() {
    $this->renderer->addExtension(new Twig\I18n(Env::$pluginName));
  }

  public function setupFunctions() {
    $this->renderer->addExtension(new Twig\Functions());
  }

  public function setupHandlebars() {
    $this->renderer->addExtension(new Twig\Handlebars());
  }

  public function setupHelpscout() {
    $this->renderer->addExtension(new Twig\Helpscout());
  }

  public function setupFilters() {
    $this->renderer->addExtension(new Twig\Filters());
  }

  public function setupGlobalVariables() {
    $this->renderer->addExtension(
      new Twig\Assets(
        [
          'version' => Env::$version,
          'assets_url' => Env::$assetsUrl,
          'assets_manifest_js' => $this->assetsManifestJs,
          'assets_manifest_css' => $this->assetsManifestCss,
        ],
        WPFunctions::get()
      )
    );
  }

  public function setupSyntax() {
    $lexer = new TwigLexer($this->renderer, [
      'tag_comment' => ['<#', '#>'],
      'tag_block' => ['<%', '%>'],
      'tag_variable' => ['<%=', '%>'],
      'interpolation' => ['%{', '}'],
    ]);
    $this->renderer->setLexer($lexer);
  }

  public function setupDebug() {
    if ($this->debuggingEnabled) {
      $this->renderer->addExtension(new DebugExtension());
    }
  }

  public function render($template, $context = []) {
    try {
      return $this->renderer->render($template, $context);
    } catch (\RuntimeException $e) {
      throw new \Exception(sprintf(
        // translators: %1$s is the name of the template, %2$s the path to the cache folder and %3$s the error message.
        __(
          'Failed to render template "%1$s". Please ensure the template cache folder "%2$s" exists and has write permissions. Terminated with error: "%3$s"',
          'mailpoet-premium'
        ),
        $template,
        $this->cachePath,
        $e->getMessage()
      ));
    }
  }

  public function addGlobal($key, $value) {
    $this->renderer->addGlobal($key, $value);
  }

  public function getAssetManifest($manifestFile) {
    if (is_readable($manifestFile)) {
      $contents = file_get_contents($manifestFile);
      if (is_string($contents)) {
        return json_decode($contents, true);
      }
    }
    return false;
  }

  public function getJsAsset($asset) {
    return (!empty($this->assetsManifestJs[$asset])) ?
      $this->assetsManifestJs[$asset] :
      $asset;
  }
}
