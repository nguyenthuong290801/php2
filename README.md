1. Để thiết lập cơ sở dữ liệu từ tệp .env, bạn có thể thực hiện các bước sau:

    - Mở tệp .env trong dự án của bạn.
    - Đặt giá trị cho các biến môi trường như tên người dùng (DB_USER), mật khẩu (DB_PASSWORD),...
    - Lưu tệp .env.

    Ví dụ:

   DB_CONNECTION=mysql:host=localhost
   DB_PORT=3306
   DB_USERNAME=root
   DB_DATABASE=tutor
   DB_PASSWORD=123

    - Sau khi đã cấu hình tệp .env, Ứng dụng sẽ tự động sử dụng các giá trị này khi kết nối với cơ sở dữ liệu trong  
    ứng dụng của bạn.

2. Đối với việc sử dụng Artisan, có một số lệnh quan trọng mà bạn có thể sử dụng:

    - Tạo controller: php artisan make:controller NameController (thay "Name" bằng tên mong muốn).
    - Tạo model: php artisan make:model Name (thay "Name" bằng tên mong muốn).
    - Tạo migration: php artisan make:migration create_name_table hoặc php artisan make:migration update_name_table 
    (thay "name" bằng tên bảng mong muốn).
    - Chạy migration: php artisan migrate - lệnh này sẽ tạo bảng trong cơ sở dữ liệu dựa trên các file migration đã  
    được tạo.

3. Để sử dụng routes, có một số điểm quan trọng cần lưu ý:

   - Đối với API routes, bạn có thể cấu hình chúng trong file routes/api.php. Đây là nơi bạn xác định các tuyến     
   dẫn
   tương ứng với các hành động API của bạn.
   - Đối với web routes, bạn có thể cấu hình chúng trong file routes/web.php. Đây là nơi bạn xác định các tuyến dẫn 
   tương ứng với các hành động của trang web của bạn.

   Ví dụ cấu hình một web route:

   use App\controllers\admin\ApiController;
   Route::get('/api/product', [AdminApiController::class, 'index']);

   - Trong ví dụ trên, '/ ' là đường dẫn mà người dùng nhập vào. new HomeController() trỏ tới class HomeController 
   và index là phương thức mà bạn muốn chạy. Hãy đảm bảo đã sử dụng use để có thể sử dụng các controller ví dụ như
     use App\controllers\admin\ApiController;

4. Layout Master trong Laravel được xử lý bằng cách sử dụng phần {{content}} trong file main.php. Để hiển thị các trang con trong master page, bạn sẽ cần truyền chúng vào phần {{content}}.

    Ví dụ:

    Trong file main.php:

    <html>
    <head>
        <title>Website của tôi</title>
    </head>
    <body>
        <div class="container">
            {{content}}
        </div>
    </body>
    </html>

    Chẳng hạn, nếu bạn muốn tạo một layout mới, bạn có thể làm như sau:

    - Tạo một file layout mới (ví dụ: auth.php) trong thư mục layout của bạn.
    - Trong các phương thức xử lý của controllers, sử dụng phương thức setLayout() để đặt layout mới:
    $this->setLayout('auth');
    - Trả về view và chuyển vào layout mới:
    return $this->render('pages/register', []);

5. Debug
    - Cách sử dụng:
        Debug::var_dump($var); Chỉ hiển thị một giá trị;
        Debug::var_dump([$var, $string]); Hiển thị nhiều giá trị;


