# Database Setup for Travel Enquiry Form

## Overview
The travel enquiry form now saves data to the database in two ways:
1. **Auto-save on blur**: When a user leaves an input field, the value is automatically saved
2. **Full submission**: When the form is submitted, all data is saved with status 'submitted'

## Database Configuration

1. **Update database credentials** in `/includes/db_config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'driveoffgrid'); // Your database name
   define('DB_USER', 'root'); // Your database username
   define('DB_PASS', ''); // Your database password
   ```

2. **Create the database table** by running the SQL file:
   ```sql
   -- Run this file: database/travel_enquiries_table.sql
   ```

## Table Structure

The `travel_enquiries` table includes:
- `form_session_id`: Unique ID to track form progress across multiple field saves
- `first_name`, `email`, `phone`: Basic contact information
- `trip_type`: JSON array of selected trips from dropdown (e.g., `["poland", "ireland"]`)
- `selected_countries`: JSON array of countries selected from globe (e.g., `[{"code":"PL","name":"Poland"}]`)
- `number_of_people`: Number of travelers
- `travel_month`: Travel month in YYYY-MM format
- `message`: User's message
- `status`: 'draft' (auto-saved) or 'submitted' (form submitted)
- Timestamps: `created_at`, `submitted_at`, `updated_at`

## API Endpoint

The API endpoint is located at: `/api/save_enquiry.php`

**Actions:**
- `save_field`: Saves individual field on blur
- `submit_form`: Saves complete form on submission

## How It Works

1. When a user starts filling the form, a unique `form_session_id` is generated
2. As the user leaves each input field (blur event), the field value is saved to the database
3. If a record doesn't exist, it's created. If it exists, it's updated
4. When the form is submitted, all data is saved with status 'submitted'
5. After successful submission, a new `form_session_id` is generated for the next form

## Testing

After setting up the database:
1. Fill out the form on the contact page
2. Check the database - you should see records being created/updated as you fill fields
3. Submit the form - the status should change to 'submitted'

