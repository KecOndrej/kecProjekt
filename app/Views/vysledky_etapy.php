<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title><?= esc($typ) ?></title>
    <link rel="stylesheet" href="<?= base_url('public/styles.css') ?>">
</head>
<body>

    <div class="card">
        <a href="<?= base_url('index.php/cyklo') ?>" class="btn-back">&larr; Zpět na přehled</a>
        <h2><?= esc($typ) ?></h2>

        <?php if (!empty($vysledky)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Pozice</th>
                        <th>Jezdec</th>
                        <th>Čas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vysledky as $vysledeok): ?>
                        <tr>
                            <td><?= esc($vysledeok['rank']) ?>.</td>
                            <td><?= esc($vysledeok['first_name'] . ' ' . $vysledeok['last_name']) ?></td>
                            <td><?= esc($vysledeok['time'] ?: '---') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Pro tuto etapu nejsou k dispozici žádné výsledky.</p>
        <?php endif; ?>
    </div>

</body>
</html>