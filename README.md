# Image Carousel Filter
This application basically filtering the image in the uploaded CSV file regarding given parameters.

## Project Requirements
- PHP >=8.0
- Composer
- Symfony CLI

## Install
- `composer install`
- `symfony server:start`

## Upload CSV file command
- `bin/console image-list:csv-upload FULL_FIL_PATH`
- Example: `bin/console image-list:csv-upload /Users/mesutvatansever/Downloads/test.csv`

## Extra information

I have used PHP generators while reading the file to reduce memory consumption in case huge files and this took a bit extra time like around 20 mins.