# Đánh giá các tool quản lý i18n trên yii2

## Một số kiến thức cần giải đáp

* Trong file config, *language* setting có ý nghĩa gì?
* Giải thích cơ chế chọn language của yii2.
* Tên table {{%language_source}} nghĩa là gì (dùng trong file config, hoặc file migration).

## lajax/yii2-translate-manager

[Github](https://github.com/lajax/yii2-translate-manager)

* Có tính năng scan data chạy ngay trên màn hình.
* Không chạy trên sqlite (do migration dùng lệnh addForeignKey() sqlite không support).
* Đang tìm hiểu, nhưng chưa rõ cách sử dụng (hình như có bug nên không ra output như kỳ vọng).
* Có vẻ thích hợp khi cần dịch cả bộ cho một ngôn ngữ (list toàn bộ các từ cần dịch, rồi dịch chúng).

## umbalaconmeogia/yii2-i18nui
[Github](https://github.com/umbalaconmeogia/yii2-i18nui)

Là giải pháp thay thế cho wokster/yii2-translation-manager

## wokster/yii2-translation-manager

[Github](https://github.com/wokster/yii2-translation-manager)

* Đơn giản, dễ hiểu.
* Không còn được maintenance. Màn hình còn chưa hoàn thiện (đôi chỗ còn dùng tiếng Nga).
