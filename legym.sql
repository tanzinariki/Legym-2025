-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 03:36 AM
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
  `trainer_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reward` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `name`, `description`, `trainer_id`, `start_date`, `end_date`, `reward`) VALUES
(1, '7-Day Step Challenge', 'Walk or run a total of 50,000 steps in 7 days.', 1, '2025-03-15', '2025-03-21', 'gold##Top 3 performers#Free water Bottle'),
(2, 'Plank Endurance', 'Hold a plank position for a total of 30 minutes across 7 days.', 2, '2025-03-25', '2025-03-28', 'gold##Top 3 performers#Free water Bottle'),
(3, 'Daily Workout Streak', 'Complete a 30-minute workout every day for 7 days.', 3, '2025-03-25', '2025-03-31', 'top##Top 2 performers#Free Shoe'),
(4, 'Squat Challenge', 'Complete 500 squats in total within 7 days.', 4, '2025-03-26', '2025-04-03', 'gold##Top 3 performers#Free water Bottle'),
(5, '7-Day Step Challenge', 'Walk or run a total of 50,000 steps in 7 days.', 5, '2025-04-06', '2025-04-12', 'gold##Top 3 performers#Free water Bottle'),
(6, 'Plank Endurance', 'Hold a plank position for a total of 30 minutes across 7 days.', 6, '2025-04-06', '2025-04-08', 'gold##Top 3 performers#Free water Bottle'),
(7, 'Daily Workout Streak', 'Complete a 30-minute workout every day for 7 days.', 1, '2025-04-05', '2025-04-11', 'top##Top 2 performers#Free Shoe|gold##Top 3 performers#Free water Bottle'),
(8, 'Squat Challenge', 'Complete 500 squats in total within 7 days.', 2, '2025-04-07', '2025-04-13', 'gold##Top 3 performers#Free water Bottle'),
(9, '7-Day Step Challenge', 'Walk or run a total of 50,000 steps in 7 days.', 3, '2025-04-02', '2025-04-08', 'gold##Top 3 performers#Free water Bottle');

-- --------------------------------------------------------

--
-- Table structure for table `legym_class`
--

CREATE TABLE `legym_class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_description` text NOT NULL,
  `class_img` varchar(100) NOT NULL,
  `class_type` varchar(100) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `legym_class`
--

INSERT INTO `legym_class` (`id`, `class_name`, `class_description`, `class_img`, `class_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cardio Dance', 'Distinctive style, moves and music. Cardio Dance draws from a plethora of dance styles integrating new combinations of cardiovascular aerobics while toning. There’s stretching and some abdominal core work as well to top things off.', 'images/classes/inperson1.jpg', 'In-person', 'Active', '2025-03-21 01:07:37', '2025-03-21 01:07:37'),
(2, 'Zumba Fitness', 'Perfect for everybody and every body! Each Zumba® class is designed to bring people together to sweat it on. We take the \"work\" out of workout, by mixing low-intensity and high-intensity moves for an interval-style, calorie-burning dance fitness party.', 'images/classes/inperson3.jpg', 'In-person', 'Active', '2025-03-21 01:07:37', '2025-03-21 01:07:37'),
(3, 'Hard Core', 'A high intensity, cross-training session incorporating a blend of cardiovascular, strength and core exercises for an intense total body workout. I strive to make Hard Core as unique as possible, by coming up with creative and effective ways to challenge my participants. ', 'images/classes/inperson5.jpg', 'In-person', 'Active', '2025-03-21 01:09:33', '2025-03-21 01:09:33'),
(4, 'Strength & Conditioning', 'A challenging and vigorous class combining strength training and cardiovascular conditioning, using a mix of weights, bodyweight exercises, and heart-pumping circuits. Expect to work through a variety of movements that target all major muscle groups. ', 'images/classes/inperson2.jpg', 'In-person', 'Active', '2025-03-21 01:09:33', '2025-03-21 01:09:33'),
(5, 'Lengthen & Strengthen', 'Experience a 3 part workout that leaves your body feeling healthy and strong. Warm up your muscles and joints from head to toe with luxurious stretches.', 'images/classes/online1.jpg', 'Online', 'Active', '2025-03-21 01:12:08', '2025-03-21 01:12:08'),
(6, 'Meditation, Breathing & Movement', 'The class combines guided visualization, mindfulness, loving-kindness, imagery, reflective inquiry, storytelling, and breathing techniques. ', 'images/classes/online3.jpeg', 'Online', 'Active', '2025-03-21 01:12:08', '2025-03-21 01:12:08'),
(7, 'Zumba Toning', 'Zumba Toning is a variation of the Zumba Fitness workout. We Incorporate light weights to add resistance training and strengthening to the rhythm of Latin-inspired dance moves. ', '', 'Online', 'Active', '2025-03-21 01:14:38', '2025-03-21 01:14:38'),
(8, 'Total Body Fitness', 'The class is a combination of Yoga, Pilates, and low impact aerobics with approximately ten exercises per class. The exercises are designed to strengthen, as well as increase flexibility.', 'images/classes/online2.jpg', 'Online', 'Active', '2025-03-21 01:14:38', '2025-03-21 01:14:38'),
(9, 'Kinesis', 'Be prepared for a fun and dynamic overall body workout using Kinesis machines and various fitness equipment to keep your mind and body stimulated.', 'images/classes/inperson2.jpg', 'Online', 'Active', '2025-03-22 09:12:10', '2025-03-22 09:12:10');

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
(1, 'Basic Plan', 'Access to gym facilities|Basic fitness classes|Locker rental', 29.99, '20% off - Pro Shop Items, 15% off - Nutrition Products', 'Active', '2025-03-21 00:45:54', '2025-03-21 00:45:54'),
(2, 'Elite Plan', 'All Basic Feature|Personal Training Session|Premium Classes|Nutrition Consultation', 59.99, '20% off - Pro Shop Items, 15% off - Nutrition Products', 'Active', '2025-03-21 00:48:20', '2025-03-21 00:48:20'),
(3, 'Premium Plan', 'All Elite Feature|Unlimited Personal Training Sessions|Priority Booking|Guest Passes', 79.99, '20% off - Pro Shop Items, 15% off - Nutrition Products', 'Active', '2025-03-21 00:48:20', '2025-03-21 00:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `id` int(11) NOT NULL,
  `trainer_name` varchar(100) NOT NULL,
  `trainer_img` varchar(100) NOT NULL,
  `trainer_cert` text NOT NULL,
  `trainer_edu` text NOT NULL,
  `trainer_philosophy` text NOT NULL,
  `trainer_speciality` text NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`id`, `trainer_name`, `trainer_img`, `trainer_cert`, `trainer_edu`, `trainer_philosophy`, `trainer_speciality`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Damien Theo', 'images/trainers/Damien Theo.jpg', '<li>YMCA fitness instructor: Individual Conditioning</li>', '<li>Second year in Biochemistry Major​</li>', 'Physical exercise is an important factor that should be a part of everyone\'s life but also made to fit your goals and lifestyle. Hard work invested into developing your body and mind is the greatest thing one could do for themselves. Training is more than just looking better but feeling good on the inside and out.​  My goal as a trainer is to help you achieve your goals based on your desires and current level of fitness. I emphasize proper form and technique for injury prevention and progression that will help lead to the results you are happy with. I will help plan out your training specific to your needs and keep you motivated. I look forward to helping you succeed in your fitness endeavors while having fun.​', 'Increasing lean body mass for male and female​, Strength training​, Weight loss​, Conditioning', 'Active', '2025-03-21 01:20:58', '2025-03-21 01:20:58'),
(2, 'Kimiya Abyaneh', 'images/trainers/Kimiya Abyaneh.jpg', '<li>YMCA Personal Trainer Certification​</li>', '<li>Master in Electrical and Computer Engineering​ Concordia University</li>', 'I truly believe that fitness is so much more than just weights and treadmills. It is a journey that encompasses your entire being—mind, body, and spirit. It taps into your full potential, creates positive changes in your life, and establishes healthy habits that will last for the long haul. ​  ​As your personal trainer, my goal is to help make working out a habit and a hobby that brings your health and happiness. I will design a personalized workout plan, make sure that your exercise forms are right to prevent injuries, and guide you towards reaching your goals. It would be my pleasure to support you throughout your workout journey.', 'Strength Training​, Power Training​, Body Conditioning', 'Active', '2025-03-21 01:20:58', '2025-03-21 01:20:58'),
(3, 'Vila Woo', 'images/trainers/Vila Woo.jpg', '<li>Certified Personal Training Specialist, Can-Fit Pro</li><li>Attends workshops for professional development ​(e.g. Functional training, Yoga, Eccentrics, Nutrition)​</li>', '<li>Master in Education, Concordia University​</li>', 'VILA WOO (MA Education, BFA, PTS) has been part of Le Gym since 2007. She is an attentive and caring personal training specialist that brings multiple years of expertise in leading classes to all age groups and all levels.  ​  Vila\'s diverse skill sets help clients improve mobility, flexibility and posture.  Including strength training to high intensity training using various equipment making exercise fun and challenging.  Vila caters to women adapting to physical changes (peri/ menopause), and people with chronic diseases such as fibromyalgia and multiple sclerosis.    ​  Vila has a gift for helping people re/gain confidence through exercise.  She is an active listener and will guide you every step of the way to workout at your optimal (safely and with intention).  Vila strives to provide a happy experience to clients at Le Gym. ', 'Innovative circuit training, Fitness for 40+, Weight training​, Cardiovascular training, Flexibility and mobility', 'Active', '2025-03-21 01:22:56', '2025-03-21 01:22:56'),
(4, 'Jacek Pedryc', 'images/trainers/Jacek Pedryc.jpg', '<li>Athletic Therapist {CAT(C)}, Canadian Athletic Therapists Association</li><li>Sports First Responder, Canadian Red Cross</li><li>Strength and Conditioning Specialist, NSCA</li>', '<li>M.Sc. Applied Rehabilitation Science, McGill University, 2011</li><li>B.Sc. Exercise Science, Specialization in Athletic Therapy, Concordia University, 2001</li><li>Diploma, Pure & Applied Sciences, Dawson College, 1997</li><li>Diploma, Professional Massage Therapy, Isabella College</li>', 'I believe it is essential to treat each client as a unique individual. I take this approach because the key to success lies in understanding each client’s goals and expectations, present and past physical conditioning, and current motivations.  Considering these factors, I aim to help clients succeed by applying the most recent research findings in the field of exercise science to their program design.', 'Teaching Olympic lifting techniques, Designing programs for toning/weight modification and body building, Developing lifestyle modifications', 'Active', '2025-03-21 01:22:56', '2025-03-21 01:22:56'),
(5, 'George Roberts', 'images/trainers/George Roberts.jpg', '<li>Certification Entraînement Privé: CPEP Ataraxia Power Training</li><li>Can-Fit Pro CPTS, YMCA Fitness Instructor for Individual Conditioning</li><li>Master of Shaolin and Hung Gar Kung Fu, Chen Tai Chi instructor</li>', '', 'My interest in training began at a young age when I first discovered the body\'s ability to adapt to stress. Having had severe asthma as a child, it took hard work to improve my cardiovascular capacity enough to be permitted to participate in physical activities such as hockey and martial arts. Extensive training then allowed me to excel. After winning several worldwide competitions in North America and Asia, I was privileged to train with the monks at the Shaolin Temple in China.​  The drive to improve my performance in martial arts and hockey grew into a general passion for training, I have since researched and experimented with a variety of techniques to learn which training methods most effectively improve performance. I have come to believe that it is necessary to improve all aspects of fitness while following the progressive overload principle. To me, everything should follow a logical progression, and when working with clients, my aim is always to choose the most practical exercises possible to improve functional strength and mobility.', 'Athletic performance, strength, martial arts, endurance, improved ​mobility, increased lean muscle mass, and decreased body fat.', 'Active', '2025-03-21 01:23:33', '2025-03-21 01:23:33'),
(6, 'Simon Lussier', 'images/trainers/Simon Lussier.jpg', '<li>International Sports Science Association (ISSA) Personal Trainer Certification.​</li>', '<li>Business Marketing Diploma, 2023.</li><li>First Year Commerce Program, Concordia University.​</li>', 'The commitment to weight training is the single best investment you can make for your health, confidence and lifestyle. You will be amazed once you see and feel the physical progress you are capable of with the assistance of a professional trainer. The progress you will make with the weights will translate into your everyday life.​  Improvements such as increased energy, motivation and confidence are all positive side effects of a well-balanced fitness regimen.​  I will adopt a personal interest in helping you achieve your goals, whether that is to drop a few pounds off the scale, to increase your lean muscle mass, for physical and mental well-being, or to improve strength and power for sports.​  Through my journey,  I have gained eighty pounds of lean muscle and even coached myself to compete in a Toronto men’s physique competition in 2023. ​  Let\'s work together to achieve your goals.​', 'Increasing musculature for strength, lean body mass, conditioning and confidence. Resistance training, bodybuilding techniques, powerlifting techniques, body composition, weight loss', 'Active', '2025-03-21 01:23:33', '2025-03-21 01:23:33');

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
(1, 1, '2025-04-26', '07:00 PM - 09:00 PM'),
(2, 1, '2025-04-27', '03:00 PM - 05:00 PM'),
(3, 1, '2025-04-28', '03:00 PM - 05:00 PM'),
(4, 2, '2025-04-27', '05:00 PM - 07:00 PM'),
(5, 2, '2025-04-26', '07:00 PM - 09:00 PM'),
(6, 2, '2025-04-27', '03:00 PM - 05:00 PM'),
(7, 3, '2025-04-28', '03:00 PM - 05:00 PM'),
(8, 3, '2025-04-27', '04:00 PM - 06:00 PM'),
(9, 3, '2025-04-26', '07:00 PM - 09:00 PM'),
(10, 4, '2025-04-27', '06:00 PM - 08:00 PM'),
(11, 4, '2025-04-28', '03:00 PM - 05:00 PM'),
(12, 4, '2025-04-27', '04:00 PM - 06:00 PM'),
(13, 5, '2025-04-26', '07:00 PM - 09:00 PM'),
(14, 5, '2025-04-27', '02:00 PM - 04:00 PM'),
(15, 5, '2025-04-28', '03:00 PM - 05:00 PM'),
(16, 5, '2025-04-27', '04:00 PM - 06:00 PM');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `class_id`, `training_date`, `training_time`, `online_training_link`, `trainer_id`, `status`, `created_at`, `updated_at`, `total_seats`) VALUES
(1, 1, '2025-04-10', '10:00:00', NULL, 1, NULL, '2025-03-21 03:47:32', '2025-03-21 03:47:32', 5),
(2, 3, '2025-04-11', '11:00:00', NULL, 5, NULL, '2025-03-21 03:47:32', '2025-03-21 03:47:32', 4),
(3, 5, '2025-04-12', '13:00:00', 'https://zoom.us/j/1234567890', 4, NULL, '2025-03-21 03:49:49', '2025-03-21 03:49:49', 10),
(4, 6, '2025-04-10', '16:00:00', 'https://zoom.us/j/1234567890', 3, NULL, '2025-03-21 03:49:49', '2025-03-21 03:49:49', 8),
(5, 2, '2025-04-13', '11:00:00', NULL, 3, NULL, '2025-03-26 17:17:17', '2025-03-26 17:17:17', 10),
(6, 8, '2025-04-12', '11:00:00', 'https://zoom.us/j/1234567891', 4, NULL, '2025-03-26 17:17:17', '2025-03-26 17:17:17', 10),
(7, 4, '2025-04-14', '15:00:00', NULL, 2, 'Active', '2025-04-09 01:33:47', '2025-04-09 01:33:47', 8);

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
  `card_number` varchar(19) DEFAULT NULL,
  `card_expire_date` varchar(5) DEFAULT NULL,
  `card_cvv` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `fitness_goal`, `user_image`, `health_condition`, `membership_plan_id`, `membership_start_date`, `membership_end_date`, `status`, `created_at`, `updated_at`, `card_number`, `card_expire_date`, `card_cvv`) VALUES
(2, 'Claudia', 'Nasrin', 'aa@gmail.com', '$2y$10$65fU3URBWq0A9KtlHkJK4O1rd9ESSVplBOeOhupsfvGwVMuC9mExe', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:52:45', '2025-03-21 06:52:45', NULL, NULL, NULL),
(3, 'Oleg', 'Fuentes', 'gihuqameki@mailinator.com', '$2y$10$iM92EncKIMQ46/LWdH/n0e1pZMtqbOS1RIC3Docv.Dqr/omoPzvOS', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:55:13', '2025-03-21 06:55:13', NULL, NULL, NULL),
(4, 'Isabelle', 'Knight', 'app@help.com', '$2y$10$fORp9Xn/to4GVAhEvNZjH.aCmktGAGh//YJS.NHQge5Yz.5b//fD6', NULL, '', NULL, 2, '2025-03-23', '2026-03-22', 'Active', '2025-03-21 06:59:04', '2025-03-24 02:40:11', '1234-5678-9012-3456', '12/34', '123'),
(5, 'Kaseem', 'Petersen', 'vyresa@mailinator.com', '$2y$10$8Gr0/2iOQ0Bl110Sff30AuVvbj7tI0ZVYuHhoas9iXYv4zcmPjns6', NULL, '', NULL, NULL, NULL, NULL, NULL, '2025-03-21 11:21:55', '2025-03-21 11:21:55', NULL, NULL, NULL),
(6, 'Autumn', 'Kramer', 'cahowec@mailinator.com', '$2y$10$kvHXq2xtb9592JekiqaAROWT.Hhx.hceR0s4.BUWGXvKH5pH7pqiW', 'Weight Loss, Gain Muscle', '', 'Dolor voluptatem Se', NULL, NULL, NULL, NULL, '2025-03-21 11:27:23', '2025-03-21 11:27:23', NULL, NULL, NULL),
(7, 'Lucy', 'Branch', 'cawedulaje@mailinator.com', '$2y$10$snW8SyBT72i6EN/0UwO81OifjEInmdjWAvoxsB9GDgK1CW/hUA86a', '', '', 'Qui et fugit except', NULL, NULL, NULL, NULL, '2025-03-21 11:28:23', '2025-03-21 11:28:23', NULL, NULL, NULL),
(8, 'Jaquelyn', 'Boone', 'jijubor@mailinator.com', '$2y$10$6O.RYf3SjZNZfUxqDnyY1OAUnBtCFxMDHiefzpIuXU8AVru259rHm', 'Athelate Shape', '', 'Rerum non quasi inve', NULL, NULL, NULL, NULL, '2025-03-22 01:53:56', '2025-03-22 01:53:56', NULL, NULL, NULL),
(9, 'Tanni', 'Saima', 'ts@help.com', '$2y$10$5UpGIkkEm5DJ5l7miCxOQer0/ZCOHuPON9AWtatoFRLRezwGGIMPC', 'Weight Loss, Athelate Shape', '', 'no', 3, '2025-03-23', '2026-03-22', 'Active', '2025-03-22 02:13:43', '2025-03-24 01:24:14', '1234-5678-1234-5678', '11/22', '123'),
(10, 'Tanzina', 'Nasrin', 'nasrintanzina@gmail.com', '$2y$10$7onNxcp9vldmFPvhFZKoOOOHSeD9RCaZW4gGOyL6xcVjsQ42d2w2O', 'Weight Loss', '', 'Ashtma', 1, '2025-04-08', '2026-04-07', 'Active', '2025-03-26 16:58:01', '2025-04-09 01:20:06', '1112222233334445', '12/26', '3456'),
(11, 'Autumn', 'Gray', 'ag@mail.com', '$2y$10$PDXG03qMQ.9agkXLbsFa2eeEHL1iJCsfKYvsQATQd8nhcmSz2gTea', 'Weight Loss', '', 'Consequatur ullamco', 1, '2025-03-26', '2026-03-25', 'Active', '2025-03-26 19:39:59', '2025-03-26 19:40:53', '1234567854567554', '09/28', '4456');

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

--
-- Dumping data for table `user_challenges`
--

INSERT INTO `user_challenges` (`id`, `user_id`, `challenge_id`, `progress`, `joined_time`, `completion_time`, `status`) VALUES
(5, 10, 1, 100, '2025-03-25 01:12:42', NULL, 'joined'),
(10, 10, 2, 0, '2025-03-26 16:16:24', NULL, 'joined'),
(11, 10, 7, 10, '2025-04-08 01:12:42', NULL, 'joined'),
(12, 10, 8, 30, '2025-04-06 16:16:24', NULL, 'joined'),
(14, 10, 6, 0, '2025-04-08 12:10:43', NULL, 'joined'),
(15, 10, 5, 0, '2025-04-08 18:41:31', NULL, 'joined');

-- --------------------------------------------------------

--
-- Table structure for table `user_locker`
--

CREATE TABLE `user_locker` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `locker_id` int(11) NOT NULL,
  `rent_date` date NOT NULL,
  `rent_duration` varchar(100) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_locker`
--

INSERT INTO `user_locker` (`id`, `user_id`, `locker_id`, `rent_date`, `rent_duration`, `status`, `created_at`, `updated_at`) VALUES
(2, 9, 2, '2025-03-23', '09:00 AM - 11:00 AM', NULL, '2025-03-23 06:08:36', '2025-03-23 06:08:36'),
(3, 4, 3, '2025-03-23', '09:00 AM - 11:00 AM', NULL, '2025-03-23 06:08:36', '2025-03-23 06:08:36'),
(4, 5, 4, '2025-03-23', '09:00 AM - 11:00 AM', NULL, '2025-03-23 06:08:36', '2025-03-23 06:08:36'),
(5, 7, 5, '2025-03-23', '09:00 AM - 11:00 AM', NULL, '2025-03-23 06:08:36', '2025-03-23 06:08:36'),
(6, 8, 6, '2025-03-23', '09:00 AM - 11:00 AM', NULL, '2025-03-23 06:08:36', '2025-03-23 06:08:36'),
(7, 3, 1, '2025-03-23', '11:00 AM - 01:00 PM', NULL, '2025-03-23 06:08:36', '2025-03-23 06:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_personal_training`
--

CREATE TABLE `user_personal_training` (
  `id` int(11) NOT NULL,
  `trainer_availability_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cancel_at` datetime DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_personal_training`
--

INSERT INTO `user_personal_training` (`id`, `trainer_availability_id`, `user_id`, `booking_at`, `cancel_at`, `status`) VALUES
(9, 13, 9, '2025-03-26 20:14:49', NULL, 'Booked');

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
-- Dumping data for table `user_training`
--

INSERT INTO `user_training` (`id`, `training_id`, `user_id`, `booking_time`, `cancel_time`, `status`) VALUES
(6, 4, 4, '2025-03-23 02:41:06', NULL, 'Booked'),
(7, 1, 9, '2025-03-23 02:41:06', NULL, 'Booked'),
(8, 2, 9, '2025-03-23 02:41:06', NULL, 'Booked'),
(9, 3, 9, '2025-03-23 02:41:06', NULL, 'Booked'),
(10, 4, 9, '2025-03-23 02:41:06', NULL, 'Booked'),
(14, 5, 11, '2025-03-26 19:41:30', NULL, 'Booked');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `legym_class`
--
ALTER TABLE `legym_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trainer_availability`
--
ALTER TABLE `trainer_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_challenges`
--
ALTER TABLE `user_challenges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_locker`
--
ALTER TABLE `user_locker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_personal_training`
--
ALTER TABLE `user_personal_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_training`
--
ALTER TABLE `user_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
