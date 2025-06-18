<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD - Sistem Informasi Akademik</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            flex: 1;
        }
        
        .card {
            border-radius: 10px;
            border: none;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            padding: 1.5rem 0;
        }
        
        .card-footer {
            border-radius: 0 0 10px 10px !important;
        }
        
        .btn-primary {
            font-weight: 500;
            padding: 0.6rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .app-footer {
            margin-top: auto;
            text-align: center;
            padding: 1rem 0;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-university me-2"></i>SIAKAD
            </a>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>
    
    <footer class="app-footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-0">
                        <strong>Sistem Informasi Akademik</strong> | 
                        <span>Universitas yang dibuat iwans</span>
                    </p>
                    <p class="mb-0 small">
                        &copy; <?= date('Y') ?> All Rights Reserved
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Optional JavaScript -->
    <script>
        // Add any custom JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alert messages after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>