<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Paříž - Nice</title>
    <link rel="stylesheet" href="<?= base_url('public/styles.css') ?>">
</head>
<body>

    <div class="top-bar">
        <h1>Paříž - Nice (race_id 124)</h1>
        <a href="<?= base_url('index.php/cyklo/pridatRocnik') ?>" class="btn-add">+ Přidat nový ročník</a>
    </div>

    <?php if (!empty($rocniky)): ?>
        <?php foreach ($rocniky as $rocnik): ?>
            <div class="rocnik-card">
                <div class="rocnik-header">
                    <h2 class="rocnik-titulek">
                        <a href="<?= base_url('index.php/cyklo/detailRocniku/' . $rocnik['id']) ?>" class="btn-link" style="font-size: 22px;">
                            Ročník <?= esc($rocnik['year']) ?> 
                            (<?= !empty($rocnik['start_date']) ? date('d.m.Y', strtotime($rocnik['start_date'])) : '' ?> – 
                             <?= !empty($rocnik['end_date']) ? date('d.m.Y', strtotime($rocnik['end_date'])) : '' ?>)
                        </a>
                    </h2>

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

                <p><strong>Celková délka závodu:</strong> <?= esc($rocnik['celkova_delka'] ?: 0) ?> km</p>
                <p>
                    <a href="<?= base_url('index.php/cyklo/detailRocniku/' . $rocnik['id']) ?>" class="btn">Zobrazit etapy ročníku &rarr;</a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Žádné ročníky nebyly nalezeny.</p>
    <?php endif; ?>

</body>
</html>