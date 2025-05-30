<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Ajouter un Message</h1>

<form action="/messages/create" method="post">
    <!-- <label for="REFERENCE">Panneau</label>
    <select name="REFERENCE" id="REFERENCE">
        <option value="">--Choisir un panneau --</option>
                    <option value=""></option>
        
    </select>  -->
    <?php

    $user = auth()->user();
    if (! $user->inGroup('admin')) {
    ?>
        <label for="IDCOMMUNE">Commune</label>
        <input type="text" id="IDCOMMUNE" name="IDCOMMUNE" value=" <?= $communeId . ' - ' . $nomCommune . ' (' . $deptNum . ')' ?> " readonly />
    <?php
    }
    else {
    ?>
    <label for="IDCOMMUNE">Panneau</label>
    <select name="IDCOMMUNE">
        <option value="">Choisissez un département</option>
        <?php
        foreach ($listeCommunes as $commune) {
            echo "<option value=" . $commune['IDCOMMUNE'] . ">" . $commune['NOM'] . " (" . $commune['DEPARTEMENT'] . ")</option>";
        }
    }
        ?>
    </select>

    <label for="ETAT">État</label>
    <select name="ETAT" id="ETAT">
        <option value="">--Choisir un état--</option>
        <option value="0">0</option>
        <option value="1">1</option>
    </select>

    <label for="texte">Texte :</label>
    <input type="text" id="texte" name="texte" required />

    <label for="couleur">Couleur :</label>
    <input type="text" id="couleur" name="couleur" required />

    <label for="taille">Taille :</label>
    <input type="number" id="taille" name="taille" required />

    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin" required />

    <button type="submit">Ajouter</button>
</form>

<?= $this->endSection() ?>