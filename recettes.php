<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

$validRecipes = getRecipes($recipes);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Douceur - Tous nos desserts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .recipe-item.hidden { display: none !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="container my-5">

        <h1 class="fw-bold mb-4">Tous nos desserts</h1>

        <!-- RECHERCHE -->
        <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0" style="border-radius:50px 0 0 50px;">🔍</span>
            <input
                type="text"
                id="searchInput"
                class="form-control border-start-0"
                placeholder="Rechercher un dessert..."
                style="border-radius:0;"
            >
            <button class="btn btn-danger" style="border-radius:0 50px 50px 0;" onclick="clearSearch()">✕</button>
        </div>

        <!-- TRI -->
        <div class="d-flex gap-2 align-items-center mb-4">
            <span class="text-muted small">Trier :</span>
            <button class="btn btn-sm btn-outline-secondary sort-btn active" onclick="setSort('recent', this)">Plus récents</button>
            <button class="btn btn-sm btn-outline-secondary sort-btn" onclick="setSort('az', this)">A-Z</button>
        </div>

        <!-- GRILLE -->
        <div class="row g-4" id="recipesGrid">
            <?php foreach ($validRecipes as $index => $recipe) :
                $excerpt = mb_substr(strip_tags($recipe['recipe']), 0, 100);
                if (mb_strlen(strip_tags($recipe['recipe'])) > 100) $excerpt .= '…';
                $isOwner = isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email'];
            ?>
            <div class="col-12 col-md-6 col-lg-4 recipe-item"
                 data-title="<?php echo strtolower(htmlspecialchars($recipe['title'])); ?>"
                 data-author="<?php echo htmlspecialchars($recipe['author']); ?>"
                 data-mine="<?php echo $isOwner ? 'true' : 'false'; ?>"
                 data-index="<?php echo $index; ?>">
                <div class="card recipe-card">
                    <?php if (!empty($recipe['image'])) : ?>
                        <img src="<?php echo htmlspecialchars($recipe['image']); ?>"
                             alt="<?php echo htmlspecialchars($recipe['title']); ?>"
                             class="card-img-top"
                             style="height:180px; object-fit:cover; border-radius:10px 10px 0 0;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                        <div class="mb-2">
                            <span class="author-badge">👤 <?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?></span>
                        </div>
                        <p class="excerpt flex-grow-1"><?php echo htmlspecialchars($excerpt); ?></p>
                        <div class="d-flex gap-2 mt-auto flex-wrap">
                            <a href="recipes_read.php?id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-danger btn-sm">
                                Voir le dessert
                            </a>
                            <?php if ($isOwner) : ?>
                                <a href="recipes_update.php?id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-warning btn-sm">✏️ Éditer</a>
                                <a href="recipes_delete.php?id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-outline-danger btn-sm">🗑️</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Aucun résultat -->
        <div id="noResults" class="text-center py-5 d-none">
            <div style="font-size:3rem;">🔍</div>
            <p class="text-muted">Aucun dessert trouvé.</p>
        </div>

        <!-- PAGINATION -->
        <nav class="mt-5" aria-label="Pagination">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>

    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const PER_PAGE  = 6;
        let currentPage = 1;
        let currentSort = 'recent';
        let currentSearch = '';

        function getItems() {
            return Array.from(document.querySelectorAll('.recipe-item'));
        }

        function applyFilters() {
            const items = getItems();
            let visible = items.filter(item => {
                if (currentSearch && !item.dataset.title.includes(currentSearch.toLowerCase())) return false;
                return true;
            });

            visible.sort((a, b) => {
                if (currentSort === 'az') return a.dataset.title.localeCompare(b.dataset.title);
                return parseInt(a.dataset.index) - parseInt(b.dataset.index);
            });

            const total      = visible.length;
            const totalPages = Math.ceil(total / PER_PAGE);
            if (currentPage > totalPages) currentPage = 1;
            const start = (currentPage - 1) * PER_PAGE;
            const end   = start + PER_PAGE;

            items.forEach(i => i.classList.add('hidden'));
            const grid = document.getElementById('recipesGrid');
            visible.forEach((item, idx) => {
                grid.appendChild(item);
                if (idx >= start && idx < end) item.classList.remove('hidden');
            });

            document.getElementById('noResults').classList.toggle('d-none', total > 0);
            renderPagination(totalPages);
        }

        function renderPagination(totalPages) {
            const ul = document.getElementById('pagination');
            ul.innerHTML = '';
            if (totalPages <= 1) return;

            addPageBtn(ul, '‹', () => { if (currentPage > 1) { currentPage--; applyFilters(); } }, currentPage === 1);
            for (let i = 1; i <= totalPages; i++) {
                const p = i;
                addPageBtn(ul, i, () => { currentPage = p; applyFilters(); }, false, i === currentPage);
            }
            addPageBtn(ul, '›', () => { if (currentPage < totalPages) { currentPage++; applyFilters(); } }, currentPage === totalPages);
        }

        function addPageBtn(ul, label, handler, disabled = false, active = false) {
            const li = document.createElement('li');
            li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
            li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
            li.addEventListener('click', e => { e.preventDefault(); handler(); });
            ul.appendChild(li);
        }

        function setSort(sort, btn) {
            currentSort = sort; currentPage = 1;
            document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
            applyFilters();
        }

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            currentSearch = ''; currentPage = 1;
            applyFilters();
        }

        document.getElementById('searchInput').addEventListener('input', function () {
            currentSearch = this.value.trim(); currentPage = 1;
            applyFilters();
        });

        applyFilters();
    </script>
</body>
</html>
