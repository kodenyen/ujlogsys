-- SQL Migration: Rename Section to Session
-- Run this in phpMyAdmin to fix the "Table ujlogsys.sessions doesn't exist" error

RENAME TABLE sections TO sessions;

ALTER TABLE attendance_records 
CHANGE section_id session_id INT;
