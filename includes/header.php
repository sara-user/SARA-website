<?php $activePage = $activePage ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>SARA</title>
    <link rel="stylesheet" href="/css/styles.css"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">

</head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YYVJCY1FT4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YYVJCY1FT4');
</script>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/index.php" title="Suburban Amateur Repeater Association">SARA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-pills mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/history.php">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" <?php if ($activePage === 'home') echo 'active'; ?> href="/repeaters.php">Repeaters</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nets.php">Nets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact.php" <?php if ($activePage === 'contact') echo 'active'; ?>>Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main>
