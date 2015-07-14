<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Legend Admin</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="margin-top: 50px;">
    <div class="container">
        <div class="col-xs-6">
            <h2>Web tools</h2>

            <div class="list-group">
                <a href=//php.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">PHP</h4>

                    <p class="list-group-item-text">
                        PHP <?= Info::phpVersion() ?>
                    </p>
                </a>
                <a href=//mysql.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">MySQL</h4>

                    <p class="list-group-item-text">
                        <?= Info::mysqlVersion() ?>
                    </p>
                </a>
                <a href=//mongo.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">MongoDB</h4>

                    <p class="list-group-item-text">
                        <?= Info::mongodbVersion() ?>
                    </p>
                </a>
                <a href=//redis.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">Redis</h4>

                    <p class="list-group-item-text">
                        <?= Info::redisVersion() ?>
                    </p>
                </a>
                <a href=//rabbitmq.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">RabbitMQ</h4>

                    <p class="list-group-item-text">
                        <?= Info::rabbitmqVersion() ?>
                        <code>guest:guest</code>
                    </p>
                </a>
                <a href=//mail.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">Mailcatcher</h4>

                    <p class="list-group-item-text">
                        <?= Info::mailcatcherVersion() ?>
                    </p>
                </a>
                <a href=//xhprof.dev.localhost class="list-group-item">
                    <h4 class="list-group-item-heading">XHProf</h4>

                    <p class="list-group-item-text text-muted">
                        <em>Coming soon!</em>
                    </p>
                </a>
            </div>
        </div>
        <div class="col-xs-6">
            <h2>CLI tools</h2>
            <ul>
                <li><a target="_blank" href="http://wp-cli.org/">Composer</a> <code>composer</code></li>
                <li><a target="_blank" href="https://phpunit.de/">PHPUnit</a> <code>phpunit</code></li>
                <li><a target="_blank" href="https://github.com/borisrepl/boris">Boris</a> <code>boris</code></li>
                <li><a target="_blank" href="http://wp-cli.org/">WP-CLI</a> <code>wp</code></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
<?php

class Info
{
    public static function phpVersion()
    {
        return self::aptInfo('php5-cli')['version'];
    }

    public static function mysqlVersion()
    {
        return self::aptInfo('mysql-server-5.6')['version'];
    }

    public static function mongodbVersion()
    {
        return self::aptInfo('mongodb')['version'];
    }

    public static function redisVersion()
    {
        return self::aptInfo('redis-server')['version'];
    }

    public static function rabbitmqVersion()
    {
        return self::aptInfo('rabbitmq-server')['version'];
    }

    public static function mailcatcherVersion()
    {
        return self::gemInfo('mailcatcher')['version'];
    }

    private static function aptInfo($package)
    {
        $cmd    = sprintf('apt-cache policy %s', escapeshellarg($package));
        $output = shell_exec($cmd);
        preg_match('{Installed: (?<version>.*$).*Candidate: (?<update>)}ms', $output, $matches);

        return $matches;
    }

    private static function gemInfo($package)
    {
        $cmd    = sprintf('gem list %s', escapeshellarg("^$package$"));
        $output = shell_exec($cmd);
        preg_match(sprintf('{^%s \((?<version>.*)\)$}', preg_quote($package)), $output, $matches);

        return $matches;
    }
}
