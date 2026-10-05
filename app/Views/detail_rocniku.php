<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Ročník <?= esc($rocnik['year']) ?> | Paříž - Nice</title>
    <link rel="stylesheet" href="<?= base_url('public/styles.css') ?>">
</head>
<body>

    <a href="<?= base_url('index.php/cyklo') ?>" class="btn-back">&larr; Zpět na přehled ročníků</a>

    <div class="rocnik-card">
        <div class="rocnik-header">
            <h1 class="rocnik-titulek">
                Ročník <?= esc($rocnik['year']) ?> 
                (<?= !empty($rocnik['start_date']) ? date('d.m.Y', strtotime($rocnik['start_date'])) : '' ?> – 
                 <?= !empty($rocnik['end_date']) ? date('d.m.Y', strtotime($rocnik['end_date'])) : '' ?>)
            </h1>

            <?php 
                $logo = trim($rocnik['logo'] ?? '');
                if (!empty($logo) && !preg_match('/\.(png|jpg|jpeg|gif|svg)$/i', $logo)) {
                    $logo .= '.png'; 
                }
            ?>

            <?php if (!empty($logo)): ?>
                <img src="<?= base_url('logos/' . $logo) ?>" 
                     alt="Logo <?= esc($rocnik['year']) ?>" 
                     class="rocnik-logo"
                     onerror="if(this.src.endsWith('.png')){ this.src=this.src.replace('.png','.jpg'); } else { this.style.display='none'; }">
            <?php endif; ?>
        </div>

        <h2>Etapy ročníku</h2>
        <?php if (!empty($rocnik['etapy'])): ?>
            <table class="tabulka-etap">
                <thead>
                    <tr>
                        <th>Pořadí</th>
                        <th>Datum</th>
                        <th>Délka</th>
                        <th>Převýšení</th>
                        <th>Typ etapy</th>
                        <th>Vítěz etapy</th>
                        <th>Výsledky</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rocnik['etapy'] as $etapa): ?>
                        <tr>
                            <td><?= esc($etapa['number']) ?>. etapa</td>
                            <td><?= !empty($etapa['date']) ? date('d.m.Y', strtotime($etapa['date'])) : '---' ?></td>
                            <td><?= esc($etapa['distance']) ?> km</td>
                            <td><?= esc($etapa['vertical_meters'] ?? '---') ?> m</td>
                            <td><?= esc($etapa['typ_etapy'] ?: '---') ?></td>
                            <td>
                                <?= !empty($etapa['vitez_prijmeni']) ? esc($etapa['vitez_jmeno'] . ' ' . $etapa['vitez_prijmeni']) : '---' ?>
                            </td>
                            <td>
                                <a href="<?= base_url('index.php/cyklo/vysledky/' . $etapa['id'] . '/1') ?>" class="btn-link">V etapě</a> | 
                                <a href="<?= base_url('index.php/cyklo/vysledky/' . $etapa['id'] . '/4') ?>" class="btn-link">Po etapě</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><em>Pro tento ročník nejsou evidovány žádné etapy.</em></p>
        <?php endif; ?>
    </div>

</body>
</html>