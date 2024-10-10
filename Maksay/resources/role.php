<?php
// include properti
include('view/templates/header.php');

// Get the entries per page from the URL or set a default
$entries_per_page = isset($_GET['entries_per_page']) ? (int)$_GET['entries_per_page'] : 10;

// Get the current page from the URL or set it to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $entries_per_page;

// Include database connection
include '../databases/database.php';

// Count total records for pagination
$total_result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM role");
$total_rows = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_rows / $entries_per_page);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Role</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Role</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Isi Tambah -->
    <div class="card-body">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="view/backend/addrole.php" method="post" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="nama_role" class="col-sm-2 col-form-label">Role <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_role" name="nama_role" required>
                                </div>
                            </div>
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
                        <div class="d-flex justify-content-between mb-3 mt-3">
                            <div>
                                Show<label for="entries_per_page" class="me-2"></label>
                                <select id="entries_per_page" class="form-select d-inline-block w-auto">
                                    <option value="5" <?php echo $entries_per_page == 5 ? 'selected' : ''; ?>>5</option>
                                    <option value="10" <?php echo $entries_per_page == 10 ? 'selected' : ''; ?>>10</option>
                                    <option value="20" <?php echo $entries_per_page == 20 ? 'selected' : ''; ?>>20</option>
                                    <option value="50" <?php echo $entries_per_page == 50 ? 'selected' : ''; ?>>50</option>
                                </select> entries per page
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control me-2" id="search" placeholder="Search..." aria-label="Search">
                                <button type="button" class="btn btn-primary w-75" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    + Add Role
                                </button>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Role Name</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Time Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody id="roleTableBody">
                                <?php
                                // Fetch roles data
                                $data = mysqli_query($koneksi, "SELECT * FROM role ORDER BY id_role ASC LIMIT $offset, $entries_per_page");
                                $nomor = $offset + 1;
                                while ($row = mysqli_fetch_array($data)) { ?>
                                    <tr>
                                        <td><?php echo $nomor++; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_role']); ?></td>
                                        <td data-type="date" data-format="MM/DD/YYYY"><?php echo htmlspecialchars($row['timestamp']); ?></td>
                                        <td>
                                            <i class="bi bi-pencil" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $row['id_role']; ?>" onclick="openEditModal('<?php echo $row['id_role']; ?>')"></i>

                                            <div class="modal fade" id="editModal_<?php echo $row['id_role']; ?>" tabindex="-1" aria-labelledby="editModalLabel_<?php echo $row['id_role']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel_<?php echo $row['id_role']; ?>">Edit Role</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="view/backend/editrole.php" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="nama_role" class="col-sm-2 col-form-label">Role <span class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control" id="nama_role" name="nama_role" value="<?php echo htmlspecialchars($row['nama_role']); ?>" required>
                                                                    </div>
                                                                </div>
                                                                <input name="id_role" value="<?php echo $row['id_role']; ?>" hidden />
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" value="simpan">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="dbi bi-trash" href="view/backend/deleterole.php?id_role=<?php echo $row['id_role']; ?>" onclick="return confirm('Are you sure you want to delete this user?');"></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item <?php if ($current_page == 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo max(1, $current_page - 1); ?>&entries_per_page=<?php echo $entries_per_page; ?>">Previous</a>
                                </li>

                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $activeClass = ($i == $current_page) ? 'active' : ''; ?>
                                    <li class="page-item <?php echo $activeClass; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&entries_per_page=<?php echo $entries_per_page; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>

                                <li class="page-item <?php if ($current_page == $total_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo min($total_pages, $current_page + 1); ?>&entries_per_page=<?php echo $entries_per_page; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>

                        <script>
                            // Event listener for search bar
                            document.getElementById('search').addEventListener('keyup', function() {
                                let input = this.value.toLowerCase();
                                let rows = document.querySelectorAll('#roleTableBody tr');

                                rows.forEach(row => {
                                    let cells = row.getElementsByTagName('td');
                                    let found = false;

                                    for (let i = 0; i < cells.length; i++) {
                                        if (cells[i].textContent.toLowerCase().includes(input)) {
                                            found = true;
                                            break;
                                        }
                                    }

                                    row.style.display = found ? '' : 'none';
                                });
                            });

                            // Change entries per page
                            document.getElementById('entries_per_page').addEventListener('change', function() {
                                const entries = this.value;
                                window.location.href = `?entries_per_page=${entries}&page=1`;
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// include properti
include('view/templates/footer.php');
?>