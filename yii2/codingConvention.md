# My yii2 coding convention

## Naming

### Common

Tên hàm và tên biến phải đặt dễ hiểu. Kể cả đặt dài cũng được.
Ví dụ: nếu có một array mapping giữa model id và model object (model là kiểu People), thì không đặt tên là `$people` mà nên đặt là `$peopleId2Object`, sao cho thể hiện rõ đặc trưng của nó. Nếu chỉ là array `$people` bình thường, thì sẽ hiểu là key của nó không có gì đặc biệt. Nên tham khảo thêm từ quyển craftman.

### Tên biến

Tên biến PHP phải dùng theo dạng camel, không được dùng kiểu underscore.

Chú ý là tên instance variable trong model trùng với tên DB column, cái này là kiểu underscore.
Nhưng cái này không phải là biến được khai báo trong model class, nên vẫn không vi phạm quy tắc tên biến phải là dạng camel.