# MonacoLogin

### PROJECT INSTALLATION ###
# git clone https://github.com/BenjaminTournois/MonacoLogin.git

# composer update


### DB INITIALISATION ###

# Replace line 28 in .env by your Database informations - 
# EX : DATABASE_URL=mysql://root:@localhost/monacologin

# php bin/console doctrine:database:create

# Start server from /public

# Connect to your local address


### TO CREATE AN ADMIN AUTHENTIFICATION ###

# In /src/Controller/Admin/RegistrationController.php
# Uncomment line 26 then create a new account from the "Inscription" page on the website



