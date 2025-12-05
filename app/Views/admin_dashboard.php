<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cyber Security Awareness Quiz</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <div class="container fade-in">
        <div class="wrapper" style="padding: 30px;">
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
                
                <div style="display:flex; gap:15px; align-items:center;">
                    <a href="<?= base_url('admin/all_questions') ?>" class="btn" style="background:#3b82f6;">See All Questions</a>
                    <button onclick="exportPDF()" class="btn" style="background:#ef4444;">Export Scores (PDF)</button>
                    <a href="<?= base_url('logout') ?>" class="btn" style="background:#64748b;">Sign Out</a>
                    
                    <!-- Profile Section -->
                    <div class="profile-container">
                        <div class="profile-icon" onclick="toggleDropdown()" title="Click to manage profile">
                            A
                        </div>
                        
                        <div class="dropdown-menu" id="profileDropdown">
                            <div class="dropdown-header">Admin Profile</div>
                            
                            <form action="<?= base_url('admin/update_profile') ?>" method="post">
                                <div class="form-group">
                                    <label>Update Username</label>
                                    <input type="text" name="username" placeholder="New username (optional)">
                                </div>
                                <div class="form-group">
                                    <label>Update Password</label>
                                    <input type="password" name="password" placeholder="New password (optional)">
                                </div>
                                <button type="submit" class="btn btn-success" style="width:100%;">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="pass" style="margin-bottom: 20px; display:block; text-align:center;"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="fail" style="margin-bottom: 20px; display:block; text-align:center;"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Score</th>
                            <th>Marks</th>
                            <th>Status</th>
                            <th>Device</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($results)): ?>
                            <?php foreach($results as $row): ?>
                            <tr>
                                <td><?= esc($row['full_name']) ?></td>
                                <td><?= esc($row['email']) ?></td>
                                <td><?= esc($row['score']) ?>%</td>
                                <td><?= esc($row['marks']) ?></td>
                                <td><span class="<?= $row['score'] >= 80 ? 'pass' : 'fail' ?>"><?= esc($row['status']) ?></span></td>
                                <td><?= esc($row['device_type']) ?></td>
                                <td><?= esc($row['created_at']) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/result_details/'.$row['id']) ?>" class="action-btn btn-view" title="View Details"><i class="fas fa-eye"></i></a>
                                    <a href="#" onclick="return confirmDelete('<?= base_url('admin/delete_result/'.$row['id']) ?>');" class="action-btn btn-delete" title="Delete"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align:center;">No results found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="modal-title">Delete Record?</div>
            <div class="modal-text">Are you sure you want to delete this record? This action cannot be undone.</div>
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-delete">Delete</a>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.profile-icon') && !event.target.closest('.dropdown-menu')) {
                const dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('active')) {
                        openDropdown.classList.remove('active');
                    }
                }
            }
            // Close modal when clicking outside
            if (event.target.matches('.modal-overlay')) {
                closeDeleteModal();
            }
        }

        function confirmDelete(url) {
            const modal = document.getElementById('deleteModal');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.href = url;
            modal.classList.add('active');
            return false;
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('active');
        }

        function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Quiz Scores Report", 14, 15);
            doc.setFontSize(10);
            doc.text("Generated on: " + new Date().toLocaleString(), 14, 22);

            const table = document.querySelector("table");
            const rows = Array.from(table.querySelectorAll("tbody tr"));
            
            // Extract data: Name, Email, Score, Marks
            const data = rows.map(row => {
                const cells = row.querySelectorAll("td");
                if (cells.length < 3) return []; // Skip empty/no-result rows
                return [
                    cells[0].innerText, // Name
                    cells[1].innerText, // Email
                    cells[2].innerText, // Score
                    cells[3].innerText  // Marks
                ];
            }).filter(row => row.length > 0);

            doc.autoTable({
                head: [['Full Name', 'Email', 'Score', 'Marks']],
                body: data,
                startY: 30,
            });

            doc.save("quiz_scores.pdf");
        }
    </script>
</body>
</html>