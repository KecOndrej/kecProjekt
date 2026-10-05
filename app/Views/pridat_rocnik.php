<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přidat nový ročník</title>
    <link rel="stylesheet" href="<?= base_url('public/styles.css') ?>">
</head>
<body>

    <div class="card">
        <h2>Přidat nový ročník</h2>
        <form action="<?= base_url('index.php/cyklo/ulozitRocnik') ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="id_race">Závod (Muži, kategorie E):</label>
                <select id="id_race" name="id_race" required>
                    <?php foreach ($zavody as $zavod): ?>
                        <option value="<?= esc($zavod['id']) ?>"><?= esc($zavod['base_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="real_name">Oficiální název ročníku (real_name):</label>
                <input type="text" id="real_name" name="real_name" placeholder="např. Paris - Nice 2025" required>
            </div>

            <div class="form-group">
                <label for="year">Rok:</label>
                <input type="number" id="year" name="year" value="2025" required>
            </div>

            <div class="form-group">
                <label for="start_date">Datum začátku:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">Datum konce:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>

            <div class="form-group">
                <label for="logo">Logo závodu:</label>
                <input type="file" id="logo" name="logo" accept="image/*">
            </div>

            <button type="submit" class="btn">Uložit ročník</button>
            <a href="<?= base_url('index.php/cyklo') ?>" class="btn btn-secondary">Zpět</a>
        </form>
    </div>

</body>
</html>