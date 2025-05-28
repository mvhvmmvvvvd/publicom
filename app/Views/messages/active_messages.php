```

---


<h1>Messages Actifs</h1>
<ul>
    <?php foreach ($messages as $message): ?>
        <li>
            <strong><?= $message['TEXTE'] ?></strong>
            (Expire le <?= $message['date_fin'] ?>)
        </li>
    <?php endforeach; ?>
</ul>