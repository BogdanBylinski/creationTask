<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Failo duomenų nuskaitymas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1 class="site-title">Failo duomenų nuskaitymas</h1>
    </div>
</header>

<main class="container page">
    <section class="card glass">
        <h2 class="section-title">Įkėlimas</h2>
        <p class="description">Palaikomi formatai: <strong>CSV</strong>, <strong>XML</strong>, <strong>JSON</strong>.
            Maks. dydis ~2 MB.</p>

        <form action="" method="post" enctype="multipart/form-data" class="upload-form">
            <label for="data_file" class="dropzone" aria-describedby="file_help">
                <svg aria-hidden="true" class="dz-icon" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="currentColor"
                          d="M19 15v4H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4zM11 16h2V8l3.5 3.5 1.42-1.42L12 4.66 6.08 10.08 7.5 11.5 11 8z"/>
                </svg>
                <div class="dz-text">
                    <span class="dz-title" aria-live="polite" aria-atomic="true">Pridėti failą</span>
                    <span class="dz-sub">arba paspausk, kad pasirinktum</span>
                    <span class="dz-accept">Leidžiama: .csv, .xml, .json</span>
                </div>
                <input
                        class="file-input"
                        type="file"
                        name="data_file"
                        id="data_file"
                        accept=".csv,.xml,.json"
                >
            </label>

            <div class="actions">
                <button type="submit" class="btn primary">Įkelti failą</button>
            </div>
        </form>

        <?php if (!empty($errors)): ?>
            <div class="alert error" role="alert">
                <strong>Klaida.</strong>
                <ul class="alert-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>

    <?php if (!empty($table)): ?>
        <section class="card glass result">
            <div class="section-head">
                <h2 class="section-title">Failo duomenys</h2>
                <a href="/" class="btn subtle">↺ Įkelti kitą</a>
            </div>
            <?php echo $table; ?>
        </section>
    <?php endif; ?>
</main>


<script>
    (function () {
        const fileInputElement = document.getElementById('data_file');
        const dropzoneElement = document.querySelector('.dropzone');
        const dropzoneTitleElement = document.querySelector('.dz-title');
        if (!fileInputElement || !dropzoneElement || !dropzoneTitleElement) return;
        const defaultDropzoneTitle = dropzoneTitleElement.textContent;

        function getBaseName(filePath) {
            return filePath.split(/[\\\//]/).pop();
        }

        function updateDropzoneTitle() {
            const selectedFile = fileInputElement.files && fileInputElement.files[0];
            if (selectedFile) {
                dropzoneTitleElement.textContent = selectedFile.name;
                dropzoneElement.classList.add('is-selected');
            } else {
                const fileNameFromValue = fileInputElement.value ? getBaseName(fileInputElement.value) : '';
                if (fileNameFromValue) {
                    dropzoneTitleElement.textContent = fileNameFromValue;
                    dropzoneElement.classList.add('is-selected');
                } else {
                    dropzoneTitleElement.textContent = defaultDropzoneTitle;
                    dropzoneElement.classList.remove('is-selected');
                }
            }
        }

        fileInputElement.addEventListener('change', updateDropzoneTitle);
        updateDropzoneTitle();
    })();
</script>
</body>
</html>
