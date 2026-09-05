-- Travel Enquiries Table
-- This table stores travel enquiry form submissions
-- Run this SQL to create the table in your database

CREATE TABLE IF NOT EXISTS `travel_enquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_session_id` varchar(100) NOT NULL COMMENT 'Unique session ID to track form progress',
  `first_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `trip_type` text DEFAULT NULL COMMENT 'JSON array of selected trip values from dropdown',
  `selected_countries` text DEFAULT NULL COMMENT 'JSON array of countries selected from globe {code, name}',
  `number_of_people` int(11) DEFAULT NULL,
  `travel_month` varchar(20) DEFAULT NULL COMMENT 'Format: YYYY-MM',
  `message` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'draft' COMMENT 'draft, submitted',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `submitted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_form_session_id` (`form_session_id`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

