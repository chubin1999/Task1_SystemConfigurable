# SystemConfigurable
# Tạo 1 module mới trong đó:

- Tạo 1 field enable/disable dạng yes/no
- Tạo 1 field Turn on/off shipping method with customer group
  + Cột đầu tiên là shipping method, cột 2 là Customer group, cột 3 là action
  + Shipping method là lấy toàn bộ shipping method đang được enable và dạng select
  + Cột Customer group là lấy toàn bộ group của customer và dạng multiselect
  + Cột action là xóa
  + Button add new là để thêm 1 recode mới
- Nếu setting config được thiết lập thì sẽ được áp dụng theo customer group ở checkout cart và checkout page
