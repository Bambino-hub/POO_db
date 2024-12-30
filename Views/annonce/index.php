<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Page d'acceuil des annonces </p>
    <?php foreach ($annonces as $annonce) : ?>
        <article>
            <h2> <a href="index.php?p=annonce/lire/<?= $annonce->id ?>"><?= $annonce->titre ?></a></h2>
            <div><?= $annonce->description ?></div>
        </article>

    <?php endforeach; ?>
</body>

</html>