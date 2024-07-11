# Kelly Patisserie

## Project Description

Kelly Patisserie is a showcase website for a pastry shop. The site displays cake listings, allowing visitors to explore various creations offered by the pastry shop. This project is developed using the Symfony framework following the MVC (Model-View-Controller) architecture.

## Requirements

- PHP >= 8.1
- Composer
- Symfony CLI (optional but recommended for some commands)

## Installation

### 1. Install Dependencies

Ensure you have Composer installed. Then, run the following command to install project dependencies:

``` bash
composer install
```

### 2. Configure the Application
Modify the .env file to configure your database parameters and any other necessary settings.

### 3. Create the Database
If the database does not exist yet, create it using the following command:
``` bash
php bin/console doctrine:database:create
```

### 4. Run migration
To apply migrations and update the database schema:
``` bash
php bin/console doctrine:database:migrate
```

### 5. Start the Development Server
To launch the Symfony development server, use:

``` bash
symfony server:start
```
Alternatively, if you prefer using PHP directly:

``` bash
php -S 127.0.0.1:8000 -t public
```

#### Usefull commands
``` bash
php bin/console cache:clear
```

## Project Structure
This project follows the typical MVC (Model-View-Controller) structure of Symfony:

Model: Represents the data and business logic. Managed by entities and repositories.
View: Represents the user interface. Managed by Twig templates.
Controller: Handles user requests and returns responses. Managed by controller classes.
