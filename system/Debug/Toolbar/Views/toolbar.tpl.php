<?php

declare(strict_types=1);

use CodeIgniter\Debug\Toolbar;
use CodeIgniter\View\Parser;

/**
 * @var Toolbar $this
 * @var int     $totalTime
 * @var int     $totalMemory
 * @var string  $url
 * @var string  $method
 * @var bool    $isAJAX
 * @var int     $startTime
 * @var int     $totalTime
 * @var int     $totalMemory
 * @var float   $segmentDuration
 * @var int     $segmentCount
 * @var string  $CI_VERSION
 * @var array   $collectors
 * @var array   $vars
 * @var array   $styles
 * @var Parser  $parser
 */
?>
<style>
    <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . '/toolbar.css')) ?>
</style>

<script id="toolbar_js">
    var ciSiteURL = "<?= rtrim(site_url(), '/') ?>"
    <?= file_get_contents(__DIR__ . '/toolbar.js') ?>
</script>
<style>
    <?php foreach ($styles as $name => $style): ?><?= sprintf(".%s { %s }\n", $name, $style) ?><?php endforeach ?>
</style>