<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/user.css') ?>">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
            color: #333;
        }

        .page-header h1 {
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon {
            padding: 0.5rem;
            border-radius:6px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-blue {
            background-color: #0d6efd;
        }

        .bg-green {
            background-color: #198754;
        }

        .bg-yellow {
            background-color: #ffc107;
            color: #333;
        }

        .bg-gray {
            background-color: #6c757d;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 0.5rem;
        }

        .search-filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .search-input input {
            padding-left: 2rem;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border: none;
            padding: 0;
        }

        #users-table {
            border-radius: 0.5rem;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: none;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        #users-table th {
            background: #C0C0C0;
            color: #fff;
            padding: 15px;
            font-size: 14px;
            font-weight: bold !important;
        }

        #users-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            font-size: 16px;
        }

        #users-table tbody tr {
            border: none;
        }

        #users-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        #users-table tbody tr:last-child td {
            border-bottom: 1px solid #dee2e6;
        }

        #users-table tbody tr td:last-child {
            border-right: none;
        }

        #users-table thead {
            border: none;
        }

        .user-info,
        .contact-info,
        .details-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .contact-info div,
        .details-info div {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .delete-user-btn {
            transition: all 0.2s;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .delete-user-btn:hover {
            background-color: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        #users-table th,
        #users-table td {
            text-align: center;
            vertical-align: middle;
        }

        .user-info,
        .contact-info,
        .details-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: center;
        }

        .contact-info div,
        .details-info div {
            justify-content: center;
        }

        .delete-user-btn {
            margin: auto;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="users-container">
            <div class="page-header mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Users Management</h1>
                        <p>Manage all registered users</p>
                    </div>
                    <button id="test-db-btn" class="btn btn-info btn-sm">🔧 Test Database</button>
                </div>
            </div>
            <hr />

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span>Total Users</span>
                        <div class="stat-icon bg-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value" id="total-users">0</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span>Active Users</span>
                        <div class="stat-icon bg-green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value" id="active-users">0</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span>New This Month</span>
                        <div class="stat-icon bg-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value" id="new-this-month">0</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title fw-bold">Registration Trend</span>
                        <div class="stat-icon" style="background-color: #6b7280;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                    </div>
                    <div class="state">
                        <div style="font-size: 0.8rem; color: #374151; margin-top: 4px;">
                            <div id="new-this-week"></div>
                            <div id="new-this-month-breakdown"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-filter-container">
                <div class="search-input position-relative flex-grow-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" id="search-term" class="form-control ps-5 fw-bold" placeholder="Search by Username, Email, or Phone">
                </div>

            </div>

            <div style=" box-shadow: none;">
                <div>
                    <div id="loading-state">Loading users...</div>
                    <div id="error-message" style="display:none;"></div>
                    <div id="empty-state" style="display:none;">No users found</div>
                    <div class="table-container table-responsive">
                        <table id="users-table" class="table fw-bold " style="display:none;">
                            <thead>
                                <tr>
                                    <th style="border-top-left-radius: 8px;"><span style="font-weight: 700; letter-spacing: 0.5px;">USER INFO</span></th>
                                    <th><span style="font-weight: 700; letter-spacing: 0.5px;">CONTACT</span></th>
                                    <th><span style="font-weight: 700; letter-spacing: 0.5px;">DETAILS</span></th>
                                    <th><span style="font-weight: 700; letter-spacing: 0.5px;">REGISTERED</span></th>

                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usersTableBody = document.querySelector('#users-table tbody');
            const loadingState = document.getElementById('loading-state');
            const emptyState = document.getElementById('empty-state');
            const errorMessage = document.getElementById('error-message');
            const usersTable = document.getElementById('users-table');
            const searchInput = document.getElementById('search-term');

            let allUsers = [];

            const parseDate = (dateStr) => {
                if (!dateStr) return null;
                let d = new Date(dateStr);
                return isNaN(d.getTime()) ? null : d;
            };
            const formatDate = (dateStr) => {
                const d = parseDate(dateStr);
                return d ? d.toLocaleDateString() : "N/A";
            };

            const renderStats = (users) => {
                document.getElementById('total-users').innerText = users.length;
                document.getElementById('active-users').innerText = users.filter(u => (u.status || "active").toLowerCase() === "active").length;

                const now = new Date();
                const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
                const newThisMonth = users.filter(u => {
                    const d = parseDate(u.created_at);
                    return d && d >= startOfMonth;
                }).length;
                document.getElementById('new-this-month').innerText = newThisMonth;

                const weekAgo = new Date();
                weekAgo.setDate(now.getDate() - 7);
                const thisWeek = users.filter(u => {
                    const d = parseDate(u.created_at);
                    return d && d >= weekAgo;
                }).length;

                document.getElementById('new-this-week').innerText = `This Week: ${thisWeek}`;
                document.getElementById('new-this-month-breakdown').innerText = `This Month: ${newThisMonth}`;
            };

            const renderUsers = (users) => {
                usersTableBody.innerHTML = '';
                if (users.length === 0) {
                    emptyState.style.display = 'block';
                    usersTable.style.display = 'none';
                    return;
                }
                emptyState.style.display = 'none';
                usersTable.style.display = 'table';

                users.forEach(u => {
                    let age = 'N/A';
                    const dob = u.dob || u.date_of_birth;
                    if (dob) {
                        const birth = new Date(dob);
                        const now = new Date();
                        age = now.getFullYear() - birth.getFullYear();
                        const m = now.getMonth() - birth.getMonth();
                        if (m < 0 || (m === 0 && now.getDate() < birth.getDate())) age--;
                    }

                    const phone = u.phone || u.phone_number || 'N/A';
                    const gender = u.gender || u.sex || 'N/A';

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><div class="user-info"><strong>${u.username || 'N/A'}</strong><div class="text-muted">ID: ${u.id || 'N/A'}</div></div></td>
                        <td><div class="contact-info"><div>${u.email || 'N/A'}</div><div>${phone}</div></div></td>
                        <td><div class="details-info"><div>${age} yrs</div><div>${gender}</div></div></td>
                        <td>${formatDate(u.created_at)}</td>`;
                    usersTableBody.appendChild(row);
                });
            };

            // FIX: This function was updated to call renderStats() with the filtered data.
            const applyFilters = () => {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const filtered = allUsers.filter(u => {
                    return (
                        String(u.id).toLowerCase().includes(searchTerm) ||
                        (u.username && u.username.toLowerCase().includes(searchTerm)) ||
                        (u.email && u.email.toLowerCase().includes(searchTerm)) ||
                        (u.phone && u.phone.toLowerCase().includes(searchTerm))
                    );
                });
                // renderStats(filtered); // This line was added/corrected.
                renderUsers(filtered);
            };

            const fetchUsers = async () => {
                try {
                    const res = await fetch('/admin/api/users');
                    if (!res.ok) throw new Error('Network response was not ok');
                    const users = await res.json();
                    allUsers = users;
                    renderStats(allUsers);
                    renderUsers(allUsers);
                } catch (err) {
                    errorMessage.style.display = "block";
                    errorMessage.innerText = "Failed to fetch users. Please check your API endpoint and network connection.";
                } finally {
                    loadingState.style.display = 'none';
                }
            };

            searchInput.addEventListener('input', applyFilters);

            document.getElementById('test-db-btn').addEventListener('click', async () => {
                try {
                    const res = await fetch('/admin/api/test/database');
                    const result = await res.json();
                    if (res.ok) {
                        let message = `Database Test Results:\n\n`;
                        message += `Connection: ${result.database_connection}\n`;
                        message += `Database: ${result.database_name}\n`;
                        message += `Login Table: ${result.login_table_test}\n`;
                        message += `Sign Table: ${result.sign_table_test}\n`;
                        message += `\nAll Tables: ${result.tables.join(', ')}`;
                        alert(message);
                    } else {
                        alert('Database test failed: ' + (result.message || 'Unknown error'));
                    }
                } catch (err) {
                    alert('Error testing database: ' + err.message);
                }
            });
            fetchUsers();
        });
    </script>
</body>

</html>