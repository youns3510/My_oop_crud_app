-- Table structure for table `categories`
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `created` timestamp   DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- Table structure for table `products`
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(512) NOT NULL,
  `created` timestamp   DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY category_id(`category_id`) REFERENCES categories(`id`) ON DELETE CASCADE ON UPDATE CASCADE
);


-- Dumping data for table `categories`
INSERT INTO `categories` (`name`) VALUES
( 'Fashion'),
( 'Electronics'),
( 'Motors');


-- Dumping data for table `products`
INSERT INTO `products` ( `name`, `description`, `price`, `category_id`,`image`) VALUES
('LG P880 4X HD', 'My first awesome phone!', 336, 3, 'image.png'),
('Google Nexus 4', 'The most awesome phone of 2013!', 299, 2, 'image.png'),
('Samsung Galaxy S4', 'How about no?', 600, 3, 'image.png'),
('Bench Shirt', 'The best shirt!', 29, 1, 'image.png'),
('Lenovo Laptop', 'My business partner.', 399, 2, 'image.png'),
('Samsung Galaxy Tab 10.1', 'Good tablet.', 259, 2, 'image.png'),
('Spalding Watch', 'My sports watch.', 199, 1, 'image.png'),
( 'Sony Smart Watch', 'The coolest smart watch!', 300, 2, 'image.png'),
( 'Huawei Y300', 'For testing purposes.', 100, 2, 'image.png'),
( 'Abercrombie Lake Arnold Shirt', 'Perfect as gift!', 60, 1, 'image.png'),
( 'Abercrombie Allen Brook Shirt', 'Cool red shirt!', 70, 1, 'image.png'),
( 'Abercrombie Allen Anew Shirt', 'Awesome new shirt!', 999, 1, 'image.png'),
( 'Another product', 'Awesome product!', 555, 2, 'image.png'),
( 'Bag', 'Awesome bag for you!', 999, 1, 'image.png'),
( 'Wallet', 'You can absolutely use this one!', 799, 1, 'image.png'),
( 'Wal-mart Shirt', '', 555, 2, 'image.png'),
( 'Amanda Waller Shirt', 'New awesome shirt!', 333, 1, 'image.png');

