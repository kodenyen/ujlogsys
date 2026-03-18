-- SQL Migration: Add footer_text to settings
-- Run this in phpMyAdmin to add the footer text setting

ALTER TABLE settings 
ADD COLUMN footer_text VARCHAR(255) DEFAULT 'UJ Medical College of Health Science. All rights reserved.' AFTER org_logo;
