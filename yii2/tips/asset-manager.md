# Asset manager on yii2

## Overview

File css, js sẽ được web browser cache lại.
Mỗi khi update file css, js, browser có thể sẽ không load lại nội dung các file này, dẫn đến app chạy sai.
Để khắc phục việc này, chúng ta thường dùng 2 giải pháp
1. Cache Busting
2. Asset Publishing

### Từ vựng

|Term|Description|
|---|---|
|Asset bundle|toàn bộ các file css, js, image, thư mục con chứa trong một thư mục|

## Cache Busting

Cache busting là thêm một tham số `v=timestamp` vào TẤT CẢ link tới file css/js được quản lý bởi Asset manager (timestamp là thời gian update của từng file).
Để làm việc này, ta set `appendTimestamp` trong file config như sau:
```php
return [
    // ...
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
    ],
];
```

## Asset Publishing

Asset publishing khiến cho yii publish toàn bộ một thư mục (asset bundle) vào trong thư mục @web/assets mỗi khi date time của thư mục asset bundle bị thay đổi. Chúng ta thường thấy trong thư mục @web/assets/ có các thư mục con có tên là các chuỗi loằng ngoằng (chuỗi đó được sinh ra dựa trên thư mục bundle và ngày tháng của nó). Đây chính là do chúng được published.

Để dùng Asset publishing, trong asset bundle class, chúng ta khai báo `$sourcePath` (thư mục asset bundle) và không khai báo `$basePath`.

Chú ý: Asset bundle chỉ được publish khi date time của thư mục đó bị thay đổi. Việc thay đổi một file trong thư mục đó không khiến cho asset này được publish lại.

Asset publishing thường được sử dụng trong các extension. Khi chúng ta cài đặt hoặc update extension, thì thư mục asset bundle cũng bị update, nên nó sẽ được publish lại.

Dùng Asset publishing cho các file css, js của application không hiệu quả. Lí do là ngay cả khi ta update ngày tháng của asset bundle directory thì git cũng không thay đổi điều đó trên repository, khiến cho thư mục đó không có gì thay đổi trên các máy khác.

## Note

Trước đây với yii 1.1, mình đã từng extend class AssetBundle để nó publish lại bundle mỗi khi có thay đổi 1 trong số các file trong bundle.
Nhưng điều này đòi hỏi mỗi lần chạy chương trình nó sẽ phải check lại các file đó, không rõ có vấn đề về performance nhiều không.

## References

* [Asset Publishing](https://www.yiiframework.com/doc/guide/2.0/en/structure-assets#asset-publishing)
* [Cache Busting](https://www.yiiframework.com/doc/guide/2.0/en/structure-assets#cache-busting)
* [Assets](https://www.yiiframework.com/doc/guide/2.0/en/structure-assets)