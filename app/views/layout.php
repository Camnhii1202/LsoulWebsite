<?php
require_once 'app/utils/flashMessage.php';
require_once 'app/config/config.php';
$messages = getAllMessages();
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Lsoul Fashion</title>
    <link rel="stylesheet" href="<?php echo BASE_PATH . '/app/public/css/style.css' ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <?php require_once 'app/views/common/header.php' ?>

    <?php require_once $view ?>

    <?php require_once 'app/views/common/footer.php' ?>


    <div id="toast" class="toast hidden">
        <span id="toast-message"></span>
    </div>


    <!-- modal -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let toastTimeout;
            function showToast(message, type = "success") {
                const toast = document.getElementById("toast");

                //đóng toast nếu đang mở
                if (toastTimeout) {
                    clearTimeout(toastTimeout);
                    toast.className = `toast hidden ${type}`;

                    setTimeout(() => {
                        displayToast(message, type);
                    }, 300);
                } else {
                    displayToast(message, type);
                }
            }
            function displayToast(message, type) {
                const toast = document.getElementById("toast");
                const toastMessage = document.getElementById("toast-message");

                toastMessage.textContent = message || 'Thông báo';
                toast.className = `toast visible ${type}`;

                toastTimeout = setTimeout(() => {
                    toast.className = `toast hidden ${type}`;
                    toastTimeout = null;
                }, 2000);
            }
        });
    </script>

    <script>
        const menuIcon = document.getElementById('menu-icon');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeBtn = document.getElementById('close-btn');

        menuIcon.addEventListener('click', () => {
            mobileMenu.classList.add('open');
        });

        closeBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
        });

        document.addEventListener('scroll', function () {
            const parallaxImg = document.querySelector('.parallax-image img');
            const scrollPosition = window.scrollY;

            // Điều chỉnh giá trị dịch chuyển
            parallaxImg.style.transform = `translateY(${scrollPosition * 0.5}px)`;
        }); 
    </script>

    <script>
        $(document).ready(function () {
            function loadHeader() {
                'header-cart-badge'
                $.ajax({
                    url: `api/carts/count`,
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            //load header here
                        } else {
                            showToast('Error loading cart header: ' + response.message, 'error');
                        }
                    },
                    error: function () {
                        showToast('An error occurred while loading products.', 'error');
                    }
                });
            }

            // loadHeader();
            //add to cart
            $(document).on('click', '.add-to-cart', function () {
                const productId = $(this).data('product-id');
                $.ajax({
                    url: `api/carts/add?productId=${productId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            // loadHeader();
                            showToast('Đã thêm vào giỏ hàng');
                        } else {
                            showToast('Thêm vào giỏ hàng thất bại', 'error');
                        }
                    },
                    error: function (error) {
                        if (error.status === 401) {
                            showToast('Vui lòng đăng nhập để thực hiện', 'error');
                        } else {
                            showToast(`Lỗi thêm vào giỏ hàng`, 'error');
                        }
                    }
                });
                showToast(`Đã thêm ${productId} vào giỏ hàng`);
            });
        })

    </script>

    <?php if (isset($messages['error'])): ?>
        <script>showToast('<?php echo $messages['error'] ?>', 'error')</script>
    <?php endif; ?>
    <?php if (isset($messages['success'])): ?>
        <script>showToast('<?php echo $messages['success'] ?>')</script>
    <?php endif; ?>


</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion shop</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.5s ease, bottom 0.5s ease;
            z-index: 9999;
        }

        .toast.hidden {
            bottom: 10px;
            opacity: 0;
            pointer-events: none;
        }

        .toast.visible {
            bottom: 20px;
            opacity: 1;
            pointer-events: auto;
        }

        .toast.success {
            background-color: #78c27f;
        }

        .toast.error {
            background-color: #f44336;
        }
    </style>
</head>

<body>

    <?php require_once 'app/views/common/header.php' ?>

    <?php require_once $view ?>

    <?php require_once 'app/views/common/footer.php' ?>


    <div id="toast" class="toast hidden">
        <span id="toast-message"></span>
    </div>


    <script>
        let toastTimeout;
        function showToast(message, type = "success") {
            const toast = document.getElementById("toast");

            //đóng toast nếu đang mở
            if (toastTimeout) {
                clearTimeout(toastTimeout);
                toast.className = `toast hidden ${type}`;

                setTimeout(() => {
                    displayToast(message, type);
                }, 300);
            } else {
                displayToast(message, type);
            }
        }
        function displayToast(message, type) {
            const toast = document.getElementById("toast");
            const toastMessage = document.getElementById("toast-message");

            toastMessage.textContent = message || 'Thông báo';
            toast.className = `toast visible ${type}`;

            toastTimeout = setTimeout(() => {
                toast.className = `toast hidden ${type}`;
                toastTimeout = null;
            }, 2000);
        }

    </script>

    <script>
        $(document).ready(function () {
            function loadHeader() {
                'header-cart-badge'
                $.ajax({
                    url: `api/carts/count`,
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            const headerCartBadge = $('#header-cart-badge');
                            headerCartBadge.text('');
                            const cartCount = parseInt(response.data, 10);
                            headerCartBadge.text(cartCount >= 0 ? `Cart (${cartCount})` : 'Cart');
                        } else {
                            console.log(typeof (response))
                            showToast('Error loading cart header: ' + response.message, 'error');
                        }
                    },
                    error: function () {
                        showToast('An error occurred while loading products.', 'error');
                    }
                });
            }

            loadHeader();
            //add to cart
            $(document).on('click', '.add-to-cart', function () {
                const productId = $(this).data('product-id');
                $.ajax({
                    url: `api/carts/add?productId=${productId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            loadHeader();
                            showToast('Đã thêm vào giỏ hàng');
                        } else {
                            showToast('Thêm vào giỏ hàng thất bại', 'error');
                        }
                    },
                    error: function (error) {
                        if (error.status === 401) {
                            showToast('Vui lòng đăng nhập để thực hiện', 'error');
                        } else {
                            showToast(`Lỗi thêm vào giỏ hàng`, 'error');
                        }
                    }
                });
                showToast(`Đã thêm ${productId} vào giỏ hàng`);
            });
        })

    </script>

    <?php if (isset($messages['error'])): ?>
        <script>showToast('<?php echo $messages['error'] ?>', 'error')</script>
    <?php endif; ?>
    <?php if (isset($messages['success'])): ?>
        <script>showToast('<?php echo $messages['success'] ?>')</script>
    <?php endif; ?>

</body>

</html> -->