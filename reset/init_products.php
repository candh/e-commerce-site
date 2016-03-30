<?php
include '../db.php';

$stock = 43; 

$sql = "INSERT INTO products (name, description, price, stock)
		VALUES ('SmoothMove Box','This is a kick-ass box which will let you move your things anywhere. Always to your rescue. It will never bail you out','6.90', $stock),
		('Simple Box','This is a simple box. It is as simple as a box can get. Great for moving things','2.40', $stock),
		('Small Box', 'This is a small box. Great for storing small shit', '1.50', $stock),
		('Black Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', $stock),
		('Pink Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', $stock),
		('White Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', $stock),
		('Noodles Box', 'This is a box made especially for Noodles. Great for your Chinese noodles shop', '2.00', $stock),
		('Yellow Cylindrical box', 'This is the coolest box ever. You can store anything you like in it', '3.40', $stock),
		('Wooden Box','This is a treasure like wooden box. Great for storing old things to show to your grand-children','50.00', $stock),
		('A box','No, really.. it''s a box. Just a simple box. You know what you can do with it','1.00', $stock),
		('Soap Box','This is really cool soap box. You can store your soap in it while you''re traveling','2.40', $stock),
		('Plastic Soap Box','This is a cool transparent soap storing box. You can however store anything in it','3.50', $stock),
		('Big Box','This box is made of cardboard. It''s great for using when you''re moving to another apartment','4.00', $stock),
		('Blue Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', $stock),
		('Lunch Box','This is the coolest, adorable, recyclable cardboard lunch box. You will be coolest person in the school/office if you use this box to store your delicious lunch','1.99', $stock),
		('Wooden Box w/ a hole','This is a box made of wood. You can store your books in it or any other thing you like','46.00', $stock),
		('Green Box','This box is made of cardboard and it also has a lid on it!','2.00', $stock)
		";

$query = $db->query($sql);
if($query) {
	print "Successfully Added";
}
else {
	print "Something went wrong!<br/>".$db->error;
}
?>