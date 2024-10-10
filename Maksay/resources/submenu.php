<style>
    .modal-body-scrollable {
        max-height: 400px;
        overflow-y: auto;
    }

    .quill-editor-full {
        height: 200px;
    }
</style>

<?php
// include properti
include('view/templates/header.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Submenu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../resources/index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Submenu</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Isi Tambah -->
    <div class="card-body larger-card-body">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="proses_tambahsubmenu.php" method="post" enctype="multipart/form-data">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Submenu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-scrollable">
                            <div class="row mb-3">
                                <label for="submenu_name" class="col-sm-2 col-form-label">Submenu Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="submenu_name" name="submenu_name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="menu_id" class="col-sm-2 col-form-label">Menu ID</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="menu_id" name="menu_id" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="user_id" class="col-sm-2 col-form-label">User ID</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="user_id" name="user_id" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="submenu_image" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="submenu_image" name="submenu_image" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="submenu_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="submenu_description" name="submenu_description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Submenu -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Tabel -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Submenu Name</th>
                                    <th>Menu Id</th>
                                    <th>User Id</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Modified By</th>
                                    <th>Time Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../databases/database.php';

                                // Mengambil data submenu
                                $data = mysqli_query($koneksi, "SELECT submenu.*, login.nama_lengkap FROM submenu LEFT JOIN login ON submenu.modified_by = login.id_login ORDER BY id_submenu ASC");
                                
                                $nomor = 1;
                                while ($row = mysqli_fetch_array($data)) { ?>
                                    <tr>
                                        <td><?php echo $nomor++; ?></td>
                                        <td><?php echo htmlspecialchars($row['submenu_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['menu_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                        <td><img src="<?php echo htmlspecialchars($row['submenu_image']); ?>" alt="submenu image" style="width: 50px;"></td>
                                        <td><?php echo htmlspecialchars($row['submenu_description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                        <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                                        <td>
                                            <!-- Edit Submenu -->
                                            <a href="proses_editsubmenu.php?id_submenu=<?php echo $row['id_submenu']; ?>" class="bi bi-pencil"></a>
                                            <!-- Hapus Submenu -->
                                            <a href="hapussubmenu.php?id_submenu=<?php echo $row['id_submenu']; ?>" class="bi bi-trash" onclick="return confirm('Are you sure?');"></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table -->
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