# Realtime-Update Blog
## Thông tin sinh viên
* **Họ và tên:** Nguyễn Lê Phương Linh
* **MSSV:** 22014068 
## Giới thiệu dự án

**Reverb** là một nền tảng blog cộng đồng được xây dựng bằng Laravel Framework, nơi mọi người dùng đều là trung tâm của sự tương tác. Khác với các trang web truyền thống, dự án này không có vai trò "Quản trị viên"; thay vào đó, nó trao quyền cho mỗi người dùng để trở thành người sáng tạo nội dung và tham gia vào các cuộc thảo luận.

Mục tiêu chính của dự án là xây dựng một không gian trực tuyến nơi người dùng có thể:

*   **Tạo và chia sẻ:** Tự do viết và đăng tải các bài blog của riêng mình.
*   **Quản lý nội dung cá nhân:** Toàn quyền chỉnh sửa và xóa các bài viết do chính mình tạo ra.
*   **Tương tác và kết nối:** Đọc bài viết của những người dùng khác và tham gia thảo luận thông qua hệ thống bình luận.

Dự án được phát triển trên nền tảng **PHP 8.1** và **Laravel 10**, thể hiện khả năng xây dựng một ứng dụng web hướng người dùng, với các cơ chế xác thực, phân quyền dựa trên quyền sở hữu, và tương tác dữ liệu phức tạp.

## Các chức năng chính của website

Hệ thống được thiết kế để tất cả người dùng đã xác thực đều có thể tham gia vào việc tạo và quản lý nội dung.

*   **Đăng ký & Đăng nhập:** Cung cấp hệ thống xác thực an toàn cho người dùng tạo và truy cập tài khoản.
*   **Xem nội dung:** Mọi người (cả khách và thành viên) đều có thể đọc tất cả các bài viết được đăng trên nền tảng.
*   **Tạo bài viết:** Sau khi đăng nhập, bất kỳ người dùng nào cũng có thể soạn thảo và đăng tải bài viết của riêng mình.
*   **Quản lý bài viết cá nhân (CRUD dựa trên quyền sở hữu):**
    *   Người dùng có toàn quyền chỉnh sửa nội dung và thông tin các bài viết do mình đã tạo.
    *   Người dùng có thể xóa vĩnh viễn các bài viết của mình khỏi hệ thống.
*   **Bình luận:** Người dùng đã đăng nhập có thể để lại bình luận trên bất kỳ bài viết nào để tham gia thảo luận.
*   **Quản lý bình luận cá nhân:** Người dùng có thể xóa các bình luận do chính mình đã viết.

## Sơ đồ cấu trúc
### a. Bảng `users` (Người dùng)

Bảng này lưu trữ thông tin về tất cả người dùng đăng ký trên hệ thống.

*   `id` **(PK)**: Khóa chính, định danh duy nhất cho mỗi người dùng, kiểu `BIGINT`, tự động tăng.
*   `name`: Tên của người dùng, kiểu `VARCHAR`.
*   `email`: Địa chỉ email dùng để đăng nhập, bắt buộc phải là duy nhất, kiểu `VARCHAR`.
*   `password`: Mật khẩu của người dùng, được lưu dưới dạng đã mã hóa (hashed), kiểu `VARCHAR`.
*   `role`: Vai trò của người dùng để phân quyền (ví dụ: `admin`, `member`), kiểu `VARCHAR`.
*   `created_at`, `updated_at`: Dấu thời gian (timestamps) do Laravel tự động quản lý, cho biết thời điểm bản ghi được tạo và cập nhật lần cuối.

### b. Bảng `posts` (Bài viết/Blog)

Bảng này chứa nội dung các bài viết trên blog.

*   `id` **(PK)**: Khóa chính, định danh duy nhất cho mỗi bài viết, kiểu `BIGINT`, tự động tăng.
*   `title`: Tiêu đề của bài viết, kiểu `VARCHAR`.
*   `content`: Nội dung chi tiết của bài viết, kiểu `TEXT` để có thể lưu trữ văn bản dài.
*   `image`: Đường dẫn đến file ảnh đại diện của bài viết, kiểu `VARCHAR`.
*   `user_id` **(FK)**: Khóa ngoại, liên kết đến cột `id` của bảng `users`. Nó cho biết ai là tác giả của bài viết này.
*   `created_at`, `updated_at`: Dấu thời gian tạo và cập nhật bài viết.

### c. Bảng `comments` (Bình luận)

Bảng này lưu trữ tất cả các bình luận của người dùng cho các bài viết.

*   `id` **(PK)**: Khóa chính, định danh duy nhất cho mỗi bình luận, kiểu `BIGINT`, tự động tăng.
*   `content`: Nội dung của bình luận, kiểu `TEXT`.
*   `user_id` **(FK)**: Khóa ngoại, liên kết đến cột `id` của bảng `users`. Nó cho biết ai là người đã viết bình luận này.
*   `post_id` **(FK)**: Khóa ngoại, liên kết đến cột `id` của bảng `posts`. Nó cho biết bình luận này thuộc về bài viết nào.
*   `created_at`, `updated_at`: Dấu thời gian tạo và cập nhật bình luận.

## Sơ đồ thuật toán

### Thuật toán Người dùng (User)

**Chi tiết các bước:**

#### a. Đăng ký tài khoản (`RegisteredUserController@store`)
1.  Nhận yêu cầu từ form đăng ký.
2.  Xác thực dữ liệu (`$request->validate()`).
3.  Mã hóa mật khẩu (`Hash::make()`) và tạo người dùng (`User::create()`).
4.  Kích hoạt sự kiện `Registered` và đăng nhập người dùng (`Auth::login()`).
5.  Chuyển hướng đến trang `dashboard`.

#### b. Đăng nhập (`AuthenticatedSessionController@store`)
1.  Nhận yêu cầu từ form đăng nhập.
2.  Xác thực request (`$request->authenticate()`), bao gồm `RateLimiter` và `Auth::attempt()`.
3.  Tạo lại session (`session()->regenerate()`) nếu thành công.
4.  Chuyển hướng đến trang `dashboard`.

#### c. Đăng xuất (`AuthenticatedSessionController@destroy`)
1.  Nhận yêu cầu đăng xuất.
2.  Đăng xuất guard (`Auth::guard('web')->logout()`).
3.  Vô hiệu hóa session (`session()->invalidate()`) và tạo lại token (`regenerateToken()`).
4.  Chuyển hướng đến trang chủ (`/`).

---

### Thuật toán Bài viết (Blog)
![image](https://github.com/user-attachments/assets/d6c64029-8448-4113-b179-10a8a08ad3cb)
**Chi tiết các bước:**

#### a. Thêm Bài viết (`ProfileController@Store`)
1.  Yêu cầu được xử lý qua middleware `auth`.
2.  Xác thực dữ liệu (`$request->validate()`).
3.  Tạo bài viết (`Blog::create()`), gán `user_id` bằng `auth()->id()`.
4.  Phát sóng sự kiện `BlogCreatedEvent`.
5.  Chuyển hướng lại (`redirect()->back()`) với thông báo.

#### b. Sửa Bài viết (`ProfileController@updateblog`)
1.  Yêu cầu được xử lý qua middleware `auth`.
2.  **Kiểm tra quyền sở hữu:** Tìm bài viết bằng `where('id', $id)->where('user_id', Auth::id())`.
3.  Xác thực dữ liệu mới (`$request->validate()`).
4.  Cập nhật bài viết (`$blog->update()`).
5.  Phát sóng sự kiện `BlogUpdatedEvent`.
6.  Chuyển hướng lại (`redirect()->back()`) với thông báo.

#### c. Xóa Bài viết (`ProfileController@delete`)
1.  Yêu cầu được xử lý qua middleware `auth`.
2.  **Kiểm tra quyền sở hữu:** Tìm bài viết bằng `where('id', $id)->where('user_id', Auth::id())`.
3.  Xóa bài viết (`$blog->delete()`).
4.  Phát sóng sự kiện `BlogDeleted`.
5.  Chuyển hướng lại (`redirect()->back()`) với thông báo.

---

### Thuật toán Bình luận (Comment)
![image](https://github.com/user-attachments/assets/80d1dd06-0367-4e8a-9351-c58a7e3cba8d)

**Chi tiết các bước:**

#### Thêm Bình luận (`ProfileController@storeComment`)
1.  Yêu cầu được xử lý qua middleware `auth`.
2.  Xác thực dữ liệu (`$request->validate()`).
3.  Tạo bình luận (`Comment::create()`), gán `user_id` và `blog_id`.
4.  Chuyển hướng đến trang bài viết (`route('blog.show')`).

## Giao diện thực tế
