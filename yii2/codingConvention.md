# My yii2 coding convention

Tài liệu này có link tới phần cơ bản về coding convention, ngoài ra sẽ có thêm các best practice liên quan đến yii2.

## Cơ bản

Tham khảo về coding convention cơ bản ở đây
* [Coding convention đối với một project PHP](https://viblo.asia/p/coding-convention-doi-voi-mot-project-php-ORNZqNPrl0n)
* [Coding Conventions và các chuẩn viết code trong PHP](https://viblo.asia/p/coding-conventions-va-cac-chuan-viet-code-trong-php-naQZRbrGZvx)

## MVC

* Không viết xử lý logic trong controller class. Controller chỉ làm 3 việc
  1. Nhận request parameter (lưu vào biến, model...)
  2. Gọi các model hoặc helper class để xử lý logic.
  3. Gọi lệnh render file view (với tham số các model, biến ở bước trên).
  Đặc biệt tránh mô tả logic xử lý trong các private function của controller.
* Model chủ yếu dùng để lưu data theo một đối tượng được định nghĩa.
  Các xử lý có đối tượng là một model nên được viết trong class của model đó, không nên viết ở class bên ngoài.
  <details>
  <summary>Ví dụ</summary>

  Nên viết
  ```php
  class Department extends Model
  {
    // Tính lương của các nhân viên trong bộ phận.
    public function calculateEmployeesPayraise()
    {
      $this->total_payraise = 0;
      foreach ($this->employees as $employee) {
        $employee->calcualteMonthlySalary(); // Tính lương của một employee.
        $this->total_payraise += $employee->monthly_salary;
      }
    }
  }

  class Employee extends Model
  {
    public function calcualteMonthlySalary()
    {
      // Tính lương.
      $this->monthly_salary = $this->basic_salary + $this->allowance;
    }
  }
  ```

  Không nên viết như sau:
  ```php
  class Department extends Model
  {
    // Tính lương của các nhân viên trong bộ phận.
    public function calculateEmployeesPayraise()
    {
      $this->total_payraise = 0;
      foreach ($this->employees as $employee) {
        // Không tốt: mang xử lý data của class Employee để trong class Department.
        $employee->monthly_salary = $employee->basic_salary + $employee->allowance;
        $this->total_payraise += $employee->monthly_salary;
      }
    }
  }
  ```
  Để có thể viết được tốt như trên, luôn luôn phải quán triệt tinh thân lập trình hướng đối tượng, code xử lý data thuộc về một object thì phải đặt trong class của object đó, không viết ở bên ngoài.
  </details>


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
  Điều này sẽ giúp dễ dàng mỗi khi bổ sung phần tử mới vào array (không sợ quên dấu phẩy ở phần tử phía trước), cũng không khiến diff báo dòng phía trước có sự khác biệt.

## Naming

### Common

Tên hàm và tên biến phải đặt dễ hiểu. Kể cả đặt dài cũng được.
Ví dụ:
* Nếu có một array mapping giữa model id và model object (model là kiểu Car), thì không đặt tên là `$cars` mà nên đặt là `$mapCarId2Objects`, sao cho thể hiện rõ đặc trưng của nó. Nếu chỉ là array `$cars` bình thường, thì sẽ hiểu là key của nó không có gì đặc biệt. Nên tham khảo thêm từ quyển craftman.
* Nếu có xử lý tên là `Employee::removeEmployees()`, trong khi ta còn có data là `team`, `project` có chứa employees, thì nên ghi tên hàm là `Employee::removeEmployeeFromTeam()` hoặc `Employee::removeEmployeeFromProject()`

### Tên biến

* Tên biến PHP phải dùng theo dạng camel, không được dùng kiểu underscore.
  <details>
  <summary>Ví dụ</summary>

  ```php
  // Nên đặt tên
  private $employeeName;

  // Không đặt tên
  private $employee_name;
  ```
  </details>
  Chú ý là tên instance variable trong model trùng với tên DB column, ví dụ `employee_id`, cái này là kiểu underscore.
  Nhưng cái này không phải là biến được khai báo trong code PHP, nên vẫn không vi phạm quy tắc tên biến phải là dạng camel.
* Các relation trong ActiveRecord model, nên là dạng camel case của tên DB column.
  Phần này càng máy móc càng tốt (theo kiểu dùng code generator sinh ra).
  <details>
  <summary>Ví dụ</summary>

  Tên db column là `org_team_id`, thì tên hàm relation là `getOrgTeam()` (không nên đặt là `getTeam()`), tên property là `$orgTeam`.
  </details>

## Lưu ý

* Dùng update/updateAll khá nguy hiểm. Nếu ta có những xử lý nằm ở `afterSave()` để update các data khác, thì gọi `updateAll()` sẽ khiến các xử lý này không được chạy.

## Document

* Các function cần phải có document giải thích nó làm gì.
  Có thông tin về parameter trong document, ít nhất là data type type. Trong khả năng có thể thì khai báo luôn data type trong function definition.
  <details>
  <summary>Ví dụ</summary>

  ```php
  /**
   * Copy data from another employee to this object.
   * @param Employee $employee
   * @return Employee $this object.
   */
  public function copyEmployee(Employee $source)
  {
    $this->attributes = $source->attributes;
  }
  ```
  </details>
* Có thông tin về class variable trong document, ít nhất là data type.
  Cái này sẽ có lợi cho IDE trong việc đưa ra code assistance.
  <details>
  <summary>Ví dụ</summary>

  ```php
  /**
   * Manipulate employee record in DB.
   */
  class Employee
  {
    /**
     * Name of employee.
     * @var string
     */
    private $name;
  }
  ```
  </details>
* Đôi khi, khai báo kiểu của biến trong đoạn code sẽ giúp IDE hỗ trợ (code assistance).
  <details>
  <summary>Ví dụ</summary>

  ```php
  /** @var Employee $employee */
  $employee = Employee::findOne(['id' => $id]);
  $employee->status = 1;
  ```
  </details>
* Ở đầu file view, cần phải mô tả các biến được truyền vào file view.
  <details>
  <summary>Ví dụ</summary>

  ```php
  <?php
  /* @var $this yii\web\View */
  /* @var $searchModel frontend\models\OrgTeamSearch */
  /* @var $dataProvider yii\data\ActiveDataProvider */
  /* @var $viewFlag int */

  // Cách viết dưới đây cho phép lược bỏ việc truyền tham số vào file view (khi muốn dùng default value).
  // Set default value for $viewFlag
  $viewFlag = isset($viewFlag) ? $viewFlag : 1;
  ```
  </details>
