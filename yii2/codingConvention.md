# My yii2 coding convention

Tài liệu này có link tới phần cơ bản về coding convention, ngoài ra sẽ có thêm các best practice liên quan đến yii2.

## Cơ bản

Tham khảo về coding convention cơ bản ở đây
* [Coding convention đối với một project PHP](https://viblo.asia/p/coding-convention-doi-voi-mot-project-php-ORNZqNPrl0n)
* [Coding Conventions và các chuẩn viết code trong PHP](https://viblo.asia/p/coding-conventions-va-cac-chuan-viet-code-trong-php-naQZRbrGZvx)

## Action

* Sau mỗi POST action, cần phải redirect nếu xử lý thành công (để tránh user ấn F5).

## Space

* Không viết thừa space. Ví dụ không để 2 space liền nhau, như `if (a  == b)`.
* Setup editor để xóa hết trailing space when saving.

## Function

Không được viết function có số dòng quá dài. Mỗi function chỉ nên dưới 30 dòng.
Function dài thì không thể hiện được logic (chính) mà function thực hiện.
Function viết các step chính cho việc nó định xử lý. Chi tiết của các step đó cho vào các function khác.

## Array

* Để dấu phẩy sau phần tử cuối cùng của array.
  ```php
  $arr = [
      'a' => 'This is a',
      'b' => 'This is b',
  ];
  ```

## Naming

### Common

Tên hàm và tên biến phải đặt dễ hiểu. Kể cả đặt dài cũng được.
Ví dụ:
* Nếu có một array mapping giữa model id và model object (model là kiểu Car), thì không đặt tên là `$cars` mà nên đặt là `$carId2Object`, sao cho thể hiện rõ đặc trưng của nó. Nếu chỉ là array `$cars` bình thường, thì sẽ hiểu là key của nó không có gì đặc biệt. Nên tham khảo thêm từ quyển craftman.
* Nếu có xử lý tên là `Employee::removeEmployees()`, trong khi ta còn có data là `team`, `project` có chứa employees, thì nên ghi tên hàm là `Employee::removeEmployeeFromTeam()` hoặc `Employee::removeEmployeeFromProject()`

### Tên biến

Tên biến PHP phải dùng theo dạng camel, không được dùng kiểu underscore.

Chú ý là tên instance variable trong model trùng với tên DB column, cái này là kiểu underscore.
Nhưng cái này không phải là biến được khai báo trong model class, nên vẫn không vi phạm quy tắc tên biến phải là dạng camel.

## Lưu ý

* Dùng update/updateAll khá nguy hiểm. Nếu ta có những xử lý nằm ở `afterSave()` để update các data khác, thì gọi `updateAll()` sẽ khiến các xử lý này không được chạy.