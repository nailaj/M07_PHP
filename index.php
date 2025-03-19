<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/activity-template-style.css">

    <title>Read dir PHP</title>

    <meta name="color-scheme" content="dark light">

    
</head>
<body>
    <header>
        <div class="header-content">
            <a href="https://itecbcn.eu" target="_blank" rel="noopener"><img src="img/itb-logo.webp" alt="logo ITB" /></a>
            <strong>&lt;Ulises Castell i Carlos Capó&gt;</strong>
        </div>
    </header>

    <main>
        <div class="main-content">
            <div>
                <h1>Continguts del projecte</h1>
        
                <form id="filterForm">
                    <select name="filter" id="filter">
                        <option value="none">-- Selecciona un filtre</option>
                        <option value="folder-filter">No mostrar carpetes</option>
                        <option value="file-filter">No mostrar fitxers</option>
                    </select>
                    <button type="submit">Filtrar</button>
                </form>
            </div>
    
            <nav>
                <?php
                    $dirPath = "./";
                    $files = [];
                    $excluded = ["README.md", "index.php", "html", "css", "img"]; // Elements a excloure

                    // Obre el directori i recull els fitxers
                    if ($handle = opendir($dirPath)) {
                        while (false !== ($file = readdir($handle))) {
                            if (!in_array($file, $excluded) && !str_starts_with($file, ".")) {
                                $files[] = $file; // Guarda els noms dels fitxers i carpetes
                            }
                        }
                        closedir($handle);
                    }

                    // Ordena els fitxers alfabèticament
                    sort($files, SORT_NATURAL | SORT_FLAG_CASE);                    

                    // Processa els fitxers ordenats
                    foreach ($files as $file) {
                        if (is_dir($file)) {
                            echo "<details name='folder-content' class='folder-filter'>";
                            echo "<summary class='page-card folder'>$file</summary>";
                            echo "<ul>";
                            
                            $subfiles = array_diff(scandir($file), array('.', '..'));
                            foreach ($subfiles as $subfile) {
                                echo "<li><a href='./$file/$subfile' target='_BLANK'>$subfile</a></li>";
                            }

                            echo "</ul>";
                            echo "</details>";
                        } else {
                            echo "<a href='$file' class='page-card file file-filter'>$file</a>";
                        }
                    }

                    clearstatcache();

                ?>
            </nav>
        </div>
    </main>


    <?php
        include("html/activity-template-footer.html");
    ?>

    <script>
        const filterForm = document.getElementById("filterForm")
        filterForm.addEventListener("submit", (e) => {
            e.preventDefault()
            resetFilter()

            const filter = document.getElementById("filter").value

            if (filter == "none") return

            const elementsToHide = document.getElementsByClassName(filter)
            for (e of elementsToHide) {
                e.style.display = "none"
            }
        })

        function resetFilter() {
            const folders = document.getElementsByClassName("folder-filter")
            const files = document.getElementsByClassName("file-filter")
            for (e of folders) {
                e.style.display = "flex"
            }
            for (e of files) {
                e.style.display = "flex"
            }
        }
    </script>
</body>
</html>