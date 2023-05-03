PHP 8.1 hoặc 8.2

Để chạy được source code cần cấu hình kết nối database: 
	Sửa DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD trong file /source/code/.env

Các cách chạy project
	Cách chạy bằng xampp
		- copy hết thư mục /source vào /htdocs và truy cập http://localhost/source/code
	Cách chạy bằng laragon (khuyên dùng)
		- copy hết thư mục /source vào /www và truy cập http://localhost/source/code
	Cách chuyên nghiệp hơn
		- Để folder ở đâu cũng được, bật cmd ở thư mục /source/code
		- Gõ lệnh này để mở 1 port chạy mã php
			php -S 127.0.0.1:8000 
		- Lên trình duyệt gõ 127.0.0.1:8000
		- Ảnh ví dụ cách chạy này: https://prnt.sc/Htx1WkyH8eCt

Import collection cho Postman để test
	Import vào postman file /source/web service.postman_collection.json

Note:
	+ Tài khoản test:
		Admin
			TK: admin@gmail.com
			MK: 1234
		Customer
			TK: customer@gmail.com
			MK: 1234