<?php
require 'vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => $_ENV['APP_ID'],
    'app_secret' => $_ENV['APP_SECRET'],
    'default_graph_version' => $_ENV['API_VERSION'],
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email'];

try {
    $accessToken = $helper->getAccessToken();

    if (!isset($accessToken)) {
        // Người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập của Facebook
        $loginUrl = $helper->getLoginUrl($_ENV['FB_BASE_URL'], $permissions);
        echo '<a href="' . htmlspecialchars($loginUrl) . '">Đăng nhập bằng Facebook!</a>';
    } else {
        // Lưu trữ thông tin người dùng vào session hoặc cơ sở dữ liệu
        $response = $fb->get('/me?fields=id,name,email', $accessToken);
        $user = $response->getGraphUser();

        // Ví dụ lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        // Hiển thị thông tin người dùng
        echo 'Đăng nhập thành công!';
        echo '<br>ID: ' . $user['id'];
        echo '<br>Name: ' . $user['name'];
        echo '<br>Email: ' . $user['email'];

        // Thêm liên kết để đăng xuất
        echo '<br><a href="logout.php">Đăng xuất</a>';
    }
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    // Xử lý lỗi phản hồi từ Facebook
    exit('Lỗi Facebook: ' . $e->getMessage());
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    // Xử lý lỗi SDK Facebook
    exit('Lỗi Facebook SDK: ' . $e->getMessage());
}
