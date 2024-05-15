-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2024 at 09:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diagnostics_and_medicine_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `addr`
--

CREATE TABLE `addr` (
  `addr_id` int(6) NOT NULL,
  `user_type` text NOT NULL,
  `user_id` int(6) NOT NULL,
  `user_name` text NOT NULL,
  `addr_phn` varchar(10) NOT NULL,
  `addr_email` text NOT NULL,
  `addr_line` text NOT NULL,
  `addr_city` text NOT NULL,
  `addr_landmark` text NOT NULL,
  `addr_state` text NOT NULL,
  `addr_district` text NOT NULL,
  `addr_pin` varchar(6) NOT NULL,
  `addr_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addr`
--

INSERT INTO `addr` (`addr_id`, `user_type`, `user_id`, `user_name`, `addr_phn`, `addr_email`, `addr_line`, `addr_city`, `addr_landmark`, `addr_state`, `addr_district`, `addr_pin`, `addr_status`) VALUES
(19, 'patient', 10, 'Riya Barman', '8597217314', 'riyabarmanslkclg@gmail.com', 'sitalkuchi', 'coochbehar', 'cbi atm', 'West Bengal', 'Cooch Behar', '736158', 1),
(20, 'patient', 1, 'Protap Barman', '8327507847', 'yoyobprotap@gmail.com', 'Sitalkuchi', 'CoochBehar', 'CBI Atm', 'West Bengal', 'Cooch Behar', '736158', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `b_id` int(6) NOT NULL,
  `a_id` int(6) NOT NULL,
  `b_total_amnt` int(6) NOT NULL,
  `o_id` int(6) DEFAULT NULL,
  `b_pay_amnt` int(11) NOT NULL,
  `time` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `c_id` int(6) NOT NULL,
  `p_id` int(6) DEFAULT NULL,
  `c_product_table` varchar(8) DEFAULT NULL,
  `c_product_id` int(11) DEFAULT NULL,
  `c_qty` int(11) DEFAULT 1,
  `c_added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`c_id`, `p_id`, `c_product_table`, `c_product_id`, `c_qty`, `c_added_at`) VALUES
(159, 7, 'medicine', 1, 2, '2024-02-22 05:44:11'),
(160, 7, 'test', 2, 1, '2024-02-19 09:34:28'),
(327, 1, 'test', 7, 1, '2024-03-17 07:06:23'),
(328, 1, 'medicine', 18, 2, '2024-03-21 19:22:43'),
(329, 1, 'package', 9, 1, '2024-03-21 19:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ct_id` int(6) NOT NULL,
  `ct_name` text NOT NULL,
  `ct_image` text DEFAULT NULL,
  `ct_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ct_id`, `ct_name`, `ct_image`, `ct_status`) VALUES
(1, 'N/A', NULL, 1),
(5, 'Baby Care', '2327baby_care.jpg', 1),
(6, 'Personal Care', '9440personal_care.jpg', 1),
(7, 'Health Drinks & Supplements', '2300drinks and supplements.jpg', 1),
(8, 'Skin Care', '9391skin_care.jpg', 1),
(10, 'Multivitamins', '2984multivitamin.jpg', 1),
(11, 'Health Devices', '2668health_devices.jpg', 1),
(12, 'Oral Hygiene', '8620tooth.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `d_id` int(6) NOT NULL,
  `d_uname` varchar(64) NOT NULL,
  `d_name` varchar(64) NOT NULL,
  `d_dob` date NOT NULL,
  `d_gen` varchar(6) NOT NULL,
  `d_addr` text NOT NULL,
  `d_email` varchar(64) DEFAULT NULL,
  `d_phn` varchar(10) NOT NULL,
  `d_pass` varchar(32) NOT NULL,
  `d_visit_fee` int(6) NOT NULL,
  `d_online_fee` int(6) NOT NULL,
  `sp_id` int(6) NOT NULL,
  `d_join_date` date NOT NULL,
  `d_qualif` text NOT NULL,
  `d_hospital` text DEFAULT NULL,
  `d_expernc` int(2) NOT NULL,
  `d_image` text DEFAULT NULL,
  `d_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`d_id`, `d_uname`, `d_name`, `d_dob`, `d_gen`, `d_addr`, `d_email`, `d_phn`, `d_pass`, `d_visit_fee`, `d_online_fee`, `sp_id`, `d_join_date`, `d_qualif`, `d_hospital`, `d_expernc`, `d_image`, `d_status`) VALUES
(12, '', 'Dr. Emily Johnson', '2000-01-08', 'Male', 'a123 Oak Street, Cityville, State, Zip Code', 'doctor@doctor.doctor', '8327507847', 'e2fc714c4727ee9395f324cd2e7f331f', 800, 400, 2, '2024-03-01', 'achelor of Medicine, Bachelor of Surgery (MBBS),Doctor of Medicine (MD), University of State Medical School,', 'City General Hospit', 6, '7379doctor3.png', 1),
(13, '', 'Dr. Jessica Wang', '2011-07-08', 'Female', '987 Cedar Avenue, Suburbia,WB, 123456', 'jwang_md@example.com', '5552345678', '81dc9bdb52d04dc20036dbd8313ed055', 0, 600, 2, '2024-01-17', 'Bachelor of Medicine, Bachelor of Surgery (MBBS) - Suburbia Medical College Doctor of Medicine (MD) - University of State Medical School', 'Suburbia Medical Center', 10, '9124doctor2.png', 1),
(14, '', 'Dr. Christopher Lee', '1986-12-06', 'Male', '321 Elm Street, Hamletown, UP, 998877', 'clee_doctor@example.com', '5554567890', 'e132e96a5ddad6da8b07bba6f6131fef', 800, 1200, 3, '2023-10-06', 'Bachelor of Medicine, Bachelor of Surgery (MBBS),  Dermatologist - Hamletown Family Clinic', 'Hamletown Family Clinic', 20, '9114doctor1.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doc_appointment`
--

CREATE TABLE `doc_appointment` (
  `doc_a_id` int(6) NOT NULL,
  `p_id` int(6) NOT NULL,
  `p_name` text NOT NULL,
  `p_email` text NOT NULL,
  `p_phn` varchar(10) NOT NULL,
  `p_dob` date NOT NULL,
  `p_gender` varchar(6) NOT NULL,
  `d_id` int(6) NOT NULL,
  `doc_a_note` text NOT NULL,
  `d_shift_time` time NOT NULL,
  `doc_a_create_time` datetime NOT NULL DEFAULT current_timestamp(),
  `doc_a_date` date NOT NULL,
  `doc_a_time` time NOT NULL,
  `doc_a_mode` varchar(10) NOT NULL,
  `doc_a_fee` int(6) NOT NULL,
  `doc_a_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doc_appointment`
--

INSERT INTO `doc_appointment` (`doc_a_id`, `p_id`, `p_name`, `p_email`, `p_phn`, `p_dob`, `p_gender`, `d_id`, `doc_a_note`, `d_shift_time`, `doc_a_create_time`, `doc_a_date`, `doc_a_time`, `doc_a_mode`, `doc_a_fee`, `doc_a_status`) VALUES
(4, 1, 'Patient 1', 'yoyobprotap@gmail.com', '1234567890', '1996-10-16', 'Male', 12, 'sudden chest pain', '07:00:00', '2024-03-06 13:39:57', '2024-03-09', '07:00:00', 'offline', 800, 'confirmed'),
(5, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 13, 'Write here...', '09:00:00', '2024-03-06 14:16:18', '2024-03-07', '09:00:00', 'online', 600, 'confirmed'),
(6, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 14, 'Write here...', '12:00:00', '2024-03-06 14:17:25', '2024-03-07', '12:00:00', 'online', 1200, 'confirmed'),
(7, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 12, 'this is my problem', '18:00:00', '2024-03-07 20:17:23', '2024-03-08', '18:00:00', 'online', 400, 'confirmed'),
(8, 1, 'Riya Barman', 'yoyobprotap@gmail.com', '8597217314', '2024-03-15', 'Female', 12, 'this is my problem 2', '18:00:00', '2024-03-07 20:18:15', '2024-03-08', '18:10:00', 'online', 400, 'confirmed'),
(9, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 12, 'Write here...', '18:00:00', '2024-03-12 23:13:55', '2024-03-13', '18:00:00', 'online', 400, 'confirmed'),
(10, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 13, 'Write here...', '09:00:00', '2024-03-16 13:04:57', '2024-03-17', '09:00:00', 'online', 600, 'confirmed'),
(11, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 13, 'Write here...', '09:00:00', '2024-03-16 13:06:41', '2024-03-17', '09:30:00', 'online', 600, 'confirmed'),
(12, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 13, 'Write here...', '09:00:00', '2024-03-16 13:07:00', '2024-03-17', '10:00:00', 'online', 600, 'confirmed'),
(13, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 12, 'Write here...', '07:00:00', '2024-03-16 13:07:12', '2024-03-17', '07:00:00', 'offline', 800, 'confirmed'),
(14, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 12, 'Write here...', '18:00:00', '2024-03-16 13:07:24', '2024-03-17', '18:00:00', 'online', 400, 'confirmed'),
(15, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 12, 'Write here...', '18:00:00', '2024-03-16 13:07:32', '2024-03-17', '18:10:00', 'online', 400, 'confirmed'),
(16, 1, 'Protap Barman', 'yoyobprotap@gmail.com', '8327507847', '1999-10-13', 'Male', 12, 'Write here...', '18:00:00', '2024-03-16 13:07:42', '2024-03-18', '18:00:00', 'online', 400, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `doc_schedule`
--

CREATE TABLE `doc_schedule` (
  `sc_id` int(6) NOT NULL,
  `d_id` int(6) DEFAULT NULL,
  `sc_shift_type` text DEFAULT NULL,
  `sc_shift_start` time DEFAULT NULL,
  `sc_shift_end` time DEFAULT NULL,
  `sc_patient_duration` int(3) DEFAULT NULL,
  `sc_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doc_schedule`
--

INSERT INTO `doc_schedule` (`sc_id`, `d_id`, `sc_shift_type`, `sc_shift_start`, `sc_shift_end`, `sc_patient_duration`, `sc_status`) VALUES
(9, 12, 'online', '18:00:00', '22:00:00', 10, 1),
(10, 12, 'offline', '07:00:00', '14:00:00', 15, 1),
(11, 13, 'online', '09:00:00', '17:00:00', 30, 1),
(12, 13, 'offline', '18:00:00', '22:00:00', 5, 0),
(13, 14, 'online', '12:00:00', '16:00:00', 20, 1),
(14, 14, 'offline', '18:00:00', '20:00:00', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab_appointment`
--

CREATE TABLE `lab_appointment` (
  `lab_id` int(11) NOT NULL,
  `lab_app_date` date DEFAULT NULL,
  `lab_app_time` time NOT NULL,
  `lab_type` varchar(7) NOT NULL,
  `p_id` int(6) NOT NULL,
  `p_phn` varchar(10) NOT NULL,
  `p_email` text NOT NULL,
  `lab_fee` int(11) NOT NULL,
  `lab_create_time` datetime NOT NULL,
  `lab_status` varchar(30) NOT NULL DEFAULT 'request recieved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_appointment`
--

INSERT INTO `lab_appointment` (`lab_id`, `lab_app_date`, `lab_app_time`, `lab_type`, `p_id`, `p_phn`, `p_email`, `lab_fee`, `lab_create_time`, `lab_status`) VALUES
(2, '2024-03-10', '07:04:00', 'package', 1, '8327507847', 'yoyobprotap@gmail.com', 161, '2024-03-10 23:47:37', 'completed'),
(3, '2024-03-10', '00:00:00', 'test', 1, '8327507847', 'yoyobprotap@gmail.com', 200, '2024-03-10 23:53:32', 'request recieved'),
(6, '2024-03-11', '18:00:00', 'test', 1, '8327507847', 'yoyobprotap@gmail.com', 100, '2024-03-11 00:18:39', 'confirmed'),
(7, '2024-03-11', '00:00:00', 'test', 1, '8327507847', 'yoyobprotap@gmail.com', 111, '2024-03-11 02:22:32', 'request recieved'),
(8, '2024-03-11', '00:00:00', 'test', 1, '8327507847', 'yoyobprotap@gmail.com', 119, '2024-03-12 23:30:19', 'request recieved'),
(9, '2024-03-11', '00:00:00', 'package', 1, '8327507847', 'yoyobprotap@gmail.com', 3999, '2024-03-16 19:47:15', 'request recieved');

-- --------------------------------------------------------

--
-- Table structure for table `lab_app_details`
--

CREATE TABLE `lab_app_details` (
  `lab_d_id` int(6) NOT NULL,
  `lab_id` int(6) NOT NULL,
  `p_id` int(6) NOT NULL,
  `lab_d_product_id` int(6) NOT NULL,
  `lab_d_product_type` varchar(7) NOT NULL,
  `lab_d_product_price` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_app_details`
--

INSERT INTO `lab_app_details` (`lab_d_id`, `lab_id`, `p_id`, `lab_d_product_id`, `lab_d_product_type`, `lab_d_product_price`) VALUES
(1, 2, 1, 3, 'package', 11),
(2, 2, 1, 6, 'package', 150),
(3, 3, 1, 2, 'test', 100),
(4, 3, 1, 3, 'test', 100),
(9, 6, 1, 4, 'test', 100),
(10, 6, 1, 3, 'test', 100),
(11, 7, 1, 5, 'test', 11),
(12, 7, 1, 4, 'test', 100),
(13, 8, 1, 7, 'test', 119),
(14, 9, 1, 9, 'package', 3999);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `m_id` int(6) NOT NULL,
  `m_name` text NOT NULL,
  `m_compose` text NOT NULL,
  `m_type` varchar(128) DEFAULT NULL,
  `m_short_descr` text DEFAULT NULL,
  `m_descr` text DEFAULT NULL,
  `m_direction` varchar(255) DEFAULT NULL,
  `m_image` text DEFAULT NULL,
  `m_mfg_by` varchar(255) DEFAULT NULL,
  `m_mfg_date` date NOT NULL,
  `m_exp_date` date NOT NULL,
  `m_mrp` int(6) NOT NULL,
  `m_price` int(6) NOT NULL,
  `qty_per_unit` float DEFAULT NULL,
  `m_unit` text DEFAULT NULL,
  `ct_id` int(6) DEFAULT NULL,
  `m_sc_id` int(6) NOT NULL,
  `sp_id` int(6) NOT NULL,
  `mt_id` int(11) DEFAULT NULL,
  `m_qty` int(6) NOT NULL,
  `m_gender_spec` varchar(6) DEFAULT NULL,
  `m_age_grp` varchar(64) DEFAULT NULL,
  `m_side_effect` text DEFAULT NULL,
  `m_status` tinyint(1) NOT NULL,
  `order_count` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`m_id`, `m_name`, `m_compose`, `m_type`, `m_short_descr`, `m_descr`, `m_direction`, `m_image`, `m_mfg_by`, `m_mfg_date`, `m_exp_date`, `m_mrp`, `m_price`, `qty_per_unit`, `m_unit`, `ct_id`, `m_sc_id`, `sp_id`, `mt_id`, `m_qty`, `m_gender_spec`, `m_age_grp`, `m_side_effect`, `m_status`, `order_count`) VALUES
(13, 'GNC Women\\\'s One Daily Multivitamin', '37 essential Nutrients and minerals.', 'Oral', 'GNC Women\'s One Daily Multivitamin Tablet is ultra-concentrated with 37 important nutrients. It also provides 20 vitamins & minerals at 100% daily value or more.', 'Promotes healthy hair, skin & nails with beauty blend of biotin, collagen & silica.\r\nFeatures B-Vitamins to support energy production & metabolism.\r\nAdvanced health blends for skin, heart, brain & eye support.', 'Ideal for adults between the age 19 years and 50 years to help support their daily nutritional needs. One tablet a day is enough to meet your daily nutrient requirement and is helpful in supporting metabolism and natural wear and tear of muscles.', '6344gnc_multivitamin.png', 'GUARDIAN HEALTHCARE SERVICES PVT LTD', '2024-02-27', '2024-03-02', 1449, 899, 30, 'tablet', 10, 1, 1, 1, 38, 'Female', 'Above 18 years', 'It is highly recommended that you talk to your doctor before taking any multivitamins. If you have any medical conditions then make sure you tell the doctor. Your doctor might suggest some alternate as some ingredients can interfere with medications.\r\nIt is advised that if you notice any allergic reactions, then you must immediately stop taking this multivitamin and seek medical help.\r\nStop consuming multivitamins 2 weeks before any surgery.', 1, 2),
(14, 'Zandu Pancharishta Ayurvedic Digestive Tonic', 'a,b,c,d,e', 'Syrup', 'Ayurvedic proprietary medicine. Formulated to aid in digestion and promote overall gut health. Helps in relieving various digestive disorders and improving digestion. Contains natural ingredients known for their digestive benefits.', 'Say goodbye to digestive discomfort and hello to a healthier gut with Zandu Pancharishta Syrup. Specially formulated to aid digestion and promote overall gut health, the unique Zandu Pancharishta Digestive Tonic is your natural solution for digestive disorders.\r\n\r\nWith a powerful blend of key ingredients like Amla, Ajwain, Saunf, Dhania, and Gulab, Zandu Pancharishta Syrup provides you with the perfect balance of nature\'s goodness.\r\n\r\nExperience the natural way to improve digestion and achieve better overall well-being. Grab your bottle of Zandu Pancharishta today and discover the wonders of Ayurveda!', 'Shake the bottle well before use. Take 2-3 teaspoons (approximately 15-20ml) of Zandu Pancharishta Syrup after meals. Can be taken twice a day or as directed by a doctor.', '8235zanduPacnchalis.png', 'EMAMI LTD', '2024-02-28', '2024-03-02', 200, 165, 650, 'ml', 1, 1, 9, 6, 32, 'All', 'Above 12 years', 'Consult a doctor before using if you are pregnant, breastfeeding, have any medical conditions, or taking any medications. \r\nKeep out of reach of children.\r\nStore in a cool and dry place.\r\nDo not exceed the recommended dosage.\r\nIn case of any adverse reactions or allergies, discontinue use and seek medical attention.', 1, 3),
(16, 'Endura Mass', 'Maltodextrin, Whey Protein Concentrate, Soy Protein Isolate, Skimmed Milk Powder, Sugar, Edible Vegetable Oil, Whole Milk Powder, Soy Fiber, Emulsifying Agents (INS 322, INS 472), Vitamins, Minerals, Approved Flavors, Preservatives.', 'Oral', 'Endura Mass Chocolate Flavour Powder, 500 gm', 'Endura Mass is a weight gain, energy-dense formula which offers a balanced blend of nutrients to individuals seeking to gain the right body weight. This weight-gain expert provides superior quality, easy-to-absorb proteins, carbohydrates, vitamins and minerals. It is an easy and convenient way to meet high-calorie daily requirements as it nourishes the body with vital nutrients to provide enough energy to get through the daily routine. A well-balanced diet supplemented by Endura Mass with regular exercises and the right lifestyle helps attain the desired results. It is a vegetarian product with no side effects and can be used by anyone who wishes to gain weight in a healthy way.', 'Add 30g of Endura Mass with 180 ml of water/milk to a shaker. Shake it well and consume. You can take it 1-3 times daily, depending on your age and activity level.  Dosage  The recommended dosage for children aged ten years and above is 30 g of Endura Mas', '4808endura.jpg', 'CIPLA HEALTH LTD', '2024-01-15', '2024-08-15', 584, 533, 500, 'gm', 7, 19, 1, 1, 199, 'All', '18-60 years', 'This product is not to be used by pregnant, nursing, and lactating women or children under ten years and elderly, except when medically advised by physicians or certified dieticians or nutrition professionals.\r\nIt contains soy and milk ingredients.\r\nKeep it out of reach of children and pets. \r\nStore in a cool, dry place, protected from moisture, heat, and direct sunlight.', 1, 1),
(17, 'Be Bodywise Hair Health Gummies', 'Contains biotin, zinc, and multivitamins\r\nStrawberry flavored\r\nNo gluten, added sugar, preservatives, or artificial colours\r\n100% vegan.', 'Oral', 'Be Bodywise Hair Health Gummies, 30 Count', 'Introducing Be Bodywise Hair Health Gummies! These delicious strawberry-flavoured gummies are packed with essential nutrients to help you achieve healthy and beautiful hair. Bodywise Hair Gummies work from within to improve your hair\'s texture, density, and strength.\r\n\r\nSay goodbye to hair fall and hello to a nourished scalp! The Bodywise Gummies for hair are carefully formulated to provide you with the nutrients needed to promote hair growth and reduce hair fall. Be Bodywise Hair Health Gummies are 100% vegan and free from gluten, added sugar, preservatives, and artificial colours.', 'Take one gummy daily after a meal. Chew thoroughly before swallowing.', '3694bodywise.jpg', 'MOSAIC WELLNESS PRIVATE LIMITED', '2024-01-15', '2024-08-15', 499, 474, 30, 'tablet', 6, 1, 1, 1, 200, 'All', 'All', 'Store in a cool and dry place.\r\nKeep out of reach of children and pets.\r\nConsult with a healthcare professional before incorporating these Bodywise hair gummies into your routine.', 1, 0),
(18, 'Horlicks Classic Malt Flavour', 'Packed with 27 essential nutrients\r\nContains clinically proven micronutrients\r\nEnriched with 11 gm of protein\r\nInfused with 741 mg calcium and 26 mg iron\r\nMalt flavour.', 'Oral', 'Horlicks Classic Malt Flavour Nutrition Drink Powder, 500 gm Jar', 'Horlicks powder is a nutrient-rich composition that contributes to reducing micronutrient insufficiency when included regularly in a balanced diet and healthy lifestyle. Horlicks malt powder contains 27 vital nutrients and plays a crucial role in nurturing bone density, increasing muscle development, improving focus and concentration. This aids children in becoming taller, stronger, and sharper. Additionally, Horlicks malt powder has been clinically validated to support immunity, enhance the power of milk, and incorporate nutrients that are easily absorbed into the bloodstream. Thus, Horlicks benefit the overall growth and development of the body. The classic malt flavour of the drink also makes it a popular choice among kids as well as adults.', 'Take 200 ml of hot or cold, milk or water. Add 27 g of Horlicks powder, roughly equating to 3 spoonfuls. Stir quickly until the powder is well dissolved.', '5348hor.jpg', 'HINDUSTAN UNILEVER LIMITED', '2024-01-15', '2024-09-15', 294, 274, 500, 'gm', 7, 19, 1, 1, 200, 'All', 'All', 'If you\'re allergic to any of the ingredients in Horlicks malt powder, it\'s advisable to avoid it.\r\nAlways follow the recommended intake to prevent any potential side effects.\r\nDo not use it if the pouch inside is damaged or open.\r\nStore in a cool, dry place away from sunlight.', 1, 0),
(19, 'Pediasure Complete, Balanced Nutrition', 'Skim milk powder, sucrose, EDIBLE VEGETABLE OIL(soy oil, high oleic sunflower oil), maltodextrin, medium chain triglyceride (MCT) oil, fructo-oligosaccharides (FOS) (2%), flavoring, minerals, Vitamins, m-inositol, taurine, Lactobacillus acidophilus (0.01%), L-carnitine, Bifidobacterium spp (0.0035%)', 'Oral', 'Pediasure Complete, Balanced Nutrition Premium Chocolate Flavour Nutrition Drink 1kg', 'Pediasure is a nutritional supplement that provides complete, balanced nutrition for children 2 years and above, those special years of rapid growth and development.', 'To prepare a 225ml serving, pour 190ml of pre-boiled water into a cup. Gradually mix in 5 levelled scoops or 45.5g of PediaSure powder. Mixing with water greater than 35 degrees C may compromise the benefits of the probiotics. Once mixed, PediaSure should', '2908pedia.jpg', 'ABBOTT HEALTHCARE PVT LTD', '2024-01-15', '2024-12-15', 1605, 1605, 1, 'unit', 7, 19, 1, 1, 200, 'All', '5-12 years', 'The product is not an infant milk substitute or infant food.\r\nIt is for children of 2 years and above.\r\nNot for children with galactosemia or lactose intolerance.\r\nNot for intravenous use.', 1, 0),
(20, 'Similac Infant Formula Stage 1 Powder', 'Whole milk powder, lactose, maltodextrin, edible vegetable oil (soy oil, high oleic sunflower oil, coconut oil), whey protein concentrate, VITAMINS***, MINERALS**, taurine, potassium citrate (acidity regulator), L-carnitine, antioxidant (mixed tocopherols). INGREDIENTS ON PREPARATION: Water, whole milk powder, lactose, maltodextrin, edible vegetable oil (soy oil, high oleic sunflower oil, coconut oil), whey protein concentrate, VITAMINS***, MINERALS**, taurine, potassium citrate (acidity regulator), L-carnitine, antioxidant (mixed tocopherols).', 'Oral', 'Similac Infant Formula Stage 1 Powder (Up to 6 Months), 400 gm Refill Pack', 'Similac Infant Formula Stage 1 - Upto 6 months Similac 1 is a spray dried stage 1 infant milk substitute for infants upto 6 months. It is designed to support normal growth and development. For over 85 years, Similac from Abbott Nutrition has set the standards for science-based infant nutrition and has been nourishing millions of babies worldwide.', 'Similac Infant Formula Stage 1 - Upto 6 months Similac 1 is a spray dried stage 1 infant milk substitute for infants upto 6 months. It is designed to support normal growth and development. For over 85 years, Similac from Abbott Nutrition has set the stand', '5450simi.jpg', 'ABBOTT HEALTHCARE PVT LTD', '2024-01-15', '2024-12-15', 600, 584, 400, 'gm', 7, 19, 1, 1, 195, 'All', '6 months', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 1, 5),
(21, 'Horlicks Diabetes Plus', 'Milk Solids, Dietary Fibre(26%),[Wheat Dextrin(18%),Corn Dextrin(8%)], Maltodextrin, Minerals, Nature Identical Flavouring Substances, Soy Protein Isolate, Medium Chain Triglycerides(MCT) Oil, Vitamins, Artificial Sweetener (INS 950.).', 'Oral', 'Milk Solids, Dietary Fibre(26%),[Wheat Dextrin(18%),Corn Dextrin(8%)], Maltodextrin, Minerals, Nature Identical Flavouring Substances, Soy Protein Isolate, Medium Chain Triglycerides(MCT) Oil, Vitamins, Artificial Sweetener (INS 950.).', 'Horlicks Diabetes Plus is a nutritional beverage which has been designed for Indian adults. It is scientifically formulated to support dietary management of at risk and diabetic individuals.\r\n\r\nIt contains high fibre (22% of dual blend fibre - Fibersol-2 and Nutriose®^ ).\r\n\r\nResearch has shown that diet rich in fibre helps reduce glucose and lipids in blood*. Horlicks Diabetes Plus is high in protein and contains 16 vital nutrients. These fibres are known to promote satiety and reduce calorie intake. \r\n\r\n#Soluble dietary fibre taken as a part of diet contributes to reduction of blood cholesterol levels. \r\n\r\nThe beneficial effect is obtained with daily intake of minimum 3 g of soluble dietary fibre.\r\n\r\n*Journal of Diabetes and Metabolism;2020 Feb;11(2):841.\r\n\r\nNUTRIOSE® is a registered trademark of Roquette Frères\r\n\r\n^NUTRIOSE® and Fibersol-2 are trade names for Wheat fibre dextrin & Corn fibre dextrin respectively.\r\n\r\nHorlicks Diabetes Plus contains artificial sweetner and for calorie concious.\r\n\r\nFood for special dietary use - food for helping manage blood glucose.\r\n\r\nContains added flavour (nature-identical flavouring substances).', 'Take 200 ml of hot milk or water. Add 30 g (approx.2 levelled scoops) of Horlicks Diabetes Plus. Stir quickly to mix well. Recommended serving: 30 g, once a day.', '1401diabetis.jpg', 'Take 200 ml of hot milk or water. Add 30 g (approx.2 levelled scoops) of Horlicks Diabetes Plus. Stir quickly to mix well. Recommended serving: 30 g, once a day.', '2024-01-15', '2024-08-15', 710, 699, 400, 'gm', 7, 19, 12, 1, 200, 'All', '18-60 years', 'Pregnant and lactating women, infants, children, and adolescents and people with specific medical condition to consume under medical advice.\r\nNot for medicinal use.\r\nNot for parenteral use.\r\nThis contains acesulfame potassium.\r\nThis product is not intended to prevent, diagnose, cure or treat any disease.\r\nHorlicks Diabetes Plus is not intended to replace any existing medication. It is a nutritional beverage to be consumed as a part of balanced daily diet and exercise.\r\nDo not consume this product if you are allergic to milk, soy and wheat.\r\nPlease store the product out of reach of the children.\r\nNot to exceed recommended serve.\r\nFor oral administration only.', 1, 0),
(22, 'Nicogum 2', 'NULL.', 'Capsule', 'Nicogum 2 Nicotine Gum Freshmint Flavour, 12 Chewing Gums', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 'chew when you want fresh breath', '3199nico.jpg', 'CIPLA HEALTH LTD', '2024-01-15', '2024-08-15', 121, 115, 12, 'tablet', 7, 19, 1, 1, 150, 'All', 'All', 'There is no side effects.', 1, 0),
(23, 'Prolyte ORS Mixed Fruit', 'W.H.O. recommended oral rehydration formula Enriched with dextrose for an energy boost Ready-to-drink formula Refreshing mixed fruit flavour Convenient to use and carry on-the-go', 'Syrup', 'Prolyte ORS Mixed Fruit Flavour Energy Drink, 200 ml', 'The Prolyte O.R.S. Mixed Fruit Flavour Energy Drink helps battle dehydration. This Cipla Prolyte energy drink is a ready-to-drink concoction packed with essential electrolytes. It\'s designed to restore body fluids and crucial electrolytes often lost due to dehydration, offering instant hydration and an energy boost.\r\n\r\nThis Prolyte energy drink helps maintain electrolyte balance and forestalls dehydration. Not only does this drink have rehydrating and replenishing properties due to its key ingredients like sodium, chloride, potassium, citrate, and dextrose, but it also helps alleviate stress, fatigue and pain. It is instrumental in managing symptoms such as diarrhoea and vomiting, often resulting in water loss and electrolytes.\r\n\r\nAdditionally, this Cipla prolyte energy drink is a refreshing and rejuvenating O.R.S. beverage that is convenient and ready to use. It is worth noting that this energy drink is a W.H.O. recommended formula for restoring body fluids and electrolytes lost due to dehydration.', 'Shake the Prolyte energy drink tetra pack before use. Directly drink from the pack with the help of a straw. Consume within 24 hours after opening to ensure freshness and effectiveness. Flavour', '6784orsfruit.jpg', 'CIPLA HEALTH LTD', '2024-01-15', '2024-08-15', 31, 29, 200, 'ml', 7, 19, 1, 1, 100, 'All', 'All', 'Instantly Replenishes Hydration: Cipla Prolyte energy drink offers a convenient solution for dehydration with its ready-to-drink formula. It swiftly restores body fluids and essential electrolytes lost due to dehydration, facilitating immediate recovery.\r\nSupports Optimal Body Function: This Prolyte energy drink hydrates and helps maintain electrolyte balance. Regular consumption ensures the replenishment of essential electrolytes crucial for sustaining proper body function.\r\nBeat the Heat in Summer: Cipla Prolyte energy drink is an excellent choice to combat the heat and prevent dehydration, especially during summer. Its refreshing mixed fruit flavour makes it an ideal companion on hot days.\r\nAids in Diarrhoea and Vomiting Management: This oral rehydration solution is crucial in controlling diarrhoea, vomiting, and the loss of water and electrolytes. It effectively restores body fluids lost during these conditions, promoting swift recovery.\r\nAlleviates Fatigue: Beyond hydration, this Prolyte energy drink reduces fatigue and relieves stress and tiredness. It revitalises the body by replenishing lost energy, keeping you active and refreshed.', 1, 0),
(24, 'Maxirich Multivitamin', 'CALCIUM D PANTOTHENATE-1MG + CALCIUM-75MG + COPPER0.45MG-50MCG + FOLIC ACID-0.075MG + IODINE-14.1MG + LECITHIN-3MG + MAGNESIUM-0.5MG + MANGANESE-0.1MG + MOLYBDENUM-15MG + NICOTINAMIDE-58MG + PHOSPHOROUS-2MG + POTASSIUM-1600IU + VITAMIN A-1MG + VITAMIN B1-0.5MCG + VITAMIN B12-1MG + VITAMIN B2-0.5MG + VITAMIN B6-25MG + VITAMIN C-100IU + VITAMIN D3-5IU + VITAMIN E-0.5MG + ZINC', 'Capsule', 'Maxirich Multivitamin & Minerals Softgel, 10 Capsules', 'Maxirich Capsule is a nutritional supplement with multi minerals and multivitamin that treats weakness & lethargyRich in Calcium, Phosphorous, Vitamin C, Nicotinamide, Magnesium, Potassium , Vitamin B1, Vitamin B2 , Calcium Pantothenate, Vitamin B6 , Manganese, Zinc , Folic Acid, Vitamin B12, Copper, Molybdenum, Iodine, Vitamin A, Vitamin D3 , Vitamin E Acetate\r\nVitamin B complex improves appetite, treats weakness & lethargy\r\nPhosphorus is the main component of ATP which is the fundamental energy source, protects bones and fights against osteomalacia', 'As directed by the physician', '4597max.jpg', 'CIPLA LTD', '2024-01-15', '2024-08-15', 119, 113, 10, 'tablet', 7, 19, 1, 1, 150, 'All', '18-60 years', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 1, 0),
(25, 'Similac Total Comfort Infant', 'Edible Vegetable Oils (High Oleic Sunflower Oil, Soy Oil, Coconut Oil),Whey Protein Hydrolysate,Soy Lecithin,Arachidonic Acid (Aa) From M. Alpina Oil,Docosahexaenoic Acid (Dha) From C. Cohnii Oil,L-Phenylalanine,Choline Chloride,Nucleotides,Monophosphate,L-Carnitine,Potassium Citrate,', 'Oral', 'Similac Total Comfort Infant Formula Powder (Up to 6 Months), 350 gm', 'Similac Total Comfort is a specially designed Infant milk formula containing 100% whey protein that is easy-to-digest and is gentle on baby’s sensitive tummies and an easy-to-digest fat blend with no palm olein oil for softer stools. These ingredients help in the management of common gastrointestinal discomforts like Colic, fussiness, gassiness, constipation, spit-up, vomiting.', 'Use as directed by your baby\'s physician. Proper hygiene, handling and storage are important when preparing follow-up formula. Failure to follow these instructions can potentially lead to adverse effects on the health of your baby. Powdered follow-up form', '3373simi1.jpg', 'ABBOTT HEALTHCARE PVT LTD', '2024-01-15', '2024-07-15', 935, 899, 350, 'gm', 7, 19, 1, 1, 150, 'All', '6 months', 'Store in a cool and dry place\r\nAlways keep the product tightly covered after every use\r\nUse the product within the given time period as mentioned on the product\r\nDo not freeze the powder and avoid excessive heating', 1, 0),
(26, 'Pure Nutrition Vitamin C', 'Vitamin C, Amla and Orange peel extracts.', 'Tablet', 'Pure Nutrition Vitamin C 1250 mg, 60 Tablets', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 'null', '2597c.jpg', 'ERBS NUTRIPRODUCTS PVT LTD', '2024-01-15', '2024-08-15', 509, 484, 60, 'tablet', 10, 17, 1, 1, 200, 'All', '18-60 years', 'null', 1, 0),
(27, 'Power Gummies Vitamins for Dapper Hair & Beard Gummies', 'Biotin, Beta-Sitosterol, Fenugreek Extract, Vitamin A, B12, C & E, Folic Acid, Zinc, Copper, Selenium.', 'Oral', 'Power Gummies Vitamins for Dapper Hair & Beard Gummies with Biotin for Him, 60 Count', 'This potent pack of gummies stimulates the body’s keratin production to give fuller, thicker, and better beards.\r\nIt optimally increases follicle production for dense new hair growth for the beard and head\r\nThis powerful blend minimizes hair thinning or hair shedding with a delay in beard discolouration with the power of biotin.\r\nIt revives the hair volume reversing the complete hair loss with the keratin power.', 'Take 2 gummies per day.', '3910gummi.jpg', 'AESTHETIC NUTRITION PVT. LTD.', '2024-01-15', '2024-08-15', 1200, 1140, 60, 'tablet', 7, 19, 1, 1, 150, 'All', 'All', 'Read the product label carefully before use.\r\nStore in a cool and dry place away from direct sunlight.\r\nKeep out of reach of children.\r\nConsult a doctor before taking any supplement.\r\nDo not exceed the recommended dosage.\r\nPregnant or nursing mothers, children, and people with medical conditions must consult a physician before taking this supplement.\r\nConsult your doctor before use if you are pregnant, nursing, taking any medication, planning any surgical or medical procedure or suffering from a medical condition.\r\nDiscontinue use if any allergic reaction occurs.', 1, 0),
(28, 'Ultra D3', 'CHOLESTYRAMINE\r\nCARBAMAZEPINE\r\nPHENOBARBITAL\r\nDOXYCYCLINE\r\nNEOMYCIN\r\nCHLORAMPHENICOL\r\nALENDRONATE SODIUM\r\nLEVOTHYROXINE\r\nHYDROCHLOROTHIAZIDE\r\nDIGOXIN', 'Drop', 'Ultra D3 Drops 15 ml', 'Ultra D3 Drops 15 ml belongs to the class of \'Vitamins\', primarily used to treat low blood calcium levels. Ultra D3 Drops 15 ml effectively treats various conditions in the body like Vitamin D deficiency, osteoporosis (weak and brittle bones), hypoparathyroidism (parathyroid glands make low levels of calcium in the body), latent tetany (a muscle disease with low blood calcium levels) and rickets or osteomalacia (softening or deforming of bones due to lack of calcium). Vitamin D deficiency occurs when your body has low Vitamin D levels and is caused due to inadequate nutrition, intestinal malabsorption or lack of sunlight exposure.\r\n\r\nUltra D3 Drops 15 ml contains \'Cholecalciferol\' a form of vitamin-D. It acts by promoting the absorption of calcium, phosphates and Vitamin A from different organs and helps in maintaining overall health.\r\n\r\nTake Ultra D3 Drops 15 ml as advised. Your physician will decide the dosage based on your medical condition. Ultra D3 Drops 15 ml is likely safe to consume. In some cases, it may cause side effects like constipation, increased blood calcium levels, increased calcium levels in urine, vomiting, nausea. These side effects do not require medical attention and gradually resolve over time. If these side effects persist, please consult your physician immediately.\r\n\r\nTell your physician if you are allergic to Ultra D3 Drops 15 ml. Chewable or dissolving tablets may contain sugar or aspartame, hence caution should be taken in diabetes and phenylketonuria (increased levels of an amino acid called phenylalanine). Pregnant or breastfeeding women should consult their physician before taking Ultra D3 Drops 15 ml. Higher doses of Vitamin D than the recommended daily dose should be used in pregnant women only when advised by the doctor. Ultra D3 Drops 15 ml passes into the breast milk, hence breastfeeding mothers need to seek medical advice before starting Ultra D3 Drops 15 ml. Ultra D3 Drops 15 ml is safe to use in children when recommended by the pediatrician. Ultra D3 Drops 15 ml should be used with caution in hypercalcemia, renal impairment, heart diseases, kidney stones and hypervitaminosis D (having too much vitamin D).', 'Tablet/Capsule/Extended-release tablet: Take it with or without food as advised by the physician. Swallow it as a whole with a glass of water. Do not crush, chew or break it. Chewable tablet: Chew the tablet completely and swallow. Do not swallow it as a ', '7765ultra.jpg', 'MEYER ORGANICS PVT LTD', '2024-01-15', '2024-08-15', 43, 41, 15, 'ml', 7, 19, 1, 1, 200, 'All', 'All', 'Constipation\r\n Increased blood calcium levels\r\n Increased calcium levels in urine\r\n Vomiting\r\n Nausea\r\nChest pain, feeling short of breath', 1, 0),
(29, 'Fast&Up Plant Based B12 + B-Complex,', 'B12 + B-complex', 'Tablet', 'Fast&Up Plant Based B12 + B-Complex, 60 Tablets', 'USDA Organic Certified and packed with plant power, Fast&Up B12 + B-complex provides high quality and vegan B12 + B-complex which contributes to fulfil our body’s 100% vitamin B12 requirements. In addition, it also contains nutrient dense whole food powder.\r\n\r\nB12 + B-complex together helps in supporting energy and red blood cell production along with supporting brain and nervous system functions.  Fast&Up B-12 + B-Complex provides Methylcobalamin, which is active and natural form of Vitamin B12 as compared to Cyanocobalamin, which is manmade or synthetic form available in the market.', 'Consume 1 tablet with water, post any meal.', '5138b12.jpg', 'AERONUTRIX SPORTS PRODUCTS PVT LTD', '2024-01-15', '2024-08-15', 875, 835, 60, 'gm', 10, 21, 1, 1, 100, 'All', '18-60 years', 'USDA organic certified plant based B12 + B-complex with organic wholefood vitamins, natural methylcobalamin and 100% RDA of Vitamin B12.\r\n100% vegan with no added sugar, artificial colours, preservatives and is non-GMO, gluten free and soy free.\r\nVitamin B-12 + B-complex helps in supporting brain/nervous system functions, red blood cells, energy production and reduce tiredness and lethargy\r\nIdeal for vegans and vegetarians, Fast&Up B12 + B-complex with superior nutrient absorption and bioavailability contributes to fulfil 100% vitamin B-12 requirements.', 1, 0),
(30, 'Zincovit Tablet', 'Sugar, Microcrystalline Cellulose (460(i)), Vitamins, Talc (553(iii)), Grape Seed Extract, Calcium Carbonate (170(i)), Stabilizer (468), Minerals, Binders (1401, 1202, 1201), Silicon Dioxide (551), Disodium EDTA, Permitted Symbiotic Food Colour(214), Coating Agents (901, 462).', 'Tablet', 'Zincovit Tablet 15\'s', 'Give your body a nutritional boost with the multivitamin and multimineral Zincovit Tablet that is specially formulated to support the overall body functioning. The essential vitamins and minerals support the healthy functioning of the heart, nervous system, immune system, etc. It also has Grape Seed extracts that are loaded with antioxidant properties and help in reducing the cell damage caused by free radicals.', 'Take the dosage as prescribed by your physician.', '8975zin.jpg', 'Apex Laboratories Pvt Ltd', '2024-01-15', '2024-08-15', 93, 88, 15, 'tablet', 7, 19, 1, 1, 100, 'All', '18-60 years', 'If you have any existing medical conditions or other medications, consult your doctor before taking the medication.\r\nIf you notice any unusual reactions after taking the medication, discontinue use and seek medical help.\r\nCheck the expiration date before use.\r\nKeep it away from the reach of children.\r\nStore in a cool, dry, and hygienic place.', 1, 0),
(31, 'Ourdaily Vitamin E', 'Tocopheryl Acetate IP - 400 mg, Excepients-q.s.', 'Capsule', 'Ourdaily Vitamin E 400 mg, 10 Soft Gelatin Capsules', 'It is a vitamin E supplement that promotes healthy skin, nourishes scalp and hair and maintains eye health along with providing anti-oxidant support.', 'Please consult your physician to know the best dosage that would suit your case best.', '4005vitaminE.jpg', 'PIRAMAL PHARMA LIMITED', '2024-01-15', '2024-08-15', 42, 40, 10, 'tablet', 7, 19, 1, 1, 100, 'All', '18-60 years', 'Read the label carefully before use.\r\nStore in a cool dry place away from direct sunlight.', 1, 0),
(32, 'Revital H Complete', 'Copper, Iodine, Blend of Ginseng Root Extract, Vitamin A, B1, B2, B3, B6, B12, C, D & E, Folic Acid, Calcium, Phosphorous, Zinc, Iron, Magnesium, Potassium, Manganese.', 'Tablet', 'Revital H Complete Multivitamin for Men, 30 Capsules', 'The Revital capsule, specifically designed for men, is a comprehensive multivitamin supplement that aims to enhance overall health and support an active lifestyle. This balanced blend of natural ginseng, 10 vitamins and 9 minerals aids in filling nutritional gaps, contributing to general well-being.\r\n\r\nA key feature of the Revital men multivitamin capsule is its potential to boost energy and improve stamina, owing to its enriched components like natural ginseng, vitamin B complex and iron. These ingredients not only help sustain your energy throughout the day but also combat fatigue. The daily essential vitamins and minerals such as vitamins C, D and zinc work in unison to bolster immunity, thereby preventing frequent illness. Additionally, magnesium along with ginseng optimises mental alertness and concentration while enhancing your ability to manage stress.', 'Take one Revital capsule daily after a meal. Accompany it with a glass of drinking water or any other liquid of your choice. It\'s important to remember to take a break of 15 days after 3 months of continued usage. Always follow the directions as instructe', '6326revital.jpg', 'SUN PHARMACEUTICAL INDUSTRIES LTD', '2024-01-15', '2024-08-15', 330, 313, 30, 'tablet', 7, 19, 1, 1, 200, 'All', '18-60 years', 'Do not exceed the daily recommended dose of Revital men multivitamin capsules.\r\nConsult a doctor immediately in case of accidental overdose; symptoms may include gastric upset, headache, and increased heart rate.\r\nContains allergens such as soy and nuts.\r\nPolyols in the composition may have laxative effects.\r\nThe Revital capsule is not for medicinal use.', 1, 0),
(33, 'Revital H Woman,', 'Revital H Woman Contains Ginseng, 12 Vitamins And 10 Minerals.', 'Tablet', 'Revital H Woman, 30 Tablets', 'The Revital H Woman Tablet is a dedicated health supplement for women, densely packed with a range of vitamins, minerals, and ginseng root extract. This supplement specifically caters to women’s nutritional requirements – all in one compact tablet. The inclusion of essential vitamins like A, B, C, D3, E, and K1 along with minerals such as zinc, copper, iron, calcium and more makes this product quite versatile. It\'s not just about physical well-being. Regular consumption of the Revital H Tablet also supports mental health by improving concentration and reducing stress levels. It helps in boosting immunity and energy levels while enhancing skin health due to the presence of biotin and antioxidants. Furthermore, these tablets contribute to bone strength and may reduce the incidence of joint pain. Overall, this product is aimed at improving the quality of life for women in a comprehensive manner.', 'Take one tablet daily after your meal. Have the tablet with a glass of water or any other liquid of your choice. After 3 months, give a break of 15 days before you continue taking the tablets. Always follow the physician\'s directions.', '8695revital_women.jpg', 'SUN PHARMACEUTICAL INDUSTRIES LTD', '2024-01-15', '2024-01-15', 400, 380, 30, 'tablet', 7, 19, 1, 1, 200, 'Female', '18-60 years', 'Do not exceed the recommended daily dose.\r\nIn case of accidental overdose, consult a doctor immediately. Symptoms could include gastric upset, headache and increased heart rate.\r\nKeep out of reach of children\r\nStore in a cool and a dry place. away from sunlight.\r\nThis is a health supplement and not meant for medicinal use.', 1, 0),
(34, 'Wellbeing Nutrition Melts Into Multivitamins', 'Organic Fruit & Vegetable Blend 120mg, VegaDElight Organic Vitamin D3 (from Vegan Lichen), vitaMK-7 Natural Vitamin K2 55mcg.', 'Others', 'Wellbeing Nutrition Melts Into Multivitamins Frozen Tropical Berry Flavour, 30 Strips', 'Wellbeing Nutrition Melts® Kids Multivitamins are packed with the power of 18 essential nutrients, including iron, zinc and essential multivitamins that are vital for your kid\'s growth. A daily dose of this tropical berry-flavored multivitamin will help improve immunity and metabolism, boost memory, cognition and power growth & development.\r\n\r\nMade up of carefully sourced, 100% natural ingredients that are USDA organic certified, such as organic guava, organic amla, organic curry leaf, organic papaya leaf & fruit, organic holy basil, organic lemon, organic fenugreek, organic moringa and organic spirulina. These work wonders with organic Vitamin D3, the only vegan source of vitamin D, and vitaMK-7®, a natural, soy and chemical-free Vitamin K2.\r\n\r\nVitamin A supports normal growth and development and tissue and bone repair that\'s vital for kids 6 years and above. Vitamin Bs are very important for metabolism, promote the healthy development of the brain and the body, and also give your kids energy.\r\n\r\nVitamin C and zinc work together to fight off infections and boost immunity. Iron helps build healthy tissue and organs. Iodine helps increase metabolism.\r\n\r\nParents love our melts® kids multivitamin because of:\r\n\r\nNo allergens.\r\nZero sugar.\r\nEasy to consume.\r\nBetter nutrient absorption.\r\nNo preservatives.\r\nNo lactose/gluten/soy/nuts.\r\nNo water needed.\r\nNo swallowing difficulties.', 'Take 1 melts strip daily after meals. Place a melts strip on the tongue and allow it to dissolve.', '1457frozen.jpg', 'WELLBEING NUTRITION', '2024-01-15', '2024-08-15', 594, 564, 30, 'unit', 10, 17, 1, 1, 100, 'All', 'Above 18 years', 'Store in a cool and dry place.', 1, 0),
(35, 'Calorich M Tablet', 'Calcium Citrate Malate, Calcitriol, Methylcobalamin, Magnesium Hydroxide, Zinc Sulphate Monohydrate, Vitamin K2-7.', 'Tablet', 'Calorich M Tablet 15\'s', 'null', 'null', '5913calorich.jpg', 'Zee Laboratories Ltd', '2024-01-15', '2024-12-15', 215, 200, 15, 'tablet', 7, 19, 1, 1, 150, 'All', '18-60 years', 'null', 1, 0),
(36, 'Calcimax P Tablet', 'Tribasic Calcium Phosphate, Magnesium Oxide, Bulking Agent [460 (i)], Polyvinylpyrrolidone (1201), Coating Agents [464, 1520, 553 (iii)], Zinc Sulphate, Ergocalciferol (Microencapsulated), Magnesium Stearate [470 (iii)], Maize Starch, Sodium Starch Glycolate, Cupric Sulphate, Manganese Sulphate, Sodium Selenite.', 'Tablet', 'Calcimax P Tablet 15\'s', 'Calcimax P tablet is a calcium phosphorus tablet that serves multiple roles in supporting our bodies\' wellbeing. These tablets are particularly useful for strengthening bones and are beneficial in managing conditions like osteoporosis, rickets, and osteomalacia. Calcimax P tablet uses essential minerals like calcium and phosphorus, facilitating their absorption in the body. It\'s not just about intake though; this tablet ensures the body efficiently utilises these minerals, helping prevent low calcium levels.\r\n\r\nWith vitamin D as part of its formulation, it aids in processing these minerals for better bone health. Additionally, calcium plays a crucial role in the normal functioning of nerves, cells, muscles, and bones and is vital for people who don\'t get enough calcium from their diet. All in all, the Calcimax P tablet helps in maintaining the body\'s balance and health. It is suitable for vegetarians and comes in a convenient tablet form.', 'Keep out of reach of children. The Calcimax P tablet is not for medicinal use and is not intended to diagnose, treat, cure or prevent any disease(s). Polyols present in the Calcimax P tablet may have laxative effects. Store the tablets below 25°C, in a dr', '2693calcimax.jpg', 'MEYER ORGANICS PVT LTD', '2024-01-15', '2024-08-15', 207, 189, 15, 'tablet', 7, 19, 1, 1, 100, 'All', '18-60 years', 'Keep out of reach of children.\r\nThe Calcimax P tablet is not for medicinal use and is not intended to diagnose, treat, cure or prevent any disease(s).\r\nPolyols present in the Calcimax P tablet may have laxative effects.\r\nStore the tablets below 25°C, in a dry place protected from light.\r\nMay contain nuts and sulphites which could trigger allergic reactions in susceptible individuals.', 1, 0),
(37, 'Prenatal Tablet', 'Calciu carbonate, Iron, Zinc, Vitamin C, Nicotinamide, Vitamin E, Vitamin B6, Folic Acid, Vitamin B12, Starch, Dicalcium Phosphate, Lactose, Preservatives (INS 217, INS 219), Glidant (E 572), Anticaking Agent (INS 553(iii)), Stabilizer (INS 466), Binding Agent (INS 1201), Colour (INS 110).', 'Tablet', 'Prenatal Tablet 10\'s', 'Prenatal tablet is a nutritional supplement for mothers-to-be that safeguards nutritional needs during pregnancy. It contains essential vitamins and minerals to provide comprehensive nutritional support throughout the pregnancy. It provides a source of nourishment for the mother and the baby and prevents premature birth. It is composed of Calcium, Vitamin B6, Vitamin B12, Vitamin C, Vitamin E, Folic acid, Iron, Nicotinamide, and Zinc.', 'Take it in the dose and duration prescribed by your doctor. Please do not take more than the daily recommended dosage. Swallow the tablet as a whole with a glass of water, preferably with meals or as directed by the physician. Do not try to break/crush/ch', '3788ppppp.jpg', 'Wyeth Lederle Ltd', '2024-01-15', '2024-08-15', 164, 159, 10, 'tablet', 7, 19, 1, 1, 100, 'Female', '18-60 years', 'Before starting the medication, let your doctor know if you have any liver, kidney or heart problems and other pre-existing medical conditions.\r\nIf you experience any unusual symptoms or allergic reactions whilst taking the medicine, please discontinue the use and consult your doctor immediately.\r\nLet your doctor know if you have any surgery scheduled before starting the medication.\r\nInform your doctor in advance if you are pregnant, planning to conceive or breastfeeding before starting the medication.\r\nIf you feel dizzy/sleepy while using this medicine, it is advised to avoid driving and operating machinery until you feel better.\r\nLimit or avoid alcohol intake while using this medicine to minimize interactions and occurrence of side effects.\r\nKeep the medicine out of reach of children and pets.\r\nStore in a cool, dry place, protected from direct sunlight and heat.', 1, 0),
(38, 'GNC Pro Performance Zinc', 'GNC Pro Performance Zinc', 'Tablet', 'GNC Pro Performance Zinc Magnesium, 60 Tablets', 'The GNC Pro Performance Zinc Magnesium Amino (ZMA) Complex is a supplement that blends some essential ingredients such as zinc, magnesium, vitamin B6, amino acids, and hops flower extract into a single capsule. This particular complex is known for its potential to promote restful sleep and boost immunity, two elements that play an integral role in maintaining good health. These zinc magnesium tablets work to help combat fatigue and reduce stress, while the hops flower extract helps calm the nerves, contributing to undisturbed sleep.\r\n\r\nWith strong immunity and proper sleep being fundamental for overall health, integrating these zinc magnesium tablets into your routine could be beneficial. Remember to consult with your physician to understand how the GNC Pro Performance Zinc Magnesium Amino (ZMA) complex can serve you and your specific needs better.', 'As a dietary supplement, take one tablet of the GNC Zinc Magnesium Amino Complex at bedtime.', '1365zzzz.jpg', 'GUARDIAN HEALTHCARE SERVICES PVT LTD', '2024-01-15', '2024-12-15', 599, 569, 60, 'tablet', 7, 19, 1, 1, 100, 'All', '18-60 years', 'If you experience any adverse side effects, seek medical help immediately.\r\nNot for medicinal use.\r\nStore in a cool, dry place, away from light.\r\nKeep out of reach of children.', 1, 0),
(39, 'Neuherbs True Magnesium for Men & Women,', 'null', 'Tablet', 'Neuherbs True Magnesium for Men & Women, 60 Tablets', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 'null', '2774manga.jpg', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned conte', '2024-01-15', '2024-08-15', 439, 417, 60, 'tablet', 7, 19, 1, 1, 200, 'All', '18-60 years', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 1, 0),
(40, 'Healthvit Zinc Sulphate', 'Comprises 100% vegetarian zinc sulphate\r\nEach tablet offers a strength of 50 mg\r\nAnti Oxidising\r\nDietary supplement\r\nSuitable for men and women\r\nSuitable for vegans', 'Tablet', 'Healthvit Zinc Sulphate 50 mg, 60 Tablets', 'Healthvit Zinc Sulphate tablets offer a convenient way to supplement your daily diet with a significant trace mineral zinc. Though required in small quantities, zinc plays an essential role in our health. It is fundamental for growth, tissue development, wound healing, and cell division.\r\n\r\nEach high-potency tablet contains 50 mg of pure, vegetarian-friendly zinc sulphate, which is known to support a healthy immune system and aid in boosting immunity defence throughout the year. Zinc sulphate pills are a good addition to your daily vitamin regimen if you\'re seeking immune support.\r\n\r\nThese zinc sulphate tablets not only act as a powerful antioxidant but also help regulate blood glucose levels. Furthermore, zinc plays a vital role in protecting fibroblast cells responsible for collagen production, thereby supporting the skin\'s structure and reducing premature signs of ageing.', 'Take one capsule per day after food or as directed by your doctor.', '5094zinc.jpg', 'WEST COAST PHARMACEUTICAL WORKS LTD', '2024-03-15', '2024-08-15', 600, 570, 60, 'tablet', 7, 19, 1, 1, 200, 'All', '18-60 years', 'Store in a cool and dry place away from direct sunlight.\r\nRead the label carefully before use.\r\nKeep out of reach of children.', 1, 0),
(41, 'Pintola All Natural Crunchy Peanut Butter', 'Peanut,Natural Crunchy', 'Others', 'Pintola All Natural Crunchy Peanut Butter, 1 kg', 'This product is 100% natural, gluten free and non-GMO. We introduced this product for gym goers, dieters and athletes. Keep in your bag for getting instant energy anywhere anytime. All Natural Peanut Butter is unsweetened and loaded with 30% protein, fibre and good fats. You can blend it in smoothies. Spread it on bread/waffles/rice cakes etc. It will taste amazing every time.\r\n\r\nAll PINTOLA®’s products are made up of the finest grade, fresh and nutritious ingredients from an ISO 22000 certified and FSSAI approved factory. We believe in delivering the best quality, freshness and overall customer satisfaction. We manufacture India’s favourite nut butter daily so that you get the fresh product every time.', 'Pintola Smoothie: 1 cup of milk (250ml) + 2 tbsp of All Natural Peanut Butter + half tbsp natural honey. Add all ingredients into shaker & shake until smooth. Add 1 banana or blueberries or vanilla or crushed dry fruits on top. Peanut Butter Oat meal : Pr', '6063peanut.jpg', 'DAS FOODTECH PRIVATE LIMITED', '2024-01-15', '2024-12-15', 390, 370, 1, 'unit', 7, 19, 1, 1, 200, 'All', 'Above 12 years', 'While we strive to provide complete, accurate, and expert-reviewed content on our \'Platform\', we make no warranties or representations and disclaim all responsibility and liability for the completeness, accuracy, or reliability of the aforementioned content. The content on our platform is for informative purposes only, and may not cover all clinical/non-clinical aspects. Reliance on any information and subsequent action or inaction is solely at the user\'s risk, and we do not assume any responsibility for the same. The content on the Platform should not be considered or used as a substitute for professional and qualified medical advice. Please consult your doctor for any query pertaining to medicines, tests and/or diseases, as we support, and do not replace the doctor-patient relationship.', 1, 0),
(42, 'Lipton Honey Lemon Green Tea Bags,', 'Green Tea, Honey Lemon Flavor, Tea.', 'Patches', 'Lipton Honey Lemon Green Tea Bags, 25 Count', 'Zero Calories: green tea, when had without milk or sugar, not only tastes great but contains virtually zero calories\r\nNext Best to Water: brewed, unsweetened green tea being 99% water is a great way to meet your daily required fluid intake\r\nGlowing Skin: give your skin a hydrated healthy glow with green tea\r\nHeart Health : consumption of green tea as a part of a healthy lifestyle may help maintain a healthy heart as it is thought to have a protective effect against cardiovascular diseases\r\nSimply delicious flavour and great taste\r\nSoothing aroma of a warm cup of green tea may help you relax\r\nFlavour: Honey Lemon', 'Place a Lipton green tea bag in a cup Pour freshly bioled water into the cup Dip the tea bag a few times and allow it to infuse for 2 mins Remove the tea bag and dispose it in wet bin Best enjoyed as a light brew without milk and sugar', '3521lipton.jpg', 'HINDUSTAN UNILEVER LIMITED', '2024-12-15', '2025-01-15', 170, 161, 30, 'unit', 7, 19, 1, 1, 100, 'All', 'All', 'Use before expiry date\r\nAvoid contact with eyes\r\nWash thoroughly with clean water in case of contact', 1, 0),
(43, 'Calibar Protein', 'Whey Protein, Crisps, Coffee Powder, Almonds, Cocoa', 'Others', 'Calibar Protein Roasted Coffee Bean Crispy Bar, 40 gm', 'CaliBar Protein Bars are the crispiest protein bars you\'ll find. They not only satiate your mid-meal hunger but also helps you stay on track with your nutritional needs. CaliBar helps you stay active and provides sustained energy throughout the day. It is a source of high-protein and the right balance of ingredients to help you achieve your activity goals.', 'Just simply open up the wrapper and have it any time.', '7572bar.jpg', 'DISCOVERY NUTRITION', '2024-01-15', '2024-12-15', 59, 60, 45, 'gm', 7, 19, 1, 1, 200, 'All', '5-12 years', 'Allergen Information: Contains soy, milk and nuts.', 1, 0);
INSERT INTO `medicine` (`m_id`, `m_name`, `m_compose`, `m_type`, `m_short_descr`, `m_descr`, `m_direction`, `m_image`, `m_mfg_by`, `m_mfg_date`, `m_exp_date`, `m_mrp`, `m_price`, `qty_per_unit`, `m_unit`, `ct_id`, `m_sc_id`, `sp_id`, `mt_id`, `m_qty`, `m_gender_spec`, `m_age_grp`, `m_side_effect`, `m_status`, `order_count`) VALUES
(44, 'Gastrozin 75', 'INC CARNOSINE-75MG', 'Tablet', 'Gastrozin 75 Tablet 30\'s', 'Gastrozin 75 Tablet 30\'s is a nutritional supplement used to stabilize and protect gastric and intestinal mucosal lining, helps relieve mild gastric discomforts such as nausea, bloating, stomach upset, and occasional heartburn, and supports a healthy gastric microbial balance. It possesses gastrointestinal and health-promoting activity. Gastrozin 75 Tablet 30\'s may also be used to treat nutritional deficiencies.  \r\n \r\nGastrozin 75 Tablet 30\'s contains \'Zinc carnosine\', which is a complex of elemental zinc and L-carnosine. L-carnosine is a dipeptide molecule made up of two amino acids, namely, beta-alanine and L-histidine. Gastrozin 75 Tablet 30\'s enhances stomach lining integrity, and supports natural protective mechanisms in the gastrointestinal tract without interfering with the normal digestive process or suppressing stomach acid. It helps maintain the stomach microflora, thereby enhancing digestive health.\r\n \r\nYou are advised to take Gastrozin 75 Tablet 30\'s for as long as your doctor has prescribed it for you, depending on your medical condition. In some cases, you may experience common side effects such as nausea, indigestion, and stomach pain. Most of these side effects do not require medical attention and will resolve gradually over time. However, you are advised to talk to your doctor if the side effects persist or worsen.\r\n \r\nLet your doctor know if you are taking prescription, non-prescription drugs, or herbal products before starting Gastrozin 75 Tablet 30\'s. If you are known to be allergic to any of the components in Gastrozin 75 Tablet 30\'s, please inform your doctor. Consult your doctor if you are pregnant or breastfeeding. Gastrozin 75 Tablet 30\'s should be given to children only if prescribed by a doctor. It is unknown if alcohol interacts with Gastrozin 75 Tablet 30\'s, so please consult a doctor if you have any concerns.', 'Tablet: Swallow it as a whole with a glass of water; do not chew or break it.Suspension: Shake the bottle well before use. Take the prescribed dose by mouth using the measuring cup/dosing syringe/dropper provided by the pack.', '2890gastrozin.jpg', 'Synergy Pharma Formulations India Pvt Ltd', '2024-01-15', '2024-08-15', 280, 266, 30, 'tablet', 1, 1, 3, 6, 200, 'All', 'All', 'Nausea\r\nIndigestion\r\nStomach pain', 1, 0),
(45, 'Pantocid DSR', 'DOMPERIDONE-30MG + PANTOPRAZOLE-40MG', 'Capsule', 'Pantocid DSR Capsule 15\'s', 'Pantocid DSR Capsule 15\'s is composed of two medicines, namely: Domperidone and Pantoprazole. Domperidone is a prokinetic and anti-nausea agent that helps to treat indigestion and stomach pain. On the other hand, Pantoprazole is a proton pump inhibitor that reduces the excess stomach acid formation by blocking the actions of an enzyme (H+/K+ ATPase or gastric proton pump). Pantocid DSR Capsule 15\'s is a widely used medicine to treat peptic ulcers and gastroesophageal reflux disease (GERD). Pantocid DSR Capsule 15\'s prevents the release of stomach acid and relieves symptoms of food pipe lining inflammation (esophagitis), and gastroesophageal reflux disease (GERD), or heartburn.\r\n\r\nDomperidone works by increasing the movement of food through the stomach and the digestive tract more quickly and in this way reduces the feeling of bloating, or fullness and indigestion. On the other hand, it effectively blocks the action of a vomiting centre (chemoreceptor trigger zone - CTZ) located in your brain, that is responsible for inducing the feeling of nausea and vomiting. Pantoprazole helps in reducing the stomach acid by blocking the actions of an enzyme (H+/K+ ATPase or gastric proton pump). This proton pump lies in the cells of the stomach wall responsible for the release of gastric acid secretion damaging tissues in the food pipe, stomach, and duodenum.\r\n\r\nIt should be taken as prescribed by the doctor. Like all medicines, Pantocid DSR Capsule 15\'s may cause side effects, although not everybody gets them. The most common side effects of Pantocid DSR Capsule 15\'s are diarrhoea, stomach pain, flatulence (gas), dryness in the mouth, dizziness, and headache. Everyone doesn\'t need to experience the above side effects. In case of any discomfort, speak with your doctor.\r\n\r\nIt is recommended not to use if you are allergic to any ingredinets present in it. Prolonged intake of Pantoprazole is associated with a low level of Vitamin B12 and low magnesium. Hence yearly test of Vitamin B12 and magnesium is required if you are taking Pantocid DSR Capsule 15\'s for the long term. Use of Pantocid DSR Capsule 15\'s is contraindicated in people with lupus (autoimmune inflammatory disease). Try to avoid caffeine-containing beverages (coffee, tea), spicy/deep fried/processed foods, carbonated drinks, acidic foods like citrus fruits/vegetables (tomato', 'Swallow it as a whole with water; do not crush, break or chew it.', '9767pantocid.jpg', 'Sun Pharmaceutical Industries Ltd', '2024-01-15', '2024-12-15', 194, 184, 15, 'tablet', 1, 1, 1, 6, 200, 'All', 'All', 'You should avoid taking Pantocid DSR Capsule 15\'s if you are allergic to Pantocid DSR Capsule 15\'s or proton pump inhibitors, have gastric cancer, liver disease, low magnesium level (osteoporosis), low vitamin B12, pregnant or planning for pregnancy, and breastfeeding mothers. Pantocid DSR Capsule 15\'s may interact with a blood thinner (warfarin), antifungal (ketoconazole), anti-HIV drug (atazanavir, nelfinavir), iron supplements, ampicillin antibiotic, anti-cancer drug (methotrexate). Let your doctor know if you are taking these medicines. Prolonged intake of Pantocid DSR Capsule 15\'s may cause lupus erythematosus (an inflammatory condition in which the immune system attacks its own tissues), Vitamin B12, and magnesium deficiency. Intake of Pantocid DSR Capsule 15\'s may mask the symptom of gastric cancer, so if you have any severe stomach pain or gastric bleeding (blood in mucous or stool) immediately consult the doctor.', 1, 0),
(46, 'Omez', 'OMEPRAZOLE-20MG', 'Capsule', 'Omez Capsule 20\'s', 'Omez Capsule 20\'s belongs to the class of drugs known as Proton pump inhibitor (PPIs), which reduces the amount of acid your stomach makes. It treats gastroesophageal reflux disease (GERD), stomach ulcer, and Zollinger Ellison syndrome (overproduction of acid due to pancreatic tumour).\r\n\r\nOmez Capsule 20\'s contains omeprazole, which helps reduce stomach acid by blocking the actions of an enzyme (H+/K+ ATPase or gastric proton pump). This proton pump lies in the stomach wall cells and is responsible for releasing gastric acid secretion. Omez Capsule 20\'s prevents the release of stomach acid and relieves symptoms of food pipe lining inflammation (esophagitis), gastroesophageal reflux disease (GERD), or heartburn.\r\n\r\nOmez Capsule 20\'s is taken with food in a dose and duration as advised by the doctor. Your dose will depend on your condition and how you respond to the medicine. An adult taking Omez Capsule 20\'s might have common side effects like stomach pain, gas formation (flatulence), nausea, vomiting, diarrhoea, and headache. Respiratory system problems can be reported in some children (more than 1 year) using Omez Capsule 20\'s. These side effects are temporary and may get resolved after some time; however, if this side persists, contact the doctor.\r\n\r\nOmez Capsule 20\'s should not be given to the patient suffering from Clostridium difficile-associated diarrhoea. Omez Capsule 20\'s is safe for pregnant and breastfeeding mothers but should be taken only after consulting a doctor. Tell your doctor if you have stomach or intestinal cancer, liver problem, are allergic to Omez Capsule 20\'s, or will have an endoscopy in the future. Ask your doctor if you should stop taking Omez Capsule 20\'s a few weeks before your endoscopy as it may hide some of the problems that would be spotted during an endoscopy. Prolonged use of Omez Capsule 20\'s may be associated with an increased risk for osteoporosis-related fractures of the hip, wrist or spine due to loss of magnesium. Avoid using Omez Capsule 20\'s with St John’s Wort (plant-based antidepressant), rifampin (antibiotic) and methotrexate (anti-cancer and anti-arthritis medicine) due to the severe drug interaction.', 'Tablet/Capsule: Swallow it as a whole with water; do not crush, break or chew it.Oral Suspension: Shake the bottle well before use. Check the label for directions and take Omez Capsule 20\'s in doses as prescribed by your doctor with the help of a measurin', '2773omez.jpg', 'Dr. Reddy\'s Laboratories Ltd', '2024-03-15', '2024-08-15', 54, 51, 20, 'tablet', 1, 1, 1, 6, 200, 'All', 'All', 'Omez Capsule 20\'s should not be given to the patient suffering from Clostridium difficile-associated diarrhoea. Omez Capsule 20\'s is safe for pregnant and breastfeeding mothers but should be taken only after consulting a doctor. Tell your doctor if you have stomach or intestinal cancer, liver problem, are allergic to Omez Capsule 20\'s or will have an endoscopy in the future. Ask your doctor if you should stop taking Omez Capsule 20\'s a few weeks before your endoscopy as it may hide some of the problems that would be spotted during an endoscopy. Prolonged use of Omez Capsule 20\'s may be associated with an increased risk for osteoporosis-related fractures of the hip, wrist or spine due to loss of magnesium. Avoid using Omez Capsule 20\'s with St John’s Wort (plant-based antidepressant), rifampin (antibiotic) and methotrexate (anti-cancer and anti-arthritis medicine) due to the severe drug interaction.', 1, 0),
(47, 'Gaspunch Tablet', 'ACTIVATED CHARCOAL-250MG + SIMETHICONE-80MG', 'Tablet', 'Gaspunch Tablet 10\'s', 'Gaspunch Tablet 10\'s belongs to a group of medicines called anti-flatulent, used to treat intestinal gas, painful pressure, poisoning, and swelling in the abdomen. Intestinal gas (Flatulence) and bloating occur due to the accumulation of gas or air in the digestive system.\r\n\r\nGaspunch Tablet 10\'s is a combination of two drugs: Simethicone and Activated Charcoal are anti-flatulent medications. Simethicone works by decreasing the surface tension of gas bubbles, thereby facilitating the expulsion of gas through flatus or belching (burping). It also prevents the accumulation and formation of gas in the digestive tract. Activated Charcoal helps to reduce the volume of intestinal gas and produces discernible relief. \r\n\r\nYou are advised to take Gaspunch Tablet 10\'s for as long as your doctor has prescribed it for you, depending on your medical condition. In some cases, you may experience certain common side-effects such as dark stools and constipation. Most of these side effects do not require medical attention and will resolve gradually over time. However, you are advised to talk to your doctor if you experience these side effects persistently.\r\n\r\nDo not take Gaspunch Tablet 10\'s if you are pregnant or breastfeeding unless prescribed by the doctor. Gaspunch Tablet 10\'s should not be given to children as safety has not been established. Avoid consuming alcohol along with Gaspunch Tablet 10\'s.', 'Swallow Gaspunch Tablet 10\'s as a whole with water; do not crush, break or chew it.', '5556gaspunch.jpg', 'Primus Remedies Pvt Ltd', '2024-01-15', '2024-08-15', 110, 104, 10, 'tablet', 1, 1, 1, 6, 200, 'All', 'All', 'Do not take Gaspunch Tablet 10\'s if you are allergic to any of its contents. Do not other medicines for at least 2 hours after taking Gaspunch Tablet 10\'s, as Gaspunch Tablet 10\'s may stop other medicines from getting into the body. Inform your doctor before taking Gaspunch Tablet 10\'s about your past and present medical history. Do not take Gaspunch Tablet 10\'s if you are pregnant or breastfeeding unless prescribed by the doctor. Gaspunch Tablet 10\'s should not be given to children as safety has not been established. Avoid consuming alcohol along with Gaspunch Tablet 10\'s. If you experience prolonged diarrhea while taking Gaspunch Tablet 10\'s, contact your doctor. Gaspunch Tablet 10\'s can make your feces black.', 1, 0),
(48, 'Razo-D', 'DOMPERIDONE-30MG + RABEPRAZOLE-20MG', 'Capsule', 'Razo-D Capsule 15\'s', 'Razo-D Capsule 15\'s is a gastrointestinal medicine composed of Rabeprazole (stomach acid reducer) and Domperidone (nausea/vomiting reducer). Together they reduce the amount of acid your stomach makes and decrease the symptoms of nausea and vomiting. It treats symptoms of acid reflux due to hyperacidity, stomach ulcer (Peptic ulcer disease), and Zollinger Ellison syndrome (overproduction of acid due to a pancreatic tumour). Besides this, it is used short-term to treat gastroesophageal reflux disease (GERD) symptoms. GERD is a condition in which the sphincter (valve) located at the uppermost part of the stomach gets irritated and damaged due to excessive stomach acid production. As a result, the stomach acid and juice flow back into the food pipe, leading to stomach upset and heartburn. Heartburn is the post-effect of acid reflux with a burning-like feeling that rises from the stomach towards the neck.\r\n\r\nRazo-D Capsule 15\'s contains two medicines, namely Rabeprazole and Domperidone. Rabeprazole is a proton pump inhibitor that helps reduce stomach acid by blocking the actions of an enzyme (H+/K+ ATPase or gastric proton pump). This gastric proton pump lies in the cells of the stomach wall. It is responsible for releasing gastric acid secretion and damaging tissues in the food pipe, stomach, and duodenum (uppermost part of the small intestine). On the other hand, Domperidone is a prokinetic agent that increases the motility of the upper gastrointestinal tract and blocks the vomiting-inducing centre (chemoreceptor trigger zone-CTZ).\r\n\r\nIt is better to take Razo-D Capsule 15\'s an hour before a meal or without a meal for its best results. Razo-D Capsule 15\'s should be swallowed whole with a glass of water. Do not chew, crush, or break it. You should keep taking this medicine for as long as your doctor recommends. If you stop treatment too early, your symptoms may come back, and your condition may worsen. An adult taking Razo-D Capsule 15\'s might have common side effects like headache, diarrhoea, nausea, abdominal pain, vomiting, flatulence, dizziness, and arthralgia (joint pain). In the case of children taking Razo-D Capsule 15\'s might report upper respiratory tract infections (URI), headache, fever, diarrhoea, vomiting, rash, and abdominal pain. These side effects are temporary and may resolve after some time; however, if this persists, contact the doctor.\r\n\r\nYou can increase the efficacy of Razo-D Capsule 15\'s by taking a small meal or snacks frequently. Avoid caffeine-containing beverages (coffee, tea), spicy/deep-fried/processed foods, carbonated drinks, and acidic foods like citrus fruits/vegetables (tomatoes). Tell your doctor if you have stomach or intestinal cancer, liver problem, are allergic to Razo-D Capsule 15\'s or will have an endoscopy in the future. Prolonged intake of Razo-D Capsule 15\'s may cause deficiency of Vitamin B-12 and low levels of calcium, magnesium, and Vitamin D leading to osteoporosis (brittle or weak bones).', 'Tablet/Capsule: Swallow it as a whole with water; do not crush, break or chew it.', '6377razo.jpg', 'Dr. Reddy\'s Laboratories Ltd', '2024-01-15', '2024-12-15', 306, 291, 15, 'tablet', 1, 1, 1, 6, 200, 'All', 'All', 'You should avoid taking Razo-D Capsule 15\'s if you are allergic to Razo-D Capsule 15\'s or proton pump inhibitors, have gastric cancer, liver disease, low magnesium level (osteoporosis), low vitamin B12, are pregnant or planning for pregnancy, and breastfeeding mothers. Razo-D Capsule 15\'s may interact with a blood thinner (warfarin), antifungal (ketoconazole), anti-HIV drug (atazanavir, nelfinavir), iron supplements, ampicillin antibiotic, anti-cancer drug (methotrexate). Let your doctor know if you are taking these medicines. Prolonged intake of Razo-D Capsule 15\'s may cause lupus erythematosus (an inflammatory condition in which the immune system attacks its tissues), Vitamin B-12, and magnesium deficiency. Intake of Razo-D Capsule 15\'s may mask the symptom of gastric cancer, so if you have any severe stomach pain or gastric bleeding (blood in mucous or stool), immediately consult the doctor. Tell your doctor that you are using before having a specific blood test known as Chromogranin A.', 1, 0),
(49, 'Cetaphil Gentle Skin Cleanser', 'Water, Cetyl Alcohol, Propylene Glycol, Sodium Lauryl Sulfate, Stearyl Alcohol, Methylparaben, Propylparaben, Butylparaben.', 'Others', 'Cetaphil Gentle Skin Cleanser, 125 ml', 'Introducing Cetaphil Gentle Skin Cleanser, the perfect solution for sensitive and dry skin. This mild and non-irritating formula is specifically designed to effectively remove dirt, excess oil, and impurities without compromising your skin\'s natural moisture barrier. With this soap-free formula, you can enjoy the benefits of both cleansing and moisturizing at the same time. Say goodbye to harsh cleansers that leave your skin feeling tight and dry. This gentle skin cleanser leaves your skin feeling clean, refreshed, and incredibly soft.\r\n\r\nSuitable for sensitive and dry skin, Cetaphil Gentle Skin Cleanser is fragrance-free, non-comedogenic, and hypoallergenic. It maintains your skin\'s natural pH balance, which is why this cleanser is specially formulated to keep your skin healthy and nourished. Experience the gentle yet effective power of Cetaphil Gentle Skin Cleanser. Say hello to clean, healthy-looking skin with a product you can trust.', 'Apply a liberal amount of Cetaphil face wash to the skin. Rub gently in circular motions. If using without water, remove excess with a soft cloth, leaving a thin film on the skin. If rinsing with water, rinse thoroughly after gentle rubbing. Use twice dai', '7923cetaclin.jpg', 'GALDERMA INDIA PVT LTD', '2024-01-15', '2024-08-15', 399, 379, 125, 'ml', 1, 1, 3, 1, 200, 'All', 'All', 'Perform a patch test before use to check for any allergic reactions.\r\nAvoid contact with eyes. If contact occurs, rinse thoroughly with water.\r\nStore below 30 degrees Celsius.\r\nKeep out of reach of children.\r\nExternal use only. Do not ingest.\r\nIn case of any skin irritation or rash, discontinue use and consult a dermatologist.', 1, 0),
(50, 'CeraVe PM Facial Moisturising Lotion', 'Aqua / Water / Eau, Glycerin, Caprylic/Capric Triglyceride, Niacinamide, Cetearyl Alcohol, Potassium Phosphate, Ceramide Np, Ceramide Ap, Ceramide Eop, Carbomer, Dimethicone, Ceteareth-20, Behentrimonium Methosulfate, Sodium Lauroyl Lactylate, Sodium Hyaluronate, Cholesterol, Phenoxyethanol, Disodium Edta, Dipotassium Phosphate, Caprylyl Glycol, Phytosphingosine, Xanthan Gum, Polyglyceryl-3 Diisostearate, Ethylhexylglycerin.', 'Lotion', 'CeraVe PM Facial Moisturising Lotion for Normal to Dry Skin, 52 ml', 'Developed with dermatologists, CeraVe PM Facial Moisturizing Lotion has an ultra-lightweight, unique formula that moisturizes the skin throughout the night. It helps restore the protective skin barrier with three essential ceramides. This lotion is formulated to lock in your skin\'s moisture and helps restore your skin\'s natural barrier while you sleep. The formula also contains hyaluronic acid to help retain the skin\'s natural moisture and niacinamide to help calm the skin.\r\n\r\nCeraVe PM Facial Moisturizing Lotion is an oil-free moisturizer that leaves the skin feeling comfortable and is gentle on the skin. The MVE Delivery Technology of the moisturizing lotion works by continuously releasing moisturizing ingredients for long-lasting hydration. CeraVe PM Facial Moisturizing Lotion restores lost moisture and gives a smooth, supple, and healthy-looking skin.', 'Apply the lotion liberally to the face and neck at night or as directed by a physician.', '1338careve.jpg', 'LOREAL INDIA PVT LTD', '2024-01-15', '2024-12-15', 1200, 1140, 52, 'ml', 1, 1, 3, 1, 100, 'All', 'All', 'CeraVe PM Facial Moisturizing Lotion helps calm, soothe and hydrate your skin.\r\nIt has MVE Technology, a unique delivery system that continuously releases moisturizing ingredients for all-night hydration.\r\nCeramides lock in moisture and help restore and maintain the skin\'s natural protective barrier.\r\nHyaluronic acid boosts hydration and helps retain the skin\'s natural moisture.\r\nCeraVe PM Facial Moisturizing Lotion is gentle on your skin and contains a non-irritating formula.\r\nIt is free from fragrance and parabens and is suitable for normal to dry skin.\r\nThis moisturizing lotion is non-comedogenic and does not clog the pores.', 1, 0),
(51, 'Ahaglow Skin Rejuvenating Face Wash Gel,', 'Aloe Vera, Glycolic Acid, Vitamin E.', 'Lotion', 'Ahaglow Skin Rejuvenating Face Wash Gel, 200 gm', 'Ahaglow Face Wash Gel is a gentle yet effective face wash that is specially formulated to cleanse and exfoliate your skin and remove dead skin cells, leaving it fresh, rejuvenated, and free from acne, excess oil, and other impurities. The Ahaglow Face Wash is SLS and paraben-free. With its non-comedogenic formula, it won\'t clog your pores or cause any breakouts. Infused with the power of glycolic acid, it effectively removes dead skin cells and unclogs pores, revealing a smoother and more refined skin texture. The addition of aloe vera ensures that your skin stays soothed and hydrated throughout the day.\r\n\r\nProtect your skin with the antioxidant properties of vitamin E, which helps combat free radicals and promotes healthy skin healing. This face wash gel is suitable for all skin types and can be used twice a day for maximum results.', 'Wet your face with water. Take a small amount of Ahaglow Face Wash Gel in your palm. Gently massage the face wash onto your wet face, using circular motions, avoiding the eye area. Rinse thoroughly with water and pat dry. For best results, use twice a day', '5230aha.jpg', 'TORRENT PHARMACEUTICALS LTD', '2024-01-15', '2024-08-15', 746, 709, 200, 'gm', 1, 1, 3, 1, 100, 'All', 'All', 'Avoid contact with eyes. In case of accidental contact, rinse thoroughly with water.\r\nPatch test before first use to check for any allergic reactions.\r\nIf any skin irritation or redness occurs, discontinue use and consult a dermatologist.\r\nKeep out of reach of children.\r\nFor external use only.', 1, 0),
(52, 'Cetaphil Moisturising Cream', 'Almond oil and Vitamin E', 'Lotion', 'Cetaphil Moisturising Cream, 80 gm', 'Experience the ultimate hydration and protection with Cetaphil Moisturizer. Specially formulated for dry and sensitive skin types, this powerful moisturiser is designed to retain your skin\'s natural moisture barrier and shield your skin from external aggressors. Key ingredients like macadamia nut oil and glycerin effectively hydrate your skin for up to 48 hours, leaving it feeling soft, supple, and nourished.\r\n\r\nDermatologist-recommended for sensitive skin, this fragrance-free moisturiser is non-comedogenic, ensuring it won\'t clog your pores. Infused with the goodness of sweet almond oil and Vitamin E, it not only deeply moisturises but also provides essential nutrients to promote healthier-looking skin.', 'Squeeze a small amount of Cetaphil Moisturizer onto your fingertips. Gently apply the moisturiser to your face and body accordingly. Use your fingertips to massage the moisturiser into your skin using gentle circular motions. Ensure the moisturiser is eve', '6018cetamois.jpg', 'GALDERMA INDIA PVT LTD', '2024-01-15', '2024-08-15', 599, 569, 80, 'gm', 1, 1, 3, 1, 100, 'All', 'All', 'Before applying the Cetaphil Moisturizing Cream to your face or body, perform a patch test on a small area of skin to check for any allergic reactions or sensitivities.\r\nKeep the moisturiser away from your eyes, as it might cause discomfort or irritation through direct contact.\r\nFollow the instructions on the packaging for application frequency and quantity.\r\nIf you experience redness, itching, burning, or any other adverse reactions after applying the moisturiser, discontinue use and consult a dermatologist.\r\nStore the product in a cool, dry place and away from direct sunlight. Extreme temperatures or exposure to sunlight can affect the product\'s stability.', 1, 0),
(53, 'Minimalist 2% Salicylic Acid + LHA Cleanser', 'Aqua, Glycerin, Cocamidopropyl Betaine, Propanediol, Sodium Lauroyl Methyl Isethionate, Xylitylglucoside, Anhydroxylitol, Xylitol, PEG-150 Pentaerythrityl Tetrastearate, PEG-120 Methyl Glucose Dioleate, Salicylic Acid, Betaine, Avena Sativa (Oat) Kernel Extract, Pentylene Glycol, Capryloyl Salicylic Acid, Panthenol, Allantoin, Zinc PCA, Sodium PCA, Coco-Glucoside, Glyceryl Oleate, Phenoxyethanol, Ethylhexylglycerin, Trisodium Ethylenediamine Disuccinate, Lactic Acid, Citric Acid, Sodium Citrate, Sodium Hydroxide.', 'Others', 'Minimalist 2% Salicylic Acid + LHA Cleanser | Reduces Acne and Balances Oil | 100 ml', 'Minimalist Salicylic Acid Face Wash is a powerful yet gentle daily exfoliating solution designed to reduce acne and balance oil. With its unique formulation, this cleanser effectively penetrates deep into the skin, removing dirt, debris, and excess sebum to reduce the oily appearance of the skin. The combination of Salicylic Acid and LHA provides a multi-level cleansing experience, with Salicylic Acid working deep within the skin while LHA offers gentle exfoliation on the outer layer. This dynamic duo ensures a thorough yet gentle cleansing ritual, leaving your skin feeling refreshed and revitalised.\r\n\r\nEnriched with anti-bacterial zinc and a blend of hydrating and soothing ingredients such as xylitylglucoside, panthenol (vitamin B5), allantoin, and pentylene glycol, the cleanser goes beyond mere cleansing. It provides a hydrating overall after-feel, promoting a balanced and nourished complexion.', 'Wet your face with lukewarm water. Take a small amount of Minimalist Salicylic Acid Face Wash and gently massage it onto your face in circular motions. Rinse thoroughly with water and pat dry. For best results, use twice daily, morning and night.', '9206mini.jpg', 'UPRISING SCIENCE PRIVATE LIMITED', '2024-01-15', '2024-08-15', 299, 284, 100, 'ml', 1, 1, 3, 1, 100, 'All', '18-60 years', 'Avoid contact with eyes. In case of eye contact, rinse thoroughly with water.\r\nDiscontinue use if irritation occurs.\r\nKeep out of reach of children.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_order`
--

CREATE TABLE `medicine_order` (
  `mo_id` int(6) NOT NULL,
  `p_id` int(6) NOT NULL,
  `ship_p_name` text NOT NULL,
  `mo_phn` varchar(10) NOT NULL,
  `mo_email` text NOT NULL,
  `mo_invoice` int(6) NOT NULL,
  `mo_shipping` int(6) NOT NULL,
  `total_price_all_combined` int(6) NOT NULL,
  `mo_pay_type` text NOT NULL,
  `mo_addr` text NOT NULL,
  `mo_date` datetime NOT NULL,
  `mo_invoice_file` text DEFAULT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_order`
--

INSERT INTO `medicine_order` (`mo_id`, `p_id`, `ship_p_name`, `mo_phn`, `mo_email`, `mo_invoice`, `mo_shipping`, `total_price_all_combined`, `mo_pay_type`, `mo_addr`, `mo_date`, `mo_invoice_file`, `status`) VALUES
(192, 1, 'Protap Barman', '8327507847', 'yoyobprotap@gmail.com', 0, 50, 4290, 'cod', 'Near sitalkuchi, sitalkuchi, sitalkuchi, Cooch Behar, West Bengal, 123456', '2024-03-06 16:11:57', 'invoice_1709721717759.pdf', 'completed'),
(193, 1, 'Protap Barman', '8327507847', 'yoyobprotap@gmail.com', 5, 50, 2348, 'cod', 'Near CBI Atm, Sitalkuchi, CoochBehar, Cooch Behar, West Bengal, 736158', '2024-03-12 23:16:40', 'invoice_1710265600517.pdf', 'confirmed'),
(194, 1, 'Protap Barman', '8327507847', 'yoyobprotap@gmail.com', 5, 50, 2975, 'cod', 'Near CBI Atm, Sitalkuchi, CoochBehar, Cooch Behar, West Bengal, 736158', '2024-03-16 19:50:15', 'invoice_1710598815760.pdf', 'confirmed'),
(195, 1, 'Bipasha Bagchi', '8768271456', 'yoyobprotap@gmail.com', 5, 50, 588, 'cod', 'Near Behind MJN Medical College, Nilkuthi, Railghumty, Cooch Behar, Cooch Behar, West Bengal, 736135', '2024-03-17 11:48:09', 'invoice_1710656290224.pdf', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_order_details`
--

CREATE TABLE `medicine_order_details` (
  `mod_id` int(6) NOT NULL,
  `mo_id` int(6) NOT NULL,
  `m_id` int(6) NOT NULL,
  `mod_qty` int(6) NOT NULL,
  `mod_price` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_order_details`
--

INSERT INTO `medicine_order_details` (`mod_id`, `mo_id`, `m_id`, `mod_qty`, `mod_price`) VALUES
(234, 192, 12, 2, 2120),
(235, 193, 14, 3, 165),
(236, 193, 13, 2, 899),
(237, 194, 20, 5, 584),
(238, 195, 16, 1, 533);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_sub_category`
--

CREATE TABLE `medicine_sub_category` (
  `m_sc_id` int(6) NOT NULL,
  `ct_id` int(6) NOT NULL,
  `m_sc_name` text NOT NULL,
  `m_sc_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_sub_category`
--

INSERT INTO `medicine_sub_category` (`m_sc_id`, `ct_id`, `m_sc_name`, `m_sc_status`) VALUES
(1, 1, 'N/A', 1),
(2, 3, 'Mosquito Repellents', 1),
(5, 3, 'Acne Care', 1),
(7, 4, 'Digestive Health', 1),
(9, 2, 'pqr', 1),
(11, 3, 'Body Lotions', 1),
(13, 5, 'Diapers', 1),
(14, 5, 'Baby Food', 1),
(15, 5, 'Baby Skin Care', 1),
(16, 5, 'Baby Bath', 1),
(17, 10, 'Vitamin C', 1),
(18, 10, 'Vitamin D', 1),
(19, 7, 'Calcium', 1),
(20, 7, 'Protein Powders', 1),
(21, 10, 'Vitamin B', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_type`
--

CREATE TABLE `medicine_type` (
  `mt_id` int(6) NOT NULL,
  `mt_name` text NOT NULL,
  `mt_descr` text DEFAULT NULL,
  `mt_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_type`
--

INSERT INTO `medicine_type` (`mt_id`, `mt_name`, `mt_descr`, `mt_status`) VALUES
(1, 'Null', 'Null', 1),
(2, 'Antibiotics', 'Antibiotics are used to treat bacterial infections. They work by either killing bacteria or preventing their growth. Examples include penicillin, amoxicillin, and ciprofloxacin', 1),
(3, 'Antihypertensives', 'hese medications are used to lower blood pressure. They work by relaxing blood vessels or reducing the volume of blood pumped by the heart. Examples include ACE inhibitors (e.g., lisinopril), beta-blockers (e.g., metoprolol), and calcium channel blockers (e.g., amlodipine).', 1),
(4, 'Antacids', 'Antacids are used to relieve heartburn and indigestion by neutralizing stomach acid. Examples include calcium carbonate (Tums) and aluminum hydroxide/magnesium hydroxide (Maalox)', 1),
(5, 'Analgesics', 'These medications relieve pain. Examples include NSAIDs (e.g., aspirin, ibuprofen), acetaminophen (paracetamol), and opioids (e.g., morphine, codeine).', 1),
(6, 'Gas Relief', 'Gas relief tablets or gas relief medications are commonly referred to as products that alleviate symptoms related to excess gas in the digestive system. These tablets may have various brand names depending on the manufacturer and active ingredients. Some common brand names for gas relief tablets include Gas-X, Phazyme, Mylicon, and Beano, among others. Always consult with a healthcare professional or pharmacist for advice on selecting the most appropriate gas relief medication for your specific needs.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `pk_id` int(6) NOT NULL,
  `pk_name` varchar(255) NOT NULL,
  `pk_short_descr` varchar(128) DEFAULT NULL,
  `pk_preparation` text DEFAULT NULL,
  `pk_process` text NOT NULL,
  `pk_descr` text DEFAULT NULL,
  `pk_caution` text DEFAULT NULL,
  `pk_fee` int(6) NOT NULL,
  `pk_pay_fee` int(11) NOT NULL,
  `pk_image` text DEFAULT NULL,
  `pk_book_count` int(6) NOT NULL,
  `pk_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pk_id`, `pk_name`, `pk_short_descr`, `pk_preparation`, `pk_process`, `pk_descr`, `pk_caution`, `pk_fee`, `pk_pay_fee`, `pk_image`, `pk_book_count`, `pk_status`) VALUES
(6, 'Diabetes Care', 'very good package', 'Overnight fasting (8-12 hrs) is required. Do not eat or drink anything except water before the test.\r\nIt is advisable to stop multivitamins or dietary supplements containing biotin (vitamin B7) for at least 2 days before the test.\r\nThe urine sample must preferably be the first morning midstream urine (part of urine that comes after the first and before the last stream). Collect the urine sample in a sealed and sterile screw-capped container provided by our sample collection professional. Ensure that the urethral area (from where the urine is passed) is clean & container doesn\'t come in contact with your skin. Women are advised not to give the sample during the menstrual period unless prescribed. You should submit all the required samples for this package at once during the scheduled sample collection.', 'The Diabetes Care Package helps screen and diagnose prediabetes, diabetes and other types of diabetes. It provides a range of tests for key diabetes parameters such as Fasting Blood Sugar (FBS), HbA1c, and Average Blood Glucose. In addition, it also includes tests for Complete Blood Count / Hemogram (CBC), Lipid Profile, Thyroid Function, Kidney Function and more. This package is recommended for people with strong risk factors for diabetes and heart diseases, including a family history of these diseases, sedentary lifestyle, smoking and obesity. It is also suitable for people with diabetes to monitor their sugar control.', 'The Diabetes Care Package helps screen and diagnose prediabetes, diabetes and other types of diabetes. It provides a range of tests for key diabetes parameters such as Fasting Blood Sugar (FBS), HbA1c, and Average Blood Glucose. In addition, it also includes tests for Complete Blood Count / Hemogram (CBC), Lipid Profile, Thyroid Function, Kidney Function and more. This package is recommended for people with strong risk factors for diabetes and heart diseases, including a family history of these diseases, sedentary lifestyle, smoking and obesity. It is also suitable for people with diabetes to monitor their sugar control.', 'do not wear or take metal products with you', 3999, 5999, '7629diabetes.png', 0, 1),
(9, 'Comprehensive Full Body Checkup Test With Vitamin D & B12', 'The Comprehensive Full Body Checkup with Vitamin D & B12 is ideal for people who want to monitor their overall health.', 'The Comprehensive Full Body Checkup requires two different samples - one is a  blood sample and the second is a urine sample. For the blood test, since Blood Sugar Fasting and Lipid Profile are included in this test, 12-hour fasting is necessary before giving the sample\r\nThis is to ensure accurate results during the test. While fasting, drinking water and eating regular medicines are allowed.\r\n\r\nAnother preparation that needs to be done is the presence of a plastic sterile container for the urine sample. The urine sample should ideally be the mid-stream sample of the first urine passed in the morning. This container should not be contaminated with any other substance as it can alter the result.\r\n\r\nThis is the only preparation required for this Comprehensive Full Body Checkup.', 'This set of tests provides valuable readings of:\r\n\r\nComplete Blood Count (CBC)\r\nThe number of different blood cells (red blood cells, white blood cells, platelets) in the body, Can help to understand if the person has anaemia, some infection, bone marrow disorder, or an autoimmune condition.\r\n\r\nHaemoglobin\r\nErythrocyte (RBC) Count\r\nTotal Leucocytes (WBC) Count\r\nWBC-DC\r\nPacked Cell Volume (PCV)\r\nPlatelet count\r\nMean Cell Volume (MCV)\r\nMean Cell Haemoglobin (MCH)\r\nMean Corpuscular Hb Conc. (MCHC)\r\nAEC (Absolute Eosinophil Count)\r\nAbsolute Neutrophil Count\r\nAbsolute Lymphocyte Count\r\nAbsolute Monocyte Count\r\nAbsolute Basophils Count\r\nPDW\r\nMean Platelet Volume (MPV)\r\nRDW SD\r\nRDW CV\r\nPlatelet to large cell ratio\r\nPCT\r\nDiabetic Screen\r\nThe diabetes screen has to be after 10 hours of fasting. This test checks for the basic parameters of diabetes. It does not include Post Prandial Blood Sugars.\r\n\r\nBlood sugar fasting (FBS)\r\nHba1C (Glycosylated haemoglobin)\r\nAverage Blood Glucose\r\nLipid Profile\r\nThese tests measure the amount of fat (cholesterol and triglycerides) in the blood. The comprehensive health check-up includes both good cholesterol and bad cholesterol. Additionally, it also provides the result of triglycerides.\r\n\r\nLDL direct\r\nCholesterol\r\nHDL cholesterol\r\nSerum VLDL cholesterol\r\nTriglycerides\r\nTC/HDL Cholesterol Ratio\r\nLDL cholesterol\r\nLiver Function Test (LFT)\r\nThese sets of tests indicate the performance and condition of the liver by measuring some of the liver enzymes. These tests can indicate a range of disease conditions related to digestive problems or overall immunity and health.\r\n\r\nAlbumin\r\nAlbumin-to-Globulin Ratio (AGR)\r\nAlkaline phosphatase (ALP)\r\nSGPT (ALT)\r\nSGOT (AST)\r\nBilirubin-Direct\r\nBilirubin-Indirect\r\nBilirubin-Total\r\nGlobulin\r\nProteins\r\nSGOT/SGPT Ratio\r\nThyroid Profile - Total (T3, T4 & TSH)\r\nThese tests measure the Thyroid Stimulating Hormone (TSH) which is responsible for the functioning of the Thyroid gland. T3 and T4 are hormones produced by the Thyroid gland. Together they regulate the metabolism of the body and the test can diagnose Hypothyroidism or Hyperthyroidism.\r\nT3\r\nT4\r\nTSH\r\nUrine Routine & Microscopy (Urine R/M)\r\nThe urine routine test measures and analyses the urine across several parameters which can indicate disease conditions such as kidney stones, urinary tract infections, kidney injuries or kidney performance.\r\n\r\nColour\r\nAppearance\r\nSpecific Gravity\r\npH-value\r\nProteins\r\nUrine Glucose\r\nNitrite\r\nBilirubin-Total\r\nErythrocyte (RBC) Count\r\nTotal Leucocytes (WBC) Count\r\nUrine Epithelial Cells\r\nBacteria\r\nCasts\r\nCrystals\r\nVolume\r\nKetones\r\nUrine Blood\r\nUrobilinogen\r\nParasites\r\nYeast Cells\r\nOthers\r\nIron Deficiency Profile\r\nThis test measures not only the free iron in the bloodstream but also the elements required to bind that iron to the red blood cells as haemoglobin. This test helps diagnose the cause of anaemia. If the haemoglobin is low, then this test helps the doctor understand if it is due to poor intake of iron-rich foods, poor absorption or some other reasons.\r\n\r\nIron\r\nTotal Iron Binding Capacity\r\nUIBC\r\nTransferrin Saturation\r\nRenal/Kidney Function Test\r\nA renal function test or kidney function test measures the performance of the kidneys and if they are under stress. Increased creatinine can indicate raised blood pressure levels. Increased uric acid would indicate the possibility or presence of Gout or other crystal-induced inflammatory pathologies. These tests can estimate the overall performance of the kidneys.\r\n\r\nUrea\r\nBlood urea nitrogen (BUN)\r\nUric acid\r\nCreatinine\r\nBUN/Creatinine Ratio\r\nUrea/Creatinine Ratio\r\nEGFR\r\nOther tests:\r\n\r\nVitamin B12\r\nVitamin D Total\r\nPeripheral smear', 'The Comprehensive Full Body Checkup along with the Vitamin test package provides an ideal all-encompassing option for people keen to monitor their health. Many diseases are silent in their origins and may present with a few vague symptoms or no symptoms at all. Diabetes is a prime example of one such illness. The Comprehensive Health Checkup includes some necessary tests for diabetes, such as HbA1c, Lipid Profile, Liver and Kidney Function Tests and other important tests like Vitamin D and B12.\\n\r\n\\n\r\n\\nOther Names of Comprehensive Full Body Checkups  \r\nComprehensive health check-up with Vitamin profile test.\r\n\\nWhat Does the Comprehensive Full Body Checkup  Detect?\r\nA comprehensive health check-up can help your doctor to detect a variety of disease conditions.\r\n\\n\\n\r\n\\nThe HbA1c and Blood Sugar Fasting can detect early diabetes or pre-diabetes.\r\n\\nThe Urine sample can provide signs of any urinary tract infection or kidney stones.\r\n\\nThe renal function test will indicate possible early kidney diseases such as renal failure, kidney stones or complications arising due to high blood pressure.\r\n\\nThe CBC test or complete blood count can provide diagnostic indications for:\r\nAnaemia\r\nLocal infection\r\nWorms in the stomach\r\nPoor blood development\r\nPoor immunity as low white blood cells\r\nDengue and other disorders with low platelets.\r\nAllergic problems by raised eosinophil counts\r\n\\n\\nThe Vitamin profile test included with this package provides the Vitamin D and Vitamin B12 packages.\r\nDue to these parameters, early detection of Vitamin deficiencies that can cause other symptoms is possible.\r\n\\n\\n\r\nFor whom is the Comprehensive Full Body Checkup useful?\r\n\\nIt is more suited for a younger populace with few to no pre-existing disease conditions. In addition, the comprehensive health check-up is intended more as a screening test than a diagnostic one. Therefore, it is best for males and females of all age groups.\r\n\\n\\n\r\nWhy is the Comprehensive Full Body Checkup  Prescribed?\r\nThe Comprehensive Full Body Checkup test is prescribed as a precautionary measure or a screening test when the diagnosis is not known. This package with the Vitamin profile test ensures that the most vital elements needed for the proper functioning of the body are measured and recorded. It is a test prescribed for those seeking an annual health check-up and status update of the vital parameters. The comprehensive entire-body check-up test is useful for people who have more than one disease condition to monitor — for example, Diabetes, Cholesterol and some liver or renal disorders.', 'N/A', 4899, 3999, 'testPackages.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `p_id` int(6) NOT NULL,
  `p_name` varchar(64) NOT NULL,
  `p_dob` date DEFAULT NULL,
  `p_gen` varchar(6) DEFAULT NULL,
  `p_image` text DEFAULT NULL,
  `p_email` varchar(64) NOT NULL,
  `p_phn` varchar(10) NOT NULL,
  `p_pass` varchar(32) NOT NULL,
  `p_reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `p_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`p_id`, `p_name`, `p_dob`, `p_gen`, `p_image`, `p_email`, `p_phn`, `p_pass`, `p_reg_date`, `p_status`) VALUES
(1, 'Protap Barman', '1999-10-13', 'Male', '7893Protap Barman.jpeg', 'yoyobprotap@gmail.com', '8327507847', '361633153a464830a1fe85dec5efab17', '2024-01-23 13:31:14', 1),
(7, 'Sukanta Prashad', '2024-01-30', 'Male', NULL, 'sukradheprasad@gmail.com', '9832467300', 'e2fc714c4727ee9395f324cd2e7f331f', '2024-02-19 14:51:31', 1),
(8, 'Subham Roy', '2003-07-25', 'Male', NULL, 'subhamroy3725@gmail.com', '9641857774', 'e2fc714c4727ee9395f324cd2e7f331f', '2024-02-19 15:41:10', 1),
(9, 'Pawan Das', '2003-05-16', 'Male', NULL, 'daspawan53785@gmail.com', '7478991407', 'e132e96a5ddad6da8b07bba6f6131fef', '2024-02-19 15:46:05', 1),
(10, 'Riya Barman', '2001-12-25', 'Female', NULL, 'riyabarmanslkclg@gmail.com', '8597217314', 'e2fc714c4727ee9395f324cd2e7f331f', '2024-02-24 18:36:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sl_id` int(6) NOT NULL,
  `m_id` int(6) NOT NULL,
  `p_id` int(6) NOT NULL,
  `sl_qty` int(4) NOT NULL,
  `sl_amnt` int(6) NOT NULL,
  `o_id` int(6) DEFAULT NULL,
  `sl_pay_amnt` int(6) NOT NULL,
  `sl_time` date NOT NULL DEFAULT current_timestamp(),
  `dl_id` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `sp_id` int(6) NOT NULL,
  `sp_name` varchar(64) NOT NULL,
  `health_concern` text DEFAULT NULL,
  `sp_descr` text DEFAULT NULL,
  `sp_image` text DEFAULT NULL,
  `sp_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`sp_id`, `sp_name`, `health_concern`, `sp_descr`, `sp_image`, `sp_status`) VALUES
(1, 'Nil', NULL, 'Nil', NULL, 1),
(2, 'Cardiology', 'Cardiac Care', 'Electrocardiogram (ECG or EKG): Assesses the heart\'s electrical activity. Echocardiogram: Uses sound waves to create images of the heart.', '6324cardiology.png', 1),
(3, 'Dermatology', 'Skin Care', 'Focuses on the diagnosis and treatment of skin-related conditions.', '9774dermatology.jpg', 1),
(5, 'Neurology', 'nervous system', 'Deals with disorders of the nervous system, including the brain and spinal cord.  A neurologist is a physician specializing in neurology and trained to investigate, diagnose and treat neurological disorders.[2] Neurologists diagnose and treat myriad neurologic conditions, including stroke, epilepsy, movement disorders such as Parkinson\'s disease, brain infections, autoimmune neurologic disorders such as multiple sclerosis, sleep disorders, brain injury, headache disorders like migraine, tumors of the brain and dementias such as Alzheimer\'s disease.[3] Neurologists may also have roles in clinical research, clinical trials, and basic or translational research. Neurology is a nonsurgical specialty, its corresponding surgical specialty is neurosurgery.', '4596neurology-image.jpg', 1),
(9, 'Gastroenterology', 'Stomach Care', 'Gastroenterology is the study of the normal function and diseases of the esophagus, stomach, small intestine, colon and rectum, pancreas, gallbladder, bile ducts and liver. It involves a detailed understanding of the normal action (physiology) of the gastrointestinal organs including the movement of material through the stomach and intestine (motility), the digestion and absorption of nutrients into the body, removal of waste from the system, and the function of the liver as a digestive organ. It includes common and important conditions such as colon polyps and cancer, hepatitis, gastroesophageal reflux (heartburn), peptic ulcer disease, colitis, gallbladder and biliary tract disease, nutritional problems, Irritable Bowel Syndrome (IBS), and pancreatitis. In essence, all normal activity and disease of the digestive organs is part of the study of Gastroenterology.', '2702gastroenterology.jpg', 1),
(12, 'Endocrinology', 'diabetes care', 'Endocrinology involves caring for the person as well as the disease. Most endocrine disorders are chronic diseases that need lifelong care. Some of the most common endocrine diseases include diabetes mellitus, hypothyroidism and the metabolic syndrome. Care of diabetes, obesity and other chronic diseases necessitates understanding the patient at the personal and social level as well as the molecular, and the physician–patient relationship can be an important therapeutic process.', '5602endocrinology.png', 1),
(13, 'Hepatology', 'liver care', 'Hepatology is a branch of medicine concerned with the study, prevention, diagnosis, and management of diseases that affect the liver, gallbladder, biliary tree, and pancreas. The term hepatology is derived from the Greek words “hepatikos” and “logia,” which mean liver and study, respectively.', '6001heptalogy.png', 1),
(14, 'Virology and immunology', 'cold and immunity', 'The common cold is a complex infectious syndrome caused by any one of a large number of antigenitically distinct viruses found in four groups. These groups are the myxo- and paramyxoviruses, the adenoviruses, the rhinoviruses and the coronaviruses. The members of the different groups differ in their physical, biochemical, and immunologic characteristics. With currently available methods, it is possible to determine the cause of 60-70% of colds. The large rhinovirus group is the most important of the known common cold viruses, accounting for approximately 30% of colds. These small RNA viruses have a genome of 7000 nucleotides, which shares considerable homology with poliovirus. The capsid of the rhinovirus is loosely packed, resulting in a relative acid sensitivity compared to the enteroviruses. Although there are at least 89 different antigenic types, all rhinoviruses attach to either one of two cellular receptors. Immunity to rhinovirus is type-specific and associated with neutralizing antibody in nasal secretions and serum. There is a steady acquisition of antibody to the rhinoviruses during childhood and adolescence. The rhinoviruses may be undergoing slow antigenic drift.', '7950virology.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `s_id` int(6) NOT NULL,
  `s_uname` varchar(64) NOT NULL,
  `s_name` varchar(64) NOT NULL,
  `s_role` varchar(32) NOT NULL,
  `s_dob` date DEFAULT NULL,
  `s_gen` varchar(6) DEFAULT NULL,
  `s_addr` text DEFAULT NULL,
  `s_email` varchar(64) NOT NULL,
  `s_phn` varchar(10) NOT NULL,
  `s_pass` varchar(32) NOT NULL,
  `s_join_date` date NOT NULL,
  `s_salary` int(6) DEFAULT NULL,
  `s_qualif` text DEFAULT NULL,
  `s_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`s_id`, `s_uname`, `s_name`, `s_role`, `s_dob`, `s_gen`, `s_addr`, `s_email`, `s_phn`, `s_pass`, `s_join_date`, `s_salary`, `s_qualif`, `s_image`) VALUES
(1, 'admin', 'Mr. Protap', 'superadmin', '1999-10-13', 'Male', 'Sitalkuchi, Cooch Behar, 736158', 'protapbarman02@gmail.com', '6297143266', '21232f297a57a5a743894a0e4a801fc3', '2024-01-23', 8000, 'BCA(IGNOU)', '4068Protap Barman.jpeg'),
(2, 'ramdas6', 'ram das', 'medicine_store_staff', '2024-03-14', 'Male', 'kolkata', 'ramdas@gmail.com', '6297143266', 'ec6a6536ca304edf844d1d248a4f08dc', '2024-03-22', 1200, 'afwefe', NULL),
(3, 'shyamdas7', 'shyam das', 'technician', '2024-03-07', 'Female', 'sadasdsa', 'shyamdas99@gmail.com', '1234567890', '81dc9bdb52d04dc20036dbd8313ed055', '2024-03-21', 233, 'faa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `t_id` int(6) NOT NULL,
  `t_name` varchar(64) NOT NULL,
  `t_fee` int(6) NOT NULL,
  `t_final_fee` int(6) NOT NULL,
  `t_sample_type` varchar(64) DEFAULT NULL,
  `t_preparation` text DEFAULT NULL,
  `t_short_descr` text DEFAULT NULL,
  `t_descr` text DEFAULT NULL,
  `t_process` text DEFAULT NULL,
  `t_caution` text DEFAULT NULL,
  `t_image` text DEFAULT NULL,
  `t_book_count` int(6) NOT NULL,
  `t_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`t_id`, `t_name`, `t_fee`, `t_final_fee`, `t_sample_type`, `t_preparation`, `t_short_descr`, `t_descr`, `t_process`, `t_caution`, `t_image`, `t_book_count`, `t_status`) VALUES
(1, 'N/A', 0, 0, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', NULL, 0, 0),
(7, 'Fasting Blood Sugar (FBS)', 299, 119, 'Blood', 'Before the test\r\nYou need to fast for 8 to 10 hours the previous night and give your blood for testing your fasting blood sugar in the morning. During the period of fasting, the person can have water. No food is allowed. Regular medication, including diabetes medication, should be taken as prescribed.', 'Also known as:  Fasting blood glucose, Fasting Glucose Test', 'The Fasting Blood Sugar Test is a blood glucose test that helps determine blood sugar levels in your body after fasting for more than eight hours. It helps detect prediabetes, type 1 diabetes, type 2 diabetes, gestational diabetes, and other types of diabetes. Fasting blood sugar levels above 125 mg/dL, indicate a possibility of diabetes mellitus, and the patient must be evaluated by a doctor. Your fasting sugar readings may be high if you have prediabetes, diabetes or gestational diabetes. This test is beneficial for routine monitoring of blood sugar levels in people diagnosed with diabetes. Regular monitoring and well-controlled blood sugar can minimise the risk of severe complications due to diabetes. This test can be taken by people of all age groups and/or as recommended by your doctor.', 'During the test\r\nThere are no specific instructions during the blood sugar fasting test. It is a quick blood test that gets done in 5-10 minutes. The blood sample is taken from the veins of your arm. Dress accordingly.\r\n\r\nAfter the test\r\nA routine schedule can be followed after the blood sugar fasting test. In some cases, the blood sugar postprandial test might also be needed. Check with the doctor and accordingly carry on the rest of the activity throughout the day.\r\n\r\nTest inclusions: What parameters are included in the blood sugar fasting test?\r\nThe blood sugar fasting test measures the blood sugar levels in your body 8 to 10 hours after the last meal.', 'You need to fast for 8 to 10 hours the previous night and give your blood for testing your fasting blood sugar in the morning.', 'testCategories.png', 0, 1),
(8, 'Lipid Profile', 799, 399, 'Blood', 'Fasting Required of 10-12 Hrs', 'Lipid Profile Test results help detect the levels of blood cholesterol and triglycerides.', 'This helps identify the problem early on and reduce the risk of high blood pressure, heart disease and stroke through necessary treatment and lifestyle modifications. It measures Total Cholesterol, Serum Triglycerides, Serum HDL, Serum LDL and Serum VLDL. The test also measures the Total Cholesterol/HDL Cholesterol Ratio. Factors such as obesity, lack of exercise, unhealthy diet, alcohol consumption and cigarette smoking are some of the many causes that can lead to a deranged lipid profile. This test can be taken by people of all age groups.', 'The lipid profile test is a profile that requires fasting for 12 hours before performing the test. Consumption of food or drinks is not allowed (only water is allowed) 12 hours before the test.\r\n\r\n\r\nThe typical way to collect a blood sample is by drawing blood from the most prominent vein in the forearm. The procedure for lipid profile test involves one single prick of the needle. Typically, the blood collection procedure lasts 5 minutes. A minimum of 12 hours of fasting is the only preparation for the lipid profile test.', 'N/A', 'testCategories.png', 0, 1),
(9, 'Post Prandial Blood Sugar (PPBS)', 299, 119, 'Blood', 'The Blood Sugar Postprandial Test requires you to give a blood sample to conduct the test. The sample is taken 2 hours after you begin your meal (one full meal), usually lunch. Take all your medicines as prescribed.', 'The Postprandial Blood Sugar Test can help detect prediabetes, type 1 diabetes, type 2 diabetes, gestational diabetes, and other types of diabetes.', 'It is a blood glucose test that helps determine your blood sugar levels two hours after a meal. If your postprandial blood sugars are above 140-200 mg/dL, it indicates that you may have diabetes mellitus. This test is also recommended for people with diabetes to monitor their sugar control. Regular monitoring and well-controlled postprandial blood sugar can help minimise the risk of cardiovascular and other health complications due to diabetes. The test can be taken by people of all age groups or as recommended by your doctor.', 'There are no instructions for you to observe during the Blood Sugar Postprandial Test. It is a simple and quick blood test, and the sample drawing gets done in 5-10 minutes. After the Blood Sugar Postprandial Test, you can return to your routine.', '', 'testCategories.png', 0, 1),
(10, 'Thyroid Profile Test (T3, T4, UTSH) / TFT', 699, 399, 'Blood', 'The thyroid profile test is a blood test that does not require fasting or any specific preparation. The usual way to collect a blood sample is by drawing it from one of the veins. This vein is usually the most prominent one in the forearm of a person. This procedure lasts for 5 minutes.', 'Also known as:  Thyroid Function Test, Thyroid Panel', 'The Thyroid Profile Test can help with the diagnosis of a thyroid disorder. It is also helpful in monitoring the effectiveness of treatment for people who are already diagnosed with thyroid-related diseases such as Hypothyroidism, Hyperthyroidism etc. The test measures three important parameters - Total T3, Total T4, and Serum TSH levels. T3 and T4 hormones regulate the body\'s metabolism and growth, whereas UTSH helps control the secretions of the thyroid gland. Problems like hair loss, dry skin, unexplained weight gain or loss, mood swings, muscle cramps, lassitude, depression or anxiety, constipation, menstrual irregularities and unexplained weakness are often associated with an underlying thyroid disorder.', 'The thyroid profile test includes the following parameters:\r\n\r\nThe range or value of total T3 hormone in the blood.\r\nThe quantity of total  T4 hormone in the blood.\r\nThe value of TSH or the Thyroid Stimulating Hormone in the blood.\r\n \r\n\r\nThese are the only three parameters covered under this test. These values give an idea about the functioning of the thyroid gland and if its improper functioning is affecting other hormones. The result of the thyroid profile test is not expressed as positive or negative. If the value is on the higher side or lower side, it is an indicator of a disorder with the thyroid gland.', '', 'testCategories.png', 0, 1),
(11, 'Blood Group Test', 449, 239, 'Blood', 'The Blood Group Test procedure hardly requires any specific preparations. There is no need for fasting before the blood sample is taken.\r\n\r\nIf the individual is taking any medications or following a medication regimen, they may consult with their healthcare professional to know whether or not they need to stop taking the medicine before the sample is collected.', 'Also known as:  Blood Typing Test, ABO Typing Test.', 'The Blood Group Test is performed to learn about the type of blood group a person has. The Blood Group Test becomes very important when a person either wants to donate blood to somebody or wants to receive blood from someone (blood transfusion).', 'Step One: You\'re obtained blood sample is mixed with the antibodies of two types of blood groups, Type A and Type B. After mixing, the blood sample is analysed to see if the blood cells have stuck together. If the blood cells end up sticking together, then this means that the blood sample has reacted with one of the antibodies.\r\n\r\nStep Two: The liquid part of the blood sample without cells (called serum) is then mixed up with type A and type B blood. Based on this step, it is determined that people with the type A blood group have anti-B antibodies and people with the type B blood group have anti-A antibodies. In contrast, the Type O blood group contains both types of antibodies: anti-A and anti-B.\r\n\r\nStep Three: This step determines whether the blood group is positive or negative based on the presence of the Rh factor in the Blood Group Test blood sample.', '', 'testCategories.png', 0, 0),
(12, 'Glycosylated Hemoglobin (HbA1c)', 699, 499, 'Blood', 'The glycosylated haemoglobin test requires you to give a sample of your blood. When performed, the technician will take the blood sample from your vein. The blood sample is taken by pricking the finger with a needle.', 'The HbA1c Profile, also known as Glycosylated Hemoglobin, also called Glycated Hemoglobin or Hemoglobin A1c', 'with the screening, diagnosis and monitoring of diabetes or prediabetes in adults. It enables you to identify if you are on the edge of developing diabetes. If you already have diabetes mellitus, the HbA1C test results help monitor your blood sugar levels.', 'Before the HbA1C test\r\nThis test does not require any specific preparations from your end. You can take the test at any time during the day before or after meals. But if your doctor prescribes a series of other tests, along with the HbA1C test, then you may need to prepare accordingly.\r\n\r\nDuring the HbA1C test\r\nYou do not need to prepare for anything during the HbA1C test. It is a simple blood test that takes about 5-10 minutes.\r\n\r\nAfter the HbA1C test\r\nThere are no restrictions after taking this test. You can return to your usual activities after the HbA1C test.', '', 'testCategories.png', 0, 1),
(13, 'Albumin Creatinine Ratio (ACR) / Urine For Microalbuminuria', 1299, 699, 'Urine', 'There is no preparation needed when you are getting tested for Albumin in your urine.\r\n\r\nHowever, you may be asked by the doctor to avoid eating meat, and strenuous exercise before getting tested for Creatinine. Eating meat may affect your Creatinine levels.', 'The Albumin Creatinine Ratio (ACR)/Urine For Microalbuminuria test values help to determine the level of protein being excreted in the urine, indicating kidney health and the overall nutritional status of the body.', 'The human body constantly needs the energy to function. The energy it derives is from the proteins (that the cells prepare) and the food we eat. A good amount of protein means more energy in the body. But excess of anything, even protein, is always harmful.\r\n\r\nTwo such proteins that are present in human blood are Albumin and Creatinine. Their function is to provide energy to your cells so that your body can function smoothly. The organ responsible for the creation of these proteins is the Liver.\r\n\r\nAlbumin is one of the most critical proteins in your system, as it is responsible for repairing damaged tissues. Albumin also helps your tissue cells grow with the energy that it packs inside. On the other hand, Creatinine is a chemical compound leftover from energy-producing processes in your muscles.\r\n\r\nOnce Albumin and Creatinine enter your urine, it can turn out to be harmful to your body as it can lead to severe diseases. It is the Kidney’s job to prevent it from happening. A healthy kidney will not let large amounts of Albumin and Creatinine enter the urine.', 'The test can be done at home as well by using these methods:\r\n\r\nSelf-test kits\r\nA dip-stick test, where you use a special paper or a dip-stick and dip it in a cup of urine. The stick/paper will change colour depending upon the amount of Album and Creatinine available in your urine.\r\n\r\nSelf-collection kits\r\nA special kind of cup/bag is given to you by your doctor. You will have to store the sample in one of those cups/bags and send it to the laboratory for a 24-hour test. Once you receive the Albumin/Creatinine test results, your doctor will give you further details.\r\n\r\nTest Inclusions: What Parameters Are Included?\r\nThe doctor may order you to take the Albumin/Creatinine test in order to:\r\n\r\nDiagnose if you have any kidney disorders or diseases.\r\nMonitor the progression of your kidney disease treatment.\r\nThe Albumin/Creatinine test determines the amount of protein in your urine and subsequently helps determine your kidney’s health.', '', 'testCategories.png', 0, 1),
(14, 'Creatinine Test', 279, 199, 'Blood', 'The creatinine test does not require fasting or any specific preparation. The serum creatinine level is measured by using a blood sample. It is collected through a prominent vein of the forearm using a needle or syringe. The collected blood is sent to a laboratory for results.', 'The Creatinine Test is taken to evaluate the health of your kidneys by estimating the creatinine levels in your blood.', 'Muscles help in the movement of our bodies, but they need creatine to function, which is an organic acid that supplies energy to cells. When it breaks down, creatinine is produced as a waste by-product. It is then carried to the kidney via blood. This creatinine later tells physicians whether or not our kidneys are working properly.  \r\n\r\nImproper functioning of kidneys is shown by symptoms like fatigue, loss of appetite, lower back pain, change in the amount and frequency of urine, nausea, and vomiting. The consulting doctor will ask you to check the creatinine levels, which are tested through a creatinine test. And the test tells the doctors whether the kidneys are working properly.\r\n\r\nHigh levels of creatinine show the kidney is not working properly. It can be due to bacterial infection, kidney stones, diabetes, or dehydration.\r\n\r\nThe creatinine test is also performed as a part of other tests like the Blood Urea Nitrogen (BUN) test, Kidney function test and Basic Metabolic Panel (BMP).', 'The creatinine test considers the following parameters:\r\n\r\nThe value of creatinine in the blood. It is expressed as milligrams per deciliter (mg/dL) of blood.\r\nThe result of the creatinine test is expressed as normal, high or low. High levels indicate the improper working of kidneys due to some underlying health conditions. A low level indicates malnutrition or muscle loss.', '', 'testCategories.png', 0, 0),
(15, 'C-Reactive Protein (CRP) Test - Quantitative', 949, 599, 'Blood', 'There is no need to prepare for the test, as it\'s a simple blood test. However, the doctor may ask you to fast for 9-12 hours before the sample collection, if you need to get other tests done that require fasting.', 'A C-reactive Protein Test measures the level of CRP (produced by the liver) in your blood.', 'The C-reactive protein belongs to a class of proteins known as acute phase reactants. The acute-phase reactant increases in response to inflammatory conditions. \r\n\r\nWhen the body is under threat by infection or other conditions, the liver releases CRP into the bloodstream. It is the body\'s defence mechanism against cellular intruders. CRP levels are responses to inflammatory reactions.\r\n\r\nChronic illnesses like autoimmune diseases might trigger the acute phase response. CRP is a positive acute-phase reactant since it is an early responder. \r\n\r\nThe CRP levels help doctors understand the severity of the inflammatory process, and the levels do not indicate the location of the inflammation.', 'CRP test includes parameters of the quantity of C reactive protein. Quantitative CRP test results give the exact value of C-reactive proteins in the blood.\r\n\r\n\r\nThere is only one parameter included in the CRP test. This value gives an idea about the inflammatory response of the body. Various values of CRP levels can give a clue about what could be the underlying cause. CRP levels indicate the presence of infection or injury.\r\n\r\n\r\nIf there is no inflammation in the body, the values will be within normal limits. CRP levels are used to monitor the treatment of infections.\r\n\r\n\r\nIf the body is fighting infection or recovering from trauma, values of CRP will be higher.\r\n\r\nIn acute conditions, with weak defence and low recovery rate, CRP values will be abnormally high for a longer duration.', '', 'testCategories.png', 0, 1),
(16, 'Cardiac Risk Markers', 1199, 899, 'Blood', 'Fasting Not required.', 'Cardiac Risk Markers Profile estimates the levels of cardiac risk markers in the body, which help in evaluating the functioning of the heart.', 'Cardiac risk markers are blood tests that predict the occurrence of coronary heart disease. High sensitivity C-Reactive Protein (hs-CRP), Apolipoprotein A-1, Apolipoprotein B, APOB/ APO A1 RATIO and Lipoprotein (A) totals. Factors that put you at a higher risk for cardiovascular diseases are cardiac risk factors, high blood pressure, high cholesterol and smoking are three key risk factors for heart disease.\r\n\r\n\r\nThese risk factors and having a family history of cardiovascular disease increase your risk of heart attacks and stroke. If you have these risk factors, it is ideal to adapt your lifestyle to help reduce them. Cardiac risk markers are chemicals secreted by the heart muscle when it is damaged or diseased. These chemicals are frequently examined in blood tests to assist doctors in diagnosing cardiac disease.\r\n\r\n\r\nPatients with an increase in cardiac risk markers results should be evaluated regularly because these proteins can boost degradation-inducing enzymes and harm the heart. A cardiac risk markers chart helps assess the risk of heart failure, coronary artery disease and myocardial infarction, among other cardiac disorders. The cardiac risk markers results help estimate the chances of future events rather than serve as a diagnosis.', 'N/A', '', 'testCategories.png', 0, 1),
(17, 'Covid IgG Antibody Test', 1599, 1000, 'Blood', 'The COVID IgG Antibody test takes a sample of your blood for testing. Your immune system requires time to produce antibodies against the COVID-19 virus. For accurate results, you must wait for at least 5-6 days after the onset of symptoms of COVID-19 infection. \r\n\r\na. Before the COVID IgG Antibody test\r\n\r\nThis test does not require any preparation from your end. Inform your physician about any recent symptoms of COVID-19 or if you have received your COVID-19 vaccine.', 'COVID IgG Antibody Test is a blood test that helps assess the presence/absence of COVID antibodies', 'The COVID IgG Antibody test helps determine if you have been infected by COVID-19 in the past. COVID-19 is caused by the SARS-CoV-2 coronavirus, which affects your lungs and other body organs.\r\n\r\nThe COVID IgG Antibody test is a blood test that determines the presence of antibodies against the SARS-CoV-2 coronavirus. Antibodies are proteins produced by your immune system to protect against certain infections. \r\n\r\nIf you have had COVID-19 symptoms in the past or if you have had persistent symptoms for a long time COVID IgG test should be done. A COVID IgG antibody test does not detect the presence of the SARS-CoV-2 virus to diagnose COVID-19. These tests can return a negative test result even in infected patients (for example, if antibodies have not yet developed in response to the virus) or may generate false-positive results (for example, if antibodies to another coronavirus type are detected), so they should not be used to evaluate if you are currently infected or contagious (ability to infect other people).', 'During the COVID IgG Antibody test\r\n\r\nIt is a simple blood test that will get over in 5-10 minutes. You do not need to prepare for the test in any way but do not forget to follow COVID-appropriate behaviour (wear your mask properly). \r\n\r\nc.After the COVID IgG Antibody test\r\n\r\nThere are no restrictions after the COVID IgG Antibody test. You can resume normal activity.\r\n\r\nTest inclusions: What parameters are included in the COVID IgG Antibody test?\r\nThe COVID IgG Antibody Test report detects the quantity of IgG antibodies present in your body that have been formed against SARS-CoV-2.\r\n\r\nHow frequently should you take the COVID IgG Antibody test?\r\n If your symptoms are not resolving and remain persistent for long, then the COVID IgG Antibody test helps confirm past infection. Later, your doctor may repeat the COVID IgG Antibody test to check your recovery/immune status.', '', 'testCategories.png', 0, 1),
(18, 'Serum Electrolytes Test', 699, 399, 'Blood', 'There is no preparation needed to take the Serum Electrolyte Test. You can drink and eat as usual before taking the test. Using a small needle, your doctor will take a small blood sample from a vein in your arm. The blood will be collected into a test tube and will be sent to the laboratory for diagnosis. You may feel a slight sting when the needle is inserted. The entire test takes less than five minutes.', 'A Serum Electrolyte Test helps measure the electrolytes (Sodium, Potassium and Chloride)', 'A Serum Electrolyte Test is a method to screen your blood for an imbalance between your electrolytes. It also helps in measuring acid-base balance and evaluating kidney function. The Serum Electrolyte Test is often included in a routine physical examination and can be performed as a part of several other tests.\r\n\r\nA Serum Electrolyte Test is prescribed for people who show signs of weakness, confusion, irregular heartbeat or dehydration. Doctors also prescribe the test to people who come to the emergency room. If the serum electrolyte results show an imbalance in a specific electrolyte, your doctor will test your levels again until it returns to normal.\r\n\r\nThe result of your Serum Electrolyte Test will help your doctor evaluate the acid-base balance in your body. Electrolytes help maintain a balance between acids and bases and govern the movement of fluids in the body.\r\n\r\nElectrolytes that are present in our body include phosphate, potassium, sodium, calcium, chloride and magnesium. These charged electrolytes can be found in your body fluids, urine and blood. One also ingests these electrolytes via beverages and food. There are various roles of electrolytes in your body, including conducting nerve impulses, muscle contraction, preventing dehydration and so on.\r\n\r\nYour body needs to maintain a balanced level of electrolytes for proper functioning. Electrolyte imbalances can cause severe disorders such as cramps, seizures, cardiac arrest or coma.', 'A Serum Electrolyte Test measures the number of electrolytes in your body. The electrolytes measured in the test are:\r\n\r\nSodium: Sodium is a vital electrolyte that helps your body maintain a balance between your pH and water levels. It also plays a role in cellular metabolism and supports the nerve conduction of nerve impulses. This, in turn, helps in regulating muscle contraction and relaxation. Your body absorbs the required sodium and excretes the rest via the kidney. Hence, sodium levels can give an idea about your kidney functions.\r\nPotassium: Potassium is an essential electrolyte that participates in several vital functions of the body. It helps in the regulation of fluids present in the body and helps in the homeostasis of pH.\r\nChloride: Chloride helps in maintaining the optimum level of electrolytes and fluid in the body. It also functions as a buffer and helps in maintaining pH balance. This electrolyte plays a vital role in producing hydrochloric acid in the stomach. Your kidneys excrete excessive chloride after absorbing an optimal amount.\r\nThe Serum Electrolyte Test cannot evaluate organ function or disease. It only indicates some abnormality related to acid-base balance in the body. If the serum electrolyte level is higher or lower than the average value, your doctor will prescribe further tests to determine a final diagnosis.', '', 'testCategories.png', 0, 1),
(19, 'Human Leukocyte Antigen B27 (HLA B27)', 1999, 4999, 'Blood', 'To give the HLA-B27 Test blood sample, there is not much preparation required by you before the sample. You need not fast and may eat and drink as you regularly do before giving the blood sample.\r\n\r\nHowever, if you are taking some medications or vitamin supplements, then you should make sure to check with your doctor before taking medicine or supplements before giving your blood sample.\r\n\r\nThere are no major risks involved in giving a blood sample for the HLA-B27 Test. However, you may feel dizzy and a little weak after giving your blood sample. If this happens, you should call for someone to help you get back home and rest afterwards.', 'The HLA-B27 Test helps in the diagnosis of various autoimmune diseases', 'The HLA-B27 Test is suggested by your healthcare practitioner to know whether your white blood cells have the HLA-B27 protein present on their surface.\r\n\r\nSimply put, there are many kinds of HLAs or Human Leukocyte Antigens that can be found on the surface of the white blood cells. These antigens play an important role in identifying the cells that belong to the body and are healthy and also the cells that are foreign and can be dangerous.\r\n\r\nUpon recognising any cell as ‘foreign and dangerous, the Human Leukocyte Antigens set out to destroy it to protect your body from any harm that they could have caused. However, the HLA-B27 kind of protein (or antigen) can possibly contribute to the dysfunction of your body’s immune system.\r\n\r\nThe HLA-B27 protein can lead to your immune system destroying even the healthy cells of your body and so, the presence of HLA-B27 protein on the surface of white blood cells is often associated with autoimmune disorders.', 'The HLA-B27 Test requires the person to give a blood sample. The HLA-B27 Test blood sample collected from the individual is then evaluated.', '', 'testCategories.png', 0, 1),
(20, 'Liver Function Test (LFT)', 1099, 499, 'Blood', 'The liver function test is a blood test that may require a fasting blood sample (fasting of 10-12 hours). The usual way to collect a blood sample is by drawing it from one of the veins. The most prominent vein is the one in the forearm of a person. The LFT procedure usually lasts for 5-10 minutes. You can continue with routine activity after the test.', 'Liver Function Test consists of various blood tests that may help diagnose and monitor liver-related diseases.', 'Liver is one of the essential organs in the body. It performs various functions, including detoxification, protein synthesis and the production of biochemicals vital for digestion. Thus, it makes the liver prone to many diseases. Hence, getting LFT done for general check-ups, investigating liver diseases or assessing liver functionality is vital.\r\n\r\n\r\nThere are a variety of liver function tests that assess proteins and enzymes in the blood. Any fluctuations in these LFT test values indicate liver abnormality.\r\n\r\n\r\nOther names of liver function test\r\n\r\nLiver panel\r\nLiver function panel\r\nLiver profile hepatic function panel\r\nHepatic function test\r\nLiver profile\r\nLiver function evaluation\r\nLFT', 'The liver function test includes the following parameters:\r\n\r\n\r\nTransaminases\r\n\r\nAspartate (AST or SGOT) and alanine (ALT or SGPT) are enzymes present in large quantities in the liver. ALT is an enzyme primarily present in the liver. In comparison, AST is an enzyme released from the heart, liver, skeletal muscle and kidney.\r\n\r\n\r\nSerum levels of ALT and SGOT are increased on damage to the tissues producing them. Thus, serum estimation of SGPT is specific for liver diseases. In contrast, SGOT levels may rise in case of muscle or liver cell injury.\r\n\r\n\r\nGamma-Glutamyl Transpeptidase (GGT)\r\n\r\nThe primary source of this enzyme is the liver. Elevation of GGT occurs in cholestasis (a condition where bile flow from the liver is blocked or stopped) and liver diseases. GGT levels are often high in patients with alcohol abuse.\r\n\r\n\r\nAlbumin \r\n\r\nAlbumin is a protein that is synthesised in the liver. It performs various functions such as providing nourishment to tissues and transporting of vitamins, hormones, medications and other substances. The blood level of albumin is decreased in extensive liver damage or disease.\r\n\r\n\r\nBilirubin\r\n\r\nBilirubin is a waste product made by the liver after the breakdown of red blood cells. Bilirubin is excreted in the stool via the liver. Elevated bilirubin level indicates liver disease or damage or certain types of anaemia.\r\n\r\n\r\nAlkaline Phosphatase (ALP)\r\n\r\nSerum alkaline phosphatase is found in the liver, bone, intestine and placenta. High ALP levels can mean cholestasis (partial or complete bile duct obstruction), bone regeneration, pregnancy and neoplastic, infiltrative and granulomatous liver diseases.\r\n\r\n\r\nGlobulin\r\n\r\nAlbumin/Globulin Ratio\r\n\r\nProteins\r\n\r\nSGOT/SGPT Ratio', '', 'testCategories.png', 0, 1),
(21, 'CBC', 799, 419, 'Blood', 'The CBC test per se does not require any special preparation. You need not fast before the test. You can have your usual food and drink as per routine. However, this test is often asked for some other blood investigations that may have restrictions prescribed for food and drinks. You can resume regular activity and eat and drink normally after the test.', 'A CBC Test or the Complete Blood Count Test is a blood test', 'A CBC test or the Complete Blood Count test is a blood test that helps determine your overall health status. This test can serve as a pointer to disorders ranging from different types of anaemia, infections, fever, inflammation and cancers.\r\n\r\n\r\nCBC test is usually prescribed as an essential blood test which can serve as a pointer towards more specific investigations. For example, it can be advised as a part of routine visits to your physician if your doctor suspects some illness or when you may complain about unusual complaints of bleeds or rashes or fevers, discomfort, bruising, etc.\r\n\r\n\r\nCBC test is also done at various stages of your treatment to predict treatment outcomes, to monitor the progress of the patient and it is part of different health check plans offered at multiple hospitals.', 'The CBC test measures levels of different components of blood which are as follows:\r\n\r\n\r\nRed blood cell (RBC) count is the measure of the number of red blood cells in your blood.\r\nHaemoglobin levels tell about the oxygen-carrying capacity of your blood.\r\nHaematocrit values give you the percentage of your total blood volume that contains red blood cells.\r\nReticulocyte count measures the absolute count of the young RBCs that have been newly released in the blood.\r\nMean corpuscular volume (MCV) measures the average size of the red blood cells.\r\nMean corpuscular haemoglobin (MCH) is a calculated measure of the average amount of haemoglobin inside the red blood cells.\r\nMean corpuscular haemoglobin concentration (MCHC) is a calculated measure of the average haemoglobin concentration inside the red blood cells.\r\nRed cell distribution width (RDW) measures the variation in the size of the red blood cells.\r\nWhite Blood Cell (WBC) count measures the number of white blood cells in your blood.\r\nWBC differential includes the different types of WBCs in your blood, namely:\r\nNeutrophils,\r\nEosinophils,\r\n Lymphocytes,\r\nMonocytes\r\nBasophils.\r\nThe individual counts of these WBCs are given as an absolute count and a percentage count.\r\n\r\nPlatelet count measures the number of platelets in your blood.\r\nMean platelet volume (MPV) is the measure of the average size of the platelets.\r\nPlatelet distribution width (PDW) measures the uniformity in the size of the platelets.', '', 'testCategories.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test_components`
--

CREATE TABLE `test_components` (
  `tc_id` int(6) NOT NULL,
  `tc_name` varchar(64) NOT NULL,
  `tc_lower_val` double DEFAULT NULL,
  `tc_upper_val` double NOT NULL,
  `tc_unit` varchar(24) DEFAULT NULL,
  `tc_range` text NOT NULL,
  `tc_descr` text DEFAULT NULL,
  `t_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_components`
--

INSERT INTO `test_components` (`tc_id`, `tc_name`, `tc_lower_val`, `tc_upper_val`, `tc_unit`, `tc_range`, `tc_descr`, `t_id`) VALUES
(6, 'AEC', 30, 350, 'cells/μL', 'N/A', '', 21),
(7, 'TOTAL LEUCOCYTES COUNT (WBC)', 0, 0, 'N/A', '4.0-10.0 x 103 / μL', '', 21),
(9, 'NEUTROPHILS', 40, 80, '%', 'N/A', '', 21),
(10, 'LYMPHOCYTE PERCENTAGE', 20, 40, '%', 'N/A', '', 21),
(11, 'IMMATURE GRANULOCYTE PERCENTAGE(IG%)', 0, 0, 'N/A', '<2%', '', 21),
(12, 'NEUTROPHILS - ABSOLUTE COUNT', 0, 0, 'N/A', '2.0-7.0 x 103 / μL', '', 21),
(13, 'LYMPHOCYTES - ABSOLUTE COUNT', 0, 0, 'N/A', '1.0 -3.0 x 103 / μL', '', 21),
(14, 'HEMOGLOBIN', 13, 17, 'g/dL', 'N/A', '', 21),
(15, 'MEAN CORPUSCULAR HEMOGLOBIN(MCH)', 27, 32, 'pq', 'N/A', '', 21),
(16, 'Low-Density Cholesterol (LDL)', 0, 0, 'N/A', '<100 mg/dL', '', 8),
(17, 'High-Density Cholesterol (HDL)', 0, 0, 'N/A', 'More than 60 mg/dL', '', 8),
(18, 'Triglycerides', 0, 0, 'N/A', '<150 mg/dL', '', 8),
(19, 'VLDL', 0, 0, 'N/A', '<30 mg/dL', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `test_pack_joint`
--

CREATE TABLE `test_pack_joint` (
  `pk_id` int(6) NOT NULL,
  `t_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_pack_joint`
--

INSERT INTO `test_pack_joint` (`pk_id`, `t_id`) VALUES
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(6, 12),
(9, 7),
(9, 8),
(9, 12),
(9, 14),
(9, 20),
(9, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addr`
--
ALTER TABLE `addr`
  ADD PRIMARY KEY (`addr_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `doc_appointment`
--
ALTER TABLE `doc_appointment`
  ADD PRIMARY KEY (`doc_a_id`);

--
-- Indexes for table `doc_schedule`
--
ALTER TABLE `doc_schedule`
  ADD PRIMARY KEY (`sc_id`);

--
-- Indexes for table `lab_appointment`
--
ALTER TABLE `lab_appointment`
  ADD PRIMARY KEY (`lab_id`);

--
-- Indexes for table `lab_app_details`
--
ALTER TABLE `lab_app_details`
  ADD PRIMARY KEY (`lab_d_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `medicine_order`
--
ALTER TABLE `medicine_order`
  ADD PRIMARY KEY (`mo_id`);

--
-- Indexes for table `medicine_order_details`
--
ALTER TABLE `medicine_order_details`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indexes for table `medicine_sub_category`
--
ALTER TABLE `medicine_sub_category`
  ADD PRIMARY KEY (`m_sc_id`);

--
-- Indexes for table `medicine_type`
--
ALTER TABLE `medicine_type`
  ADD PRIMARY KEY (`mt_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pk_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sl_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `test_components`
--
ALTER TABLE `test_components`
  ADD PRIMARY KEY (`tc_id`);

--
-- Indexes for table `test_pack_joint`
--
ALTER TABLE `test_pack_joint`
  ADD PRIMARY KEY (`pk_id`,`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addr`
--
ALTER TABLE `addr`
  MODIFY `addr_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `b_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `c_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ct_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `d_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `doc_appointment`
--
ALTER TABLE `doc_appointment`
  MODIFY `doc_a_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `doc_schedule`
--
ALTER TABLE `doc_schedule`
  MODIFY `sc_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lab_appointment`
--
ALTER TABLE `lab_appointment`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lab_app_details`
--
ALTER TABLE `lab_app_details`
  MODIFY `lab_d_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `m_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `medicine_order`
--
ALTER TABLE `medicine_order`
  MODIFY `mo_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `medicine_order_details`
--
ALTER TABLE `medicine_order_details`
  MODIFY `mod_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `medicine_sub_category`
--
ALTER TABLE `medicine_sub_category`
  MODIFY `m_sc_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `medicine_type`
--
ALTER TABLE `medicine_type`
  MODIFY `mt_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `pk_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `p_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sl_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
  MODIFY `sp_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `s_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `t_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `test_components`
--
ALTER TABLE `test_components`
  MODIFY `tc_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
