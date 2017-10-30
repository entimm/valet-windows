<html>
    <head>
        <title>Valet - List - <?php echo htmlspecialchars($siteName . '.' . $valetConfig['domain']); ?></title>

        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                font-size: 25px;
                font-weight: 200;
            }

            h1 {
                font-size: 50px;
                font-weight: 200;
            }

            h2 {
                font-weight: 200;
            }

            a {
                color: #fff;
                text-decoration: none;
            }

            span {
                background: #000;
                color: #fff;
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 5px;
                padding-top: 5px;
            }
        </style>
    </head>
    <body>
        <div>
            <h1>File Index <span><?php echo htmlspecialchars($valetSitePath . str_replace('/', '\\', $_SERVER['REQUEST_URI'])); ?></span></h1>
            <?php foreach(glob($valetSitePath . str_replace('/', '\\', $_SERVER['REQUEST_URI']) . '/*') as $file): ?>
                <p><span><a href="./<?php echo basename($file).(is_dir($file) ? '/' : ''); ?>"><?php echo htmlspecialchars(basename($file)); ?></a></span></p>
            <?php endforeach; ?>
        </div>
    </body>
</html>
