<style>
    .modal-body-scrollable {
        max-height: 400px;
        /* Adjust the height as needed */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .quill-editor-full {
        height: 200px;
        /* Adjust the height of the Quill editor */
    }
</style>
<script type="text/javascript" src="../bootstrap/ckeditor5/ckeditor5.js"></script>

<?php
// include properti
include('view/templates/header.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Menu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Menu</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Isi Tambah -->
    <div class="card-body larger-card-body">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form id="addMenuForm" action="view/backend/addsubmenu.php" method="post" enctype="multipart/form-data">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Submenu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-scrollable">
                            <?php
                            include '../databases/database.php';
                            $data = mysqli_query($koneksi, "SELECT * FROM menu;");
                            ?>

                            <div class="row mb-3">
                                <label for="id_menu" class="col-sm-2 col-form-label">Menu Name <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <select id="id_menu" class="form-select" name="id_menu" required>
                                        <option selected disabled>Choose...</option>
                                        <?php while ($row = mysqli_fetch_array($data)) { ?>
                                            <option value="<?php echo $row['id_menu']; ?>">
                                                <?php echo $row['menu_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="submenu_code" class="col-sm-2 col-form-label">Submenu Code <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="submenu_code" name="submenu_code"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="submenu_name" class="col-sm-2 col-form-label">Submenu Name <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="submenu_name" name="submenu_name"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-sm-2 col-form-label">Image <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <!-- Quill Editor Container -->
                                    <div id="description"></div>
                                </div>
                            </div>

                            <br>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Quill stylesheet and JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Initialize Quill editor
        let quill;
        let isQuillInitialized = false; // Flag to check if Quill is initialized
        var myModalEl = document.getElementById('exampleModal');

        myModalEl.addEventListener('shown.bs.modal', function () {
            // Initialize Quill only if it hasn't been initialized yet
            if (!isQuillInitialized) {
                quill = new Quill('#description', {
                    modules: {
                        toolbar: [
                            ['bold', 'italic'],
                            ['link', 'blockquote', 'code-block', 'image'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                        ],
                    },
                    theme: 'snow',
                });
                isQuillInitialized = true; // Set the flag to true after initialization
            }
        });

        // Handle form submission
        document.getElementById('addMenuForm').addEventListener('submit', function (e) {
            // Prevent default form submission if you want to handle it differently
            e.preventDefault();

            // Get the content from the Quill editor
            const description = quill.root.innerHTML;

            // Set up the hidden input for the form submission
            const descriptionInput = document.createElement('input');
            descriptionInput.type = 'hidden';
            descriptionInput.name = 'description';
            descriptionInput.value = description;

            // Append the hidden input to the form
            this.appendChild(descriptionInput);

            // Now submit the form
            this.submit(); // Uncomment this line to submit the form normally
        });
    </script>


    <!-- Akhir -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Row for entries per page and search bar with top margin -->
                        <div class="d-flex justify-content-between mb-3 mt-3">
                            <!-- Dropdown for entries per page -->
                            <div>
                                Show<label for="entries_per_page" class="me-2"></label>
                                <select id="entries_per_page" class="form-select d-inline-block w-auto">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select> entries per page
                            </div>

                            <!-- Search bar and button in a flex container -->
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control me-2" id="search" placeholder="Search..."
                                    aria-label="Search">
                                <button type="button" class="btn btn-primary w-75" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    + Add Submenu
                                </button>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Menu</th>
                                    <th>Submenu Code</th>
                                    <th>Submenu Name</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Time Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../databases/database.php';

                                // Get the entries per page from the URL or set a default
                                $entries_per_page = isset($_GET['entries_per_page']) ? (int) $_GET['entries_per_page'] : 10;

                                // Get the current page from the URL or set it to 1
                                $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

                                // Calculate the offset for the SQL query
                                $offset = ($current_page - 1) * $entries_per_page;

                                // Count total records for pagination
                                $total_result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM submenu");
                                $total_rows = mysqli_fetch_assoc($total_result)['total'];
                                $total_pages = ceil($total_rows / $entries_per_page);

                                // Fetch menu data with pagination
                                $data = mysqli_query($koneksi, "SELECT submenu.*, login.nama_lengkap FROM submenu LEFT JOIN login ON submenu.modified_by = login.id_login ORDER BY timestamp DESC LIMIT $offset, $entries_per_page");

                                $nomor = $offset + 1; // To display the correct number
                                while ($row = mysqli_fetch_array($data)) { ?>
                                    <tr>
                                        <td><?php echo $nomor++; ?></td>
                                        <td><?php echo htmlspecialchars($row['menu_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['submenu_code']); ?></td>
                                        <td><?php echo htmlspecialchars($row['submenu_name']); ?></td>
                                        <td>
                                            <img src="../bootstrap/assets/img/submenu/<?php echo htmlspecialchars($row['image']); ?>"
                                                alt="<?php echo htmlspecialchars($row['image']); ?>"
                                                style="width: 50px; height: auto;">
                                        </td>
                                        <td>
                                            <?php
                                            // Process description and output
                                            $descriptionHtml = '<p>' . htmlspecialchars($row['description']) . '</p>';
                                            $dom = new DOMDocument();
                                            libxml_use_internal_errors(true); // Suppress warnings from malformed HTML
                                            $dom->loadHTML($descriptionHtml);
                                            libxml_clear_errors();

                                            $text = '';
                                            foreach ($dom->getElementsByTagName('p') as $p) {
                                                $content = trim($p->textContent);
                                                if (!empty($content)) {
                                                    $text .= $content . ' ';
                                                }
                                            }
                                            echo trim($text);
                                            ?>
                                        </td>

                                        <td data-type="date" data-format="MM/DD/YYYY">
                                            <?php echo htmlspecialchars($row['timestamp']); // Ensure $timestamp is defined ?>
                                        </td>
                                        <td>
                                            <!-- Edit Menu Icon -->
                                            <i class="bi bi-pencil" data-bs-toggle="modal"
                                                data-bs-target="#editModal_<?php echo $row['id']; ?>"></i>

                                            <!-- Modal for each menu -->
                                            <div class="modal fade" id="editModal_<?php echo $row['id']; ?>" tabindex="-1"
                                                aria-labelledby="editModalLabel_<?php echo $row['id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel_<?php echo $row['id']; ?>">Edit Submenu
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="view/backend/editsubmenu.php" method="post"
                                                            enctype="multipart/form-data"
                                                            id="editMenuForm_<?php echo $row['id']; ?>">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <?php
                                                                    $menus = mysqli_query($koneksi, "SELECT * FROM menu;");
                                                                    $menuId = $row['id'];
                                                                    $menuName = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$menuId';");
                                                                    ?>
                                                                    <div class="col-sm-12">
                                                                        <select id="id_role" class="form-select"
                                                                            name="id_role" required>
                                                                            <option
                                                                                value="<?php echo $menuName->fetch_assoc(); ?>">
                                                                                <?php echo htmlspecialchars($menuName->fetch_assoc()); ?>
                                                                            </option>
                                                                            <?php while ($role = mysqli_fetch_array($menus)) { ?>
                                                                                <option value="<?php echo $role['id_menu']; ?>">
                                                                                    <?php echo htmlspecialchars($role['menu_name']); ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="submenu_code_<?php echo $row['id']; ?>"
                                                                        class="form-label">Submenu Code <span
                                                                            class="mandatory-icon">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        id="submenu_code_<?php echo $row['id']; ?>"
                                                                        name="menu_name"
                                                                        value="<?php echo htmlspecialchars($row['submenu_code']); ?>"
                                                                        required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="submenu_name_<?php echo $row['id']; ?>"
                                                                        class="form-label">Menu Name <span
                                                                            class="mandatory-icon">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        id="submenu_name_<?php echo $row['id']; ?>"
                                                                        name="menu_name"
                                                                        value="<?php echo htmlspecialchars($row['submenu_name']); ?>"
                                                                        required>
                                                                </div>

                                                                <?php
                                                                // Process description and output
                                                                $descriptionHtml = '<p>' . htmlspecialchars($row['description']) . '</p>';
                                                                $dom = new DOMDocument();
                                                                libxml_use_internal_errors(true); // Suppress warnings from malformed HTML
                                                                $dom->loadHTML($descriptionHtml);
                                                                libxml_clear_errors();

                                                                $text = '';
                                                                foreach ($dom->getElementsByTagName('p') as $p) {
                                                                    $content = trim($p->textContent);
                                                                    if (!empty($content)) {
                                                                        $text .= $content . ' ';
                                                                    }
                                                                }
                                                                ?>

                                                                <div class="mb-3">
                                                                    <label for="description_<?php echo $row['id']; ?>"
                                                                        class="form-label">Description</label>
                                                                    <div id="description_<?php echo $row['id']; ?>"
                                                                        class="quill-editor"
                                                                        aria-label="Description editor"></div>
                                                                </div>

                                                                <!-- Include Quill stylesheet and JS -->
                                                                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css"
                                                                    rel="stylesheet">
                                                                <script
                                                                    src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

                                                                <script>
                                                                    // Initialize Quill editor
                                                                    const quill_<?php echo $row['id']; ?> = new Quill('#description_<?php echo $row['id']; ?>', {
                                                                        modules: {
                                                                            toolbar: [
                                                                                ['bold', 'italic', 'underline'],
                                                                                ['link', 'image', 'blockquote'],
                                                                                [{ list: 'ordered' }, { list: 'bullet' }],
                                                                            ],
                                                                        },
                                                                        theme: 'snow',
                                                                    });

                                                                    // Set existing description content in Quill editor
                                                                    quill_<?php echo $row['id']; ?>.root.innerHTML = `<?php echo addslashes($text); ?>`;

                                                                    // Handle form submission
                                                                    document.getElementById('editMenuForm_<?php echo $row['id']; ?>').addEventListener('submit', function (e) {
                                                                        e.preventDefault(); // Prevent default form submission

                                                                        // Create a hidden input for the Quill editor content
                                                                        const descriptionInput = document.createElement('input');
                                                                        descriptionInput.type = 'hidden';
                                                                        descriptionInput.name = 'description';
                                                                        descriptionInput.value = quill_<?php echo $row['id']; ?>.root.innerHTML;

                                                                        // Append the hidden input to the form
                                                                        this.appendChild(descriptionInput);

                                                                        // Add the menu ID as a hidden input for saving
                                                                        const idInput = document.createElement('input');
                                                                        idInput.type = 'hidden';
                                                                        idInput.name = 'id';
                                                                        idInput.value = '<?php echo $row['id']; ?>'; // Add the menu ID

                                                                        // Append the hidden input to the form
                                                                        this.appendChild(idInput);

                                                                        // Submit the form
                                                                        this.submit(); // Submit the form normally
                                                                    });
                                                                </script>


                                                                <div class="mb-3">
                                                                    <label for="image_<?php echo $row['id']; ?>"
                                                                        class="form-label">Image</label>
                                                                    <input type="file" class="form-control"
                                                                        id="image_<?php echo $row['id']; ?>" name="image"
                                                                        accept="image/*">
                                                                </div>

                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $row['id']; ?>" />
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Menu Icon -->
                                            <a class="dbi bi-trash"
                                                href="view/backend/deletesubmenu.php?id_menu=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this menu?');"></a>
                                        <?php } ?>



                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                        <script>
                            // Event listener for search bar
                            document.getElementById('search').addEventListener('keyup', function () {
                                let input = this.value.toLowerCase();
                                let rows = document.querySelectorAll('table tbody tr'); // Correctly target the rows in the table body

                                rows.forEach(row => {
                                    let cells = row.getElementsByTagName('td');
                                    let found = false;

                                    for (let i = 0; i < cells.length; i++) {
                                        if (cells[i].textContent.toLowerCase().includes(input)) {
                                            found = true;
                                            break;
                                        }
                                    }

                                    row.style.display = found ? '' : 'none'; // Show or hide the row based on search
                                });
                            });

                            // Change entries per page
                            document.getElementById('entries_per_page').addEventListener('change', function () {
                                const entries = this.value;
                                window.location.href = `?entries_per_page=${entries}&page=1`; // Redirect to update entries per page
                            });
                        </script>


                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item <?php if ($current_page == 1)
                                    echo 'disabled'; ?>">
                                    <a class="page-link"
                                        href="?page=<?php echo max(1, $current_page - 1); ?>&entries_per_page=<?php echo $entries_per_page; ?>">Previous</a>
                                </li>

                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $activeClass = ($i == $current_page) ? 'active' : ''; ?>
                                    <li class="page-item <?php echo $activeClass; ?>">
                                        <a class="page-link"
                                            href="?page=<?php echo $i; ?>&entries_per_page=<?php echo $entries_per_page; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>

                                <li class="page-item <?php if ($current_page == $total_pages)
                                    echo 'disabled'; ?>">
                                    <a class="page-link"
                                        href="?page=<?php echo min($total_pages, $current_page + 1); ?>&entries_per_page=<?php echo $entries_per_page; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
// include properti
include('view/templates/footer.php');
?>