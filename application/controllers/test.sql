SELECT if(isnull(c.name), "kateqoriya yoxdur", c.name) as "name", onum.order_number, SUM(round((100 - o.discount)/100*o.ex_price, 2)) as "price", o.cat_id, o.product_id FROM ali_order_numbers as onum
LEFT JOIN (SELECT order_number, discount, ex_price, cat_id, product_id FROM ali_orders) as o on o.order_number=onum.order_number
LEFT JOIN (SELECT cat_id, name FROM ali_cats WHERE lang_id=2) as c on c.cat_id=o.cat_id
WHERE onum.order_status_id=15
GROUP BY name


SELECT onum.date_time, SUM(round((100 - o.discount)/100*o.ex_price, 2)) as "price" FROM ali_order_numbers as onum
LEFT JOIN (SELECT order_number, discount, ex_price, cat_id, product_id FROM ali_orders) as o on o.order_number=onum.order_number
WHERE onum.order_status_id=15
GROUP BY MONTH(onum.date_time)
