-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 04:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legym`
--

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reward` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `name`, `description`, `start_date`, `end_date`, `reward`) VALUES
(1, '7-Day Step Challenge', 'Walk or run a total of 50,000 steps in 7 days.', '2025-03-22', '2025-03-28', 'Free water bottle'),
(2, 'Plank Endurance', 'Hold a plank position for a total of 30 minutes across 7 days.', '2025-03-22', '2025-03-28', 'Exclusive gym towel'),
(3, 'Daily Workout Streak', 'Complete a 30-minute workout every day for 7 days.', '2025-03-22', '2025-03-28', 'Gym discount coupon'),
(4, 'Squat Challenge', 'Complete 500 squats in total within 7 days.', '2025-03-22', '2025-03-28', 'Free protein bar');

-- --------------------------------------------------------

--
-- Table structure for table `legym_class`
--

CREATE TABLE `legym_class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_description` text NOT NULL,
  `class_type` varchar(100) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `legym_class`
--

INSERT INTO `legym_class` (`id`, `class_name`, `class_description`, `class_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cardio Dance', 'Distinctive style, moves and music. Cardio Dance draws from a plethora of dance styles integrating new combinations of cardiovascular aerobics while toning. There’s stretching (standing & floor) and some abdominal core work as well to top things off. If you enjoy dancing or would like more fluidity and coordination, this class can kick in your groove.', 'In-person', 'Active', '2025-03-21 01:07:37', '2025-03-21 01:07:37'),
(2, 'Zumba Fitness', 'Perfect for everybody and every body! Each Zumba® class is designed to bring people together to sweat it on. We take the \"work\" out of workout, by mixing low-intensity and high-intensity moves for an interval-style, calorie-burning dance fitness party. Once the Latin and World rhythms take over, you\'ll see why Zumba® fitness classes are often called exercise in disguise. A total workout, combining all elements of fitness – cardio, muscle conditioning, balance and flexibility, boosted energy and a serious dose of awesome each time you leave class.', 'In-person', 'Active', '2025-03-21 01:07:37', '2025-03-21 01:07:37'),
(3, 'Hard Core', 'A high intensity, cross-training session incorporating a blend of cardiovascular, strength and core exercises for an intense total body workout. I strive to make Hard Core as unique as possible, by coming up with creative and effective ways to challenge and strengthen my participants. Expect lots of variety to challenge all fitness levels, and be prepared to sweat! ', 'In-person', 'Active', '2025-03-21 01:09:33', '2025-03-21 01:09:33'),
(4, 'Strength & Conditioning', 'A challenging and vigorous class combining strength training and cardiovascular conditioning, using a mix of weights, bodyweight exercises, and heart-pumping circuits. Expect to work through a variety of movements that target all major muscle groups while keeping your heart rate elevated to torch calories, build muscle, and improve cardiovascular health.', 'In-person', 'Active', '2025-03-21 01:09:33', '2025-03-21 01:09:33'),
(5, 'Lengthen & Strengthen', 'Experience a 3 part workout that leaves your body feeling healthy and strong.\r\nWarm up your muscles and joints from head to toe with luxurious stretches. \r\nStrengthen your core, upper and lower body using body weight and equipment easily accessible from home  (such as a chair, a wall, a towel, and a stick).  Learn proper form and technique, and how to train safe. Be prepared to activate your muscles and feel the burn.\r\nCool down with deep stretching to help improve flexibility and mobility. ', 'Online', 'Active', '2025-03-21 01:12:08', '2025-03-21 01:12:08'),
(6, 'Meditation, Breathing & Movement', 'The first half of the class combines guided visualization, mindfulness, loving-kindness, imagery, reflective inquiry, storytelling, and breathing techniques. You\'ll experience the CABCs: Check-in with yourself, Align the body, Breathe, and Check-in again. This approach allows you to tune into your inner world and define your own self-soothing techniques. In the second half of the class, you\'ll transition into a soothing body scan, gentle, restorative stretching and joint mobilization and conclude with a gentle relaxation.', 'Online', 'Active', '2025-03-21 01:12:08', '2025-03-21 01:12:08'),
(7, 'Zumba Toning', 'Zumba Toning is a variation of the Zumba Fitness workout. We Incorporate light weights (1 to 3 lbs. max.) to add resistance training and strengthening to the rhythm of Latin-inspired dance moves and international music beats. The classes feature several minutes of cardio work interspersed with strength training, targeting specific muscle groups, working core, abs and arms. ', 'Online', 'Active', '2025-03-21 01:14:38', '2025-03-21 01:14:38'),
(8, 'Total Body Fitness', 'The class is a combination of Yoga, Pilates, and low impact aerobics with approximately ten exercises per class. \r\nThe exercises are designed to strengthen, as well as increase flexibility.  Some exercises are on the floor, the others are in a standing position.\r\nThe class is fast moving and fun and the exercises are adaptable to be appropriate for all levels of fitness.\r\n ', 'Online', 'Active', '2025-03-21 01:14:38', '2025-03-21 01:14:38');

-- --------------------------------------------------------

--
-- Table structure for table `locker`
--

CREATE TABLE `locker` (
  `id` int(11) NOT NULL,
  `locker_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locker`
--

INSERT INTO `locker` (`id`, `locker_name`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'B1'),
(4, 'B2'),
(5, 'C1'),
(6, 'C2');

-- --------------------------------------------------------

--
-- Table structure for table `membership_plan`
--

CREATE TABLE `membership_plan` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `plan_benefit` text NOT NULL,
  `plan_cost` double NOT NULL,
  `plan_discounts` text DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_plan`
--

INSERT INTO `membership_plan` (`id`, `plan_name`, `plan_benefit`, `plan_cost`, `plan_discounts`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Basic Plan', 'Access to gym facilities, Basic fitness classes, Locker rental', 29.9, '20% off - Pro Shop Items, 15% off - Nutrition Products', 'Active', '2025-03-21 00:45:54', '2025-03-21 00:45:54'),
(2, 'Elite Plan', 'All Basic Feature, Personal Training Session, Premium Classes, Nutrition Consultation', 59.9, '20% off - Pro Shop Items, 15% off - Nutrition Products', 'Active', '2025-03-21 00:48:20', '2025-03-21 00:48:20'),
(3, 'Premium Plan', 'All Elite Feature, Unlimited Personal Training Sessions, Priority Booking, Guest Passes', 79.9, '20% off - Pro Shop Items, 15% off - Nutrition Products', 'Active', '2025-03-21 00:48:20', '2025-03-21 00:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `id` int(11) NOT NULL,
  `trainer_name` varchar(100) NOT NULL,
  `trainer_speciality` text NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`id`, `trainer_name`, `trainer_speciality`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Damien Theo', 'Increasing lean body mass for male and female​, Strength training​, Weight loss​, Conditioning', 'Active', '2025-03-21 01:20:58', '2025-03-21 01:20:58'),
(2, 'Kimiya Abyaneh', 'Strength Training​, Power Training​, Body Conditioning', 'Active', '2025-03-21 01:20:58', '2025-03-21 01:20:58'),
(3, 'Vila Woo', 'Innovative circuit training, Fitness for 40+, Weight training​, Cardiovascular training, Flexibility and mobility', 'Active', '2025-03-21 01:22:56', '2025-03-21 01:22:56'),
(4, 'Jacek Pedryc', 'Teaching Olympic lifting techniques, Designing programs for toning/weight modification and body building, Developing lifestyle modifications', 'Active', '2025-03-21 01:22:56', '2025-03-21 01:22:56'),
(5, 'George Roberts', 'Athletic performance, strength, martial arts, endurance, improved ​mobility, increased lean muscle mass, and decreased body fat.', 'Active', '2025-03-21 01:23:33', '2025-03-21 01:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `trainer_availability`
--

CREATE TABLE `trainer_availability` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer_availability`
--

INSERT INTO `trainer_availability` (`id`, `trainer_id`, `date`, `timeslot`) VALUES
(1, 1, '2025-03-26', '09:00 AM - 11:00 AM'),
(2, 1, '2025-03-22', '03:00 PM - 05:00 PM'),
(3, 5, '2025-03-22', '03:00 PM - 05:00 PM'),
(4, 5, '2025-03-24', '04:00 PM - 06:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `training_date` date NOT NULL,
  `training_time` time NOT NULL,
  `online_training_link` varchar(100) DEFAULT NULL,
  `trainer_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `class_id`, `training_date`, `training_time`, `online_training_link`, `trainer_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-03-24', '10:00:00', NULL, 1, NULL, '2025-03-21 03:47:32', '2025-03-21 03:47:32'),
(2, 3, '2025-03-27', '11:00:00', NULL, 5, NULL, '2025-03-21 03:47:32', '2025-03-21 03:47:32'),
(3, 5, '2025-03-28', '13:00:00', 'https://zoom.us/j/1234567890', 4, NULL, '2025-03-21 03:49:49', '2025-03-21 03:49:49'),
(4, 6, '2025-03-29', '16:00:00', 'https://zoom.us/j/1234567890', 3, NULL, '2025-03-21 03:49:49', '2025-03-21 03:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fitness_goal` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) NOT NULL,
  `health_condition` text DEFAULT NULL,
  `membership_plan_id` int(11) DEFAULT NULL,
  `membership_start_date` date DEFAULT NULL,
  `membership_end_date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `card_number` int(11) DEFAULT NULL,
  `card_expire_date` date DEFAULT NULL,
  `card_cvv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `fitness_goal`, `user_image`, `health_condition`, `membership_plan_id`, `membership_start_date`, `membership_end_date`, `status`, `created_at`, `updated_at`, `card_number`, `card_expire_date`, `card_cvv`) VALUES
(1, 'Tanzina', 'Nasrin', 'nasrintanzina@gmail.com', '$2y$10$hCT3msBSyRk0zN1V12uoDOqhy8KWe9j/zmYKPVstHZiS2Q7C0QekW', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 05:13:58', '2025-03-21 05:13:58', NULL, NULL, NULL),
(2, 'Claudia', 'Nasrin', 'aa@gmail.com', '$2y$10$65fU3URBWq0A9KtlHkJK4O1rd9ESSVplBOeOhupsfvGwVMuC9mExe', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:52:45', '2025-03-21 06:52:45', NULL, NULL, NULL),
(3, 'Oleg', 'Fuentes', 'gihuqameki@mailinator.com', '$2y$10$iM92EncKIMQ46/LWdH/n0e1pZMtqbOS1RIC3Docv.Dqr/omoPzvOS', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:55:13', '2025-03-21 06:55:13', NULL, NULL, NULL),
(4, 'Isabelle', 'Knight', 'app@help.com', '$2y$10$fORp9Xn/to4GVAhEvNZjH.aCmktGAGh//YJS.NHQge5Yz.5b//fD6', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:59:04', '2025-03-21 06:59:04', NULL, NULL, NULL),
(5, 'Kaseem', 'Petersen', 'vyresa@mailinator.com', '$2y$10$8Gr0/2iOQ0Bl110Sff30AuVvbj7tI0ZVYuHhoas9iXYv4zcmPjns6', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 11:21:55', '2025-03-21 11:21:55', NULL, NULL, NULL),
(6, 'Autumn', 'Kramer', 'cahowec@mailinator.com', '$2y$10$kvHXq2xtb9592JekiqaAROWT.Hhx.hceR0s4.BUWGXvKH5pH7pqiW', 'Weight Loss, Gain Muscle', '', 'Dolor voluptatem Se', NULL, NULL, NULL, NULL, '2025-03-21 11:27:23', '2025-03-21 11:27:23', NULL, NULL, NULL),
(7, 'Lucy', 'Branch', 'cawedulaje@mailinator.com', '$2y$10$snW8SyBT72i6EN/0UwO81OifjEInmdjWAvoxsB9GDgK1CW/hUA86a', '', '', 'Qui et fugit except', NULL, NULL, NULL, NULL, '2025-03-21 11:28:23', '2025-03-21 11:28:23', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_challenges`
--

CREATE TABLE `user_challenges` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `challenge_id` int(11) NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `joined_time` datetime DEFAULT NULL,
  `completion_time` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_locker`
--

CREATE TABLE `user_locker` (
  `id` int(11) NOT NULL,
  `locker_id` int(11) NOT NULL,
  `rent_date` date NOT NULL,
  `rent_duration` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_personal_training`
--

CREATE TABLE `user_personal_training` (
  `id` int(11) NOT NULL,
  `trainer_availability_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cancel_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_training`
--

CREATE TABLE `user_training` (
  `id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `cancel_time` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legym_class`
--
ALTER TABLE `legym_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locker`
--
ALTER TABLE `locker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_plan`
--
ALTER TABLE `membership_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainer_availability`
--
ALTER TABLE `trainer_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership_plan_id` (`membership_plan_id`);

--
-- Indexes for table `user_challenges`
--
ALTER TABLE `user_challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `challenge_id` (`challenge_id`);

--
-- Indexes for table `user_locker`
--
ALTER TABLE `user_locker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locker_id` (`locker_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_personal_training`
--
ALTER TABLE `user_personal_training`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_availability_id` (`trainer_availability_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_training`
--
ALTER TABLE `user_training`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_id` (`training_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `legym_class`
--
ALTER TABLE `legym_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `locker`
--
ALTER TABLE `locker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `membership_plan`
--
ALTER TABLE `membership_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trainer_availability`
--
ALTER TABLE `trainer_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_challenges`
--
ALTER TABLE `user_challenges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_locker`
--
ALTER TABLE `user_locker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_personal_training`
--
ALTER TABLE `user_personal_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_training`
--
ALTER TABLE `user_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trainer_availability`
--
ALTER TABLE `trainer_availability`
  ADD CONSTRAINT `trainer_availability_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`id`);

--
-- Constraints for table `training`
--
ALTER TABLE `training`
  ADD CONSTRAINT `training_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `legym_class` (`id`),
  ADD CONSTRAINT `training_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`membership_plan_id`) REFERENCES `membership_plan` (`id`);

--
-- Constraints for table `user_challenges`
--
ALTER TABLE `user_challenges`
  ADD CONSTRAINT `user_challenges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_challenges_ibfk_2` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`);

--
-- Constraints for table `user_locker`
--
ALTER TABLE `user_locker`
  ADD CONSTRAINT `user_locker_ibfk_1` FOREIGN KEY (`locker_id`) REFERENCES `locker` (`id`),
  ADD CONSTRAINT `user_locker_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_personal_training`
--
ALTER TABLE `user_personal_training`
  ADD CONSTRAINT `user_personal_training_ibfk_1` FOREIGN KEY (`trainer_availability_id`) REFERENCES `trainer_availability` (`id`),
  ADD CONSTRAINT `user_personal_training_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_training`
--
ALTER TABLE `user_training`
  ADD CONSTRAINT `user_training_ibfk_1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`),
  ADD CONSTRAINT `user_training_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
