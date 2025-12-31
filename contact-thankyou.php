<?php

ob_start();

function getFormValue(array $post, array $possibleNames): string {
    foreach ($possibleNames as $name) {
        if (isset($post[$name])) {
            return trim($post[$name]);
        }
    }
    return '';
}

$serviceNames = ['service-name', 'service', 'nameService', 'title_service', 'service_name', 'selected-service'];
$tariffNames = ['selected-tariff', 'tariff', 'selected_tariff', 'my-tariff', 'tariff-name'];
$hotelNames = ['name_hotel', 'hotel-title', 'title_hotel', 'selected-hotel'];

$selectedService = getFormValue($_POST, $serviceNames);
$selectedTariff = getFormValue($_POST, $tariffNames);
$selectedHotel = getFormValue($_POST, $hotelNames);

$data = implode("\n", $_POST);
$domain = $_SERVER["HTTP_HOST"];
$to = "lead@" . $domain;
$subject = "Lead";
$message = $data;
$headers = "From: sender@" . $domain;

if (mail($to, $subject, $message, $headers)) {
    // echo "The message has been sent successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap">
    
<link rel="stylesheet" href="files/base.css">
<link rel="icon" type="image/png" href="files/static/favicon.png">
</head>
<body>
    <header class="navbar navbar-expand-lg sticky-top py-3" id="main-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="./">
                <img src="files/static/logo.png" alt="MythicPulseWorld Logo" class="me-2 site-logo">
                <span class="site-title">MythicPulseWorld</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html#hero-section">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html#origin-story">Origins</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html#what-inside">Inside</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html#qna-section">FAQ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container py-5">
            <section style="min-height: 53vh; display: flex; align-items: center; justify-content: center;">
<div id="contactThankYou" class="responseBox">
  <p class="messageIntro">Thank you for contacting us! We have received your message and our team is reviewing your inquiry.</p>
  <p class="responseTime">We aim to respond within 24 hours, so please expect an update soon. Have a wonderful day!</p>
</div>
</section>
        </div>
    </main>

    <footer class="footer py-4 mt-5 bg-reddish-brown text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">&copy; 2025 MythicPulseWorld. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-notice.html" class="text-light text-decoration-none">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-use.html" class="text-light text-decoration-none">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="terms-of-disclaimer.html" class="text-light text-decoration-none">Disclaimer</a></li>
                        <li class="list-inline-item"><a href="cookie-consent-policy.html" class="text-light text-decoration-none">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </script>
<script src="files/app.js"></script>
</body>
</html>
<?php
$page = ob_get_clean();

$page = str_replace('{{service-name-policy}}', htmlspecialchars($selectedService), $page);
$page = str_replace('{{tariff-name-policy}}', htmlspecialchars($selectedTariff), $page);
$page = str_replace('{{hotel-name-policy}}', htmlspecialchars($selectedHotel), $page);

echo $page;
?>