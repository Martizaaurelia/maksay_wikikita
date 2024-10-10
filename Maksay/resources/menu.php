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
            <form action="view/backend/addmenu.php" method="post" enctype="multipart/form-data">
                <div class="modal-dialog modal-lg"> <!-- Use 'modal-lg' for larger modal -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-scrollable"> <!-- Add custom class here -->
                            <!-- Horizontal Form -->
                            <div class="row mb-3">
                                <label for="menu_code" class="col-sm-2 col-form-label">Menu Code <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="menu_code" name="menu_code" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="menu_name" class="col-sm-2 col-form-label">Menu Name <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="menu_image" class="col-sm-2 col-form-label">Image <span
                                        class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="menu_image" name="menu_image" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="menu_description" class="col-sm-2 col-form-label">Description <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <div class="quill-editor-full" id="editor"></div>
                                    <input type="hidden" id="menu_description" name="menu_description" /><br>
                                </div>
                            </div>
                            <script>
                                // Initialize Quill editor
                                var quill = new Quill('#editor', {
                                    theme: 'snow'
                                });

                                // On form submit, update the hidden input with the Quill editor content
                                document.querySelector('form').onsubmit = function() {
                                    var description = document.querySelector('input[name=menu_description]');
                                    description.value = quill.root.innerHTML; // Set Quill editor content to hidden input
                                };
                            </script>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" value="simpan">Save changes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                                    + Add Menu
                                </button>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Menu Code</th>
                                    <th>Menu Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Modified By</th>
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
                                $total_result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM menu");
                                $total_rows = mysqli_fetch_assoc($total_result)['total'];
                                $total_pages = ceil($total_rows / $entries_per_page);

                                // Fetch menu data with pagination
                                $data = mysqli_query($koneksi, "SELECT menu.*, login.nama_lengkap FROM menu LEFT JOIN login ON menu.modified_by = login.id_login ORDER BY id_menu ASC LIMIT $offset, $entries_per_page");

                                $nomor = $offset + 1; // To display the correct number
                                while ($row = mysqli_fetch_array($data)) { ?>
                                    <tr>
                                        <td><?php echo $nomor++; ?></td>
                                        <td><?php echo htmlspecialchars($row['menu_code']); ?></td>
                                        <td><?php echo htmlspecialchars($row['menu_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['menu_description']); ?></td>
                                        <td><img src="<?php echo htmlspecialchars($row['menu_image']); ?>"
                                                alt="<?php echo htmlspecialchars($row['menu_name']); ?>"
                                                style="width: 50px; height: auto;"></td>
                                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                        <!-- Display full name -->
                                        <td data-type="date" data-format="MM/DD/YYYY">
                                            <?php echo htmlspecialchars($row['timestamp']); ?>
                                        </td>
                                        <td>
                                            <!-- Edit Menu -->
                                            <i class="bi bi-pencil" data-bs-toggle="modal"
                                                data-bs-target="#editModal_<?php echo $row['id_menu']; ?>"></i>

                                            <!-- Modal for each menu -->
                                            <div class="modal fade" id="editModal_<?php echo $row['id_menu']; ?>"
                                                tabindex="-1"
                                                aria-labelledby="editModalLabel_<?php echo $row['id_menu']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel_<?php echo $row['id_menu']; ?>">Edit Menu
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="view/backend/editmenu.php" method="post"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="menu_code"
                                                                        class="col-sm-2 col-form-label">Menu Code <span
                                                                            class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control"
                                                                            id="menu_code" name="menu_code"
                                                                            value="<?php echo htmlspecialchars($row['menu_code']); ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="menu_name"
                                                                        class="col-sm-2 col-form-label">Menu Name <span
                                                                            class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control"
                                                                            id="menu_name" name="menu_name"
                                                                            value="<?php echo htmlspecialchars($row['menu_name']); ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="description"
                                                                        class="col-sm-2 col-form-label">Description <span
                                                                        class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control" id="description"
                                                                            name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="image"
                                                                        class="col-sm-2 col-form-label">Image <span
                                                                        class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="file" class="form-control" id="image"
                                                                            name="image">
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                // Fetch the current user id and full name from the session
                                                                // $current_user_id = $_SESSION['id_login'];  // Assuming this is stored when the user logs in
                                                                // $current_user_name = $_SESSION['nama_lengkap'];  // Full name stored in session
                                                                ?>

                                                                <div class="row mb-3">
                                                                    <label for="id_login"
                                                                        class="col-sm-2 col-form-label">Modified By <span
                                                                            class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <!-- Automatically select the current logged-in user -->
                                                                        <select id="id_login" class="form-select"
                                                                            name="id_login" readonly>
                                                                            <option value="<?php echo $nama_lengkap; ?>">
                                                                                <?php echo htmlspecialchars($nama_lengkap); ?>
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <input name="id_menu" value="<?php echo $row['id_menu']; ?>"
                                                                    hidden />
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    value="simpan">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="dbi bi-trash"
                                                href="view/backend/deletemenu.php?id_menu=<?php echo $row['id_menu']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                        <script>
                            // Event listener for search bar
                            document.getElementById('search').addEventListener('keyup', function() {
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
                            document.getElementById('entries_per_page').addEventListener('change', function() {
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