<?php
session_start();
require_once 'inc/header.php';
require_once 'inc/preload.php';
require_once 'inc/header_section.php';
require_once 'main/banner_section.php';
require_once 'main/service_section.php';
require_once 'main/pricing_section.php';
require_once 'main/contact_us_section.php';
require_once 'inc/footer_section.php';
require_once 'inc/copyright_section.php';
require_once 'inc/footer.php';
?>
<script>
    document.querySelector('a[href="index.html#services"]').addEventListener('click', function (e) {
        e.preventDefault();

        const target = document.querySelector('#services');
        const offset = 170;

        const targetPosition = target.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({
            top: targetPosition - offset,
            behavior: 'smooth'
        });
    });
    document.querySelector('a[href="index.html#memberships"]').addEventListener('click', function (e) {
        e.preventDefault();

        const target = document.querySelector('#memberships');
        const offset = 150;

        const targetPosition = target.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({
            top: targetPosition - offset,
            behavior: 'smooth'
        });
    });
    document.querySelector('a[href="index.html#contactus"]').addEventListener('click', function (e) {
        e.preventDefault();

        const target = document.querySelector('#contactus');
        const offset = 150;

        const targetPosition = target.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({
            top: targetPosition - offset,
            behavior: 'smooth'
        });
    });
</script>