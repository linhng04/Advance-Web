#Realtime-Update Blog
##Thông tin sinh viên

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

## Sơ đồ cấu 
# Mô tả sơ đồ cơ sở dữ liệu
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


