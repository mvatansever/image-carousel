# Image Carousel Filter
This application basically filtering the image in the uploaded CSV file regarding given parameters.

## Project Requirements
- PHP >=8.0
- Composer . You can find [here](https://getcomposer.org/download/) how to download and install.
- Symfony CLI . You can find [here](https://symfony.com/download) how to download and install.

## Install
- `composer install`
- `symfony server:start` then check `http://127.0.0.1:8000` to see symfony page.

## Upload CSV file command
- `bin/console image-list:csv-upload FULL_FIL_PATH`
- Example: `bin/console image-list:csv-upload /Users/mesutvatansever/Downloads/test.csv`

## Filter Endpoint

- Filter based on name: `http://127.0.0.1:8000/image?name=Beach`
- Filter based on discount percent: `http://127.0.0.1:8000/image?discount_percentage=12`
- Filter based on both name and discount percent: `http://127.0.0.1:8000/image?name=Beach&discount_percentage=12`

## Extra information

I have used **PHP generators** while reading the file to reduce memory consumption in case huge files and this took a bit extra time like around 20 mins.

I might add file upload feature instead of moving the file in the data folder but due to time restriction and since not using database didn't do that. 
Beside than this, I could add Unit test and Swagger also for API documentation but since there is only 1 endpoint I decide to explain all the details about it in the README already.