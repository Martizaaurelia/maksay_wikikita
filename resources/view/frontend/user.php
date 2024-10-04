<?php
// include properti
include('templates/header.php');

// Get the entries per page from the URL or set a default
$entries_per_page = isset($_GET['entries_per_page']) ? (int)$_GET['entries_per_page'] : 10;

// Get the current page from the URL or set it to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $entries_per_page;

// Count total records for pagination
include '../databases/database.php';
$total_result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM login");
$total_rows = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_rows / $entries_per_page);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Isi Tambah -->
    <div class="card-body">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="adduser.php" method="post" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Horizontal Form -->
                            <div class="row mb-3">
                                <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">Username <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-sm-2 col-form-label">Password <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <?php
                            include '../databases/database.php';
                            $data = mysqli_query($koneksi, "SELECT * FROM role ORDER BY id_role DESC");
                            ?>

                            <div class="row mb-3">
                                <label for="id_role" class="col-sm-2 col-form-label">Role <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <select id="id_role" class="form-select" name="id_role" required>
                                        <option selected disabled>Choose...</option>
                                        <?php while ($row = mysqli_fetch_array($data)) { ?>
                                            <option value="<?php echo $row['id_role']; ?>">
                                                <?php echo $row['nama_role']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gambar" class="col-sm-2 col-form-label">Foto <span class="mandatory-icon">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="gambar" name="gambar" required>
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
                                <select id="entries_per_page" class="form-select d-inline-block w-auto" onchange="location.href='?page=1&entries_per_page=' + this.value;">
                                    <option value="5" <?php echo $entries_per_page == 5 ? 'selected' : ''; ?>>5</option>
                                    <option value="10" <?php echo $entries_per_page == 10 ? 'selected' : ''; ?>>10</option>
                                    <option value="20" <?php echo $entries_per_page == 20 ? 'selected' : ''; ?>>20</option>
                                    <option value="50" <?php echo $entries_per_page == 50 ? 'selected' : ''; ?>>50</option>
                                </select> entries per page
                            </div>

                            <!-- Search bar and button in a flex container -->
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control me-2" id="search" placeholder="Search..." aria-label="Search">
                                <button type="button" class="btn btn-primary w-75" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    + Add User
                                </button>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Time Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <?php
                                // Fetch limited results based on pagination
                                $data = mysqli_query($koneksi, "SELECT * FROM login JOIN role ON login.id_role=role.id_role ORDER BY id_login DESC LIMIT $offset, $entries_per_page");

                                $nomor = $offset + 1; // Start numbering from the offset + 1
                                while ($row = mysqli_fetch_array($data)) { ?>
                                    <tr>
                                        <td><?php echo $nomor++; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_role']); ?></td>
                                        <td data-type="date" data-format="MM/DD/YYYY"><?php echo htmlspecialchars($row['timestamp']); ?></td>
                                        <td>
                                            <i class="bi bi-pencil" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $row['id_login']; ?>"></i>
                                            <div class="modal fade" id="editModal_<?php echo $row['id_login']; ?>" tabindex="-1" aria-labelledby="editModalLabel_<?php echo $row['id_login']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel_<?php echo $row['id_login']; ?>">Edit User</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="edituser.php" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input name="id_login" value="<?php echo $row['id_login']; ?>" hidden />
                                                                <div class="row mb-3">
                                                                    <label for="nama_lengkap" class="col-sm-4 col-form-label">Nama Lengkap <span class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($row['nama_lengkap']); ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="username" class="col-sm-4 col-form-label">Username <span class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="password" class="col-sm-4 col-form-label">Password</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="password" class="form-control" id="password" name="password">
                                                                        <small class="text-danger">Kosongkan jika tidak ingin mengubahnya.</small>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $roles = mysqli_query($koneksi, "SELECT * FROM role ORDER BY id_role DESC");
                                                                ?>
                                                                <div class="row mb-3">
                                                                    <label for="id_role" class="col-sm-4 col-form-label">Role <span class="mandatory-icon">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select id="id_role" class="form-select" name="id_role" required>
                                                                            <option value="<?php echo $row['id_role']; ?>"><?php echo htmlspecialchars($row['nama_role']); ?></option>
                                                                            <?php while ($role = mysqli_fetch_array($roles)) { ?>
                                                                                <option value="<?php echo $role['id_role']; ?>"><?php echo htmlspecialchars($role['nama_role']); ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="gambar" class="col-sm-4 col-form-label">Foto</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="file" class="form-control" id="gambar" name="gambar">
                                                                        <small class="text-danger">Tidak pilih foto jika tidak ingin mengubahnya.</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="dbi bi-trash" href="deleteuser.php?id_login=<?php echo $row['id_login']; ?>" onclick="return confirm('Are you sure you want to delete this user?');"></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Pagination controls -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item <?php if ($current_page == 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&entries_per_page=<?php echo $entries_per_page; ?>">Previous</a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                    <li class="page-item <?php if ($current_page == $i) echo 'active'; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&entries_per_page=<?php echo $entries_per_page; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php if ($current_page == $total_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&entries_per_page=<?php echo $entries_per_page; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>

                        <script>
                            // Event listener for search bar
                            document.getElementById('search').addEventListener('keyup', function() {
                                let input = this.value.toLowerCase();
                                let rows = userTableBody.getElementsByTagName('tr');

                                // Iterate through each row in the table
                                for (let row of rows) {
                                    // Get text from the second column (full name)
                                    let fullName = row.cells[1].textContent.toLowerCase();

                                    // If input is included in the full name, show the row, otherwise hide it
                                    if (fullName.includes(input)) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                }
                            });

                            // Trigger the change event on page load to show default entries
                            document.getElementById('entries_per_page').value = <?php echo $entries_per_page; ?>;
                        </script>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
// include properti
include('templates/footer.php');
?>