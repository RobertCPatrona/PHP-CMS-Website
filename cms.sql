-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2021 at 03:46 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(49, 'Houses'),
(50, 'Cars'),
(51, 'Pets');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author_id` int(11) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(26, 74, 0, 'Diane22', 'diane@gmail.com', 'Thanks for the tips', 'approved', '2021-09-17'),
(27, 73, 0, 'Diane22', 'diane@gmail.com', 'What bird is this?', 'approved', '2021-09-17'),
(28, 70, 0, 'Diane22', 'diane@gmail.com', 'Great house!', 'approved', '2021-09-17'),
(29, 77, 0, 'Tim13', 'tim@gmail.com', 'This is my draft', 'unapproved', '2021-09-17'),
(30, 75, 0, 'Tim13', 'tim@gmail.com', 'Informative article', 'approved', '2021-09-17'),
(31, 73, 0, 'Tim13', 'tim@gmail.com', 'I would like this as a pet!', 'approved', '2021-09-17'),
(32, 72, 0, 'Tim13', 'tim@gmail.com', 'Cute dog!', 'approved', '2021-09-17'),
(33, 72, 0, 'Brian7', 'wells@gmail.com', 'Looks good', 'approved', '2021-09-17'),
(34, 71, 0, 'Brian7', 'wells@gmail.com', 'This is an interesting article', 'approved', '2021-09-17'),
(35, 74, 0, 'Brian7', 'wells@gmail.com', 'Useful to know', 'approved', '2021-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `user_id`) VALUES
(62, 74, 26),
(63, 73, 26),
(64, 70, 26),
(65, 72, 26),
(66, 75, 27),
(67, 73, 27),
(68, 72, 27),
(69, 71, 27),
(70, 72, 28),
(71, 71, 28),
(72, 74, 28);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_user_id` int(11) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views` int(11) NOT NULL,
  `post_likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_user_id`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views`, `post_likes`) VALUES
(70, 49, 'How to improve a house', 22, 'Ben', '2021-09-17', 'house1.jpg', '<p><b>Lorem Ipsum</b> is simply <u>dummy text</u> of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'house, blue', 0, 'published', 2, 1),
(71, 50, 'Car maintenance', 26, 'Diane22', '2021-09-17', 'car1.jpg', '<p style=\\\"text-align: justify; \\\"><font color=\\\"#000000\\\" face=\\\"Open Sans, Arial, sans-serif\\\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</font><br></p>', 'car, white', 0, 'published', 10, 2),
(72, 51, 'Having a dog as pet', 27, 'Tim13', '2021-09-17', 'dog1.jpg', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'pets, dog', 0, 'published', 6, 3),
(73, 51, 'Which bird is right for you?', 28, 'Brian7', '2021-09-17', 'bird1.jpg', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'pets, bird', 0, 'published', 6, 2),
(74, 49, 'Looking for the best real estate', 28, 'Brian7', '2021-09-17', 'house2.jpg', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'house, blue', 0, 'published', 7, 2),
(75, 50, 'Auto reviews 2021', 22, 'Ben', '2021-09-17', 'car2.jpg', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'car, blue', 0, 'published', 3, 1),
(76, 49, 'Great areas to live in', 26, 'Diane22', '2021-09-17', 'house3.jpg', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'house, residential', 0, 'draft', 0, 0),
(77, 50, 'Explore the best car deals', 27, 'Tim13', '2021-09-17', 'car3.jpg', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'car, suv', 0, 'draft', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `rand_salt` varchar(255) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22$'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `rand_salt`) VALUES
(21, 'Tom', '$2y$10$YoKfwcLTwpl3QptDgK8DweJ2WBLU4yS0K5eYZmGjRyEFkRZo8w8kS', 'Tom', 'Jerry', 'tomAdmin@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22$'),
(22, 'Ben', '$2y$10$TW/QRdgMcWfxxcCdWxRu7egenFO8F9hFwDYLrrxBPkmgqoKK.WYAa', 'Ben', 'Jones', 'ben@gmail.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22$'),
(26, 'Diane22', '$2y$10$x3Vcj1I39epq5bjSeN7H7eIWladmyi6DmIJ/pNC7xt/VMLd7SbjEO', 'Diane', 'Summer', 'diane@gmail.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22$'),
(27, 'Tim13', '$2y$10$Yn2mrCVhTZqo5k/ktiGjDugKRojSA5xYFO0icKuqB6B5GHsE8BzM.', 'Tim', 'Rodriguez', 'tim@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22$'),
(28, 'Brian7', '$2y$10$J0ypRakEmINKliPOa/kfFOHZqMG0K2zMSAhuPwJ9jXtzye31cBGbC', 'Brian', 'Wells', 'wells@gmail.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22$');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(3) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '6nhnbku5dkd0c6s9rc12khthr9', 1631292873),
(2, 'mpq5j5gie8lmup7h8nvhm0hopl', 1631287796),
(3, 'fevhi29eddq5jn74ef1d3bhl1n', 1631288447),
(4, 'o4diuh1qfhiqmm385jrjgofu49', 1631385773),
(5, 'rh480kvalprhfo04i16i55ij0c', 1631545059),
(6, '838b7ijk7524gqflct9ccn1fvr', 1631640180),
(7, 'oal2f2irmvff7ibukghmffkg6o', 1631736637),
(8, 'a586mdjo12437k1tr58cj99sm4', 1631800688),
(9, 'upbs6d8bu8k99n94vs1a5fio9d', 1631816032),
(10, 'f28kvjq4pl17fsi0m4echtqi8g', 1631815905),
(11, '0t9mhordtigu00ieht764b0qdl', 1631894554);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
