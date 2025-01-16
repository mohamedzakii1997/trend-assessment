                                           ----------- Api Assessment Map ------------------




Note That : all apis are in the collection attached with examples ready to display on it . 


 /Auth dir 

 1 ) POST {{local_url}}auth/login --> login for both admin and customers .

 2 ) GET {{local_url}}auth/logout --> logged out for both by flashing the token created by sanctum .



 -------------------------------------------------


 /Admin dir 


 /Categories dir 


 1 ) GET {{local_url}}admins/categories/index --> fetching paginated category list .



  /Products dir


  1 ) GET {{local_url}}admins/products/index --> fetching  paginated products with applaying filters like { search key : name of product or name of its category , from to price range , category filtering by id  } .

  2 ) POST {{local_url}}admins/products/store --> store product .

  3 ) POST {{local_url}}admins/products/update/3 --> update product .

  4 ) GET {{local_url}}admins/products/show/3  --> display product details . 

  5 ) POST {{local_url}}admins/products/delete/3  --> delete product . 



-------------------------------------------------------------------------------------------------------------------------------


 /Customer dir 


 /Products dir 

  1 ) GET {{local_url}}customers/products/index  --> same flitering like admin but it has a cache results on it by custom cache key due to different filter params .
 
  2 ) GET  {{local_url}}customers/products/show/1 --> show product detials .

  


 /Orders dir 


 1 ) POST {{local_url}}customers/orders/place-order --> place an order with multi products , validate in stock for each product and the exsistance of the product it self ,  impelement evant for order placed for admin .


 2 ) GET {{local_url}}customers/orders/orderDetails/10 --> showing order detials , validating the order owner by using policy . 

 3 ) GET {{local_url}}customers/orders/index  --> fetching orders of the logged user with pagination .

 --------------------------------------------------------------------------------------------------------------------------------


 That Assessment has 2 test file laying in app/tests/Feature , those testing 1 ) product creation by admin , 2 ) placing order by customer .

 

 










