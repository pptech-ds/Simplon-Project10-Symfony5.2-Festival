# Project Specification  
[PDF Version](https://github.com/pptech-ds/Simplon-Project10-Symfony5.2-Festival/blob/main/public/docs/SimplonFestivalProjectSpecification.pdf)  

![image](https://user-images.githubusercontent.com/61125395/122833845-ea9a6080-d2ed-11eb-8e35-68936aee1b44.png)  
![image](https://user-images.githubusercontent.com/61125395/122833870-f1c16e80-d2ed-11eb-8eab-1e600d0158dd.png)  
![image](https://user-images.githubusercontent.com/61125395/122833888-f7b74f80-d2ed-11eb-9952-60ee1482281e.png)  
![image](https://user-images.githubusercontent.com/61125395/122833909-fdad3080-d2ed-11eb-9fdd-e6835b6845c0.png)  


# Project:Installation
1. Following the specification we need to install the project using symfony5.2:  
```console
symfony new Simplon-Project10-Symfony5.2-Festival --version=5.2 --full
```
![image](https://user-images.githubusercontent.com/61125395/123345615-c7beb500-d556-11eb-82a2-e02a54ad2d1e.png)  

2. Update the ".env" to setup the environement, we have updated "DATABASE_URL" and "MAILER_DSN":  
```config
# In all environments, the following files are loaded if they exist,
# the latter taking precedence over the former:
#
#  * .env                contains default values for the environment variables needed by the app
#  * .env.local          uncommitted file with local overrides
#  * .env.$APP_ENV       committed environment-specific defaults
#  * .env.$APP_ENV.local uncommitted environment-specific overrides
#
# Real environment variables win over .env files.
#
# DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.
#
# Run "composer dump-env prod" to compile .env files for production use (requires symfony/flex >=1.2).
# https://symfony.com/doc/current/best_practices.html#use-environment-variables-for-infrastructure-configuration

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=762097fa0fd7dd0f1b52197a8ebb369f
###< symfony/framework-bundle ###

###> symfony/mailer ###
MAILER_DSN=smtp://localhost:1025
###< symfony/mailer ###

###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
DATABASE_URL="mysql://root:@127.0.0.1:3306/Simplon-Project10-Symfony5.2-Festival?serverVersion=5.7"
# DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
###< doctrine/doctrine-bundle ###
```

3. Create database into PhpMyAdmin:  
```console
symfony console doctrine:database:create
```
![image](https://user-images.githubusercontent.com/61125395/123346396-79121a80-d558-11eb-9628-1dee26d8af31.png)  


# Project:Home

1. Make a branch "home" and create a controller to enable the "home" page:  
```console
git checkout -b home
symfony console make:controller
```
![image](https://user-images.githubusercontent.com/61125395/123345541-934af900-d556-11eb-80f0-dea9e77887d4.png)  


2. Update the created controller to define correct route for "home" page:  
```twig
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('festival/index.html.twig', [
            'controller_name' => 'FestivalController',
        ]);
    }
}
```
![image](https://user-images.githubusercontent.com/61125395/123346480-b8406b80-d558-11eb-9d1f-4c96053c2c9a.png)  

3. Update the model   
Using requested template "https://bootswatch.com/vapor/" we will update the model and necessary views, I am not going to detail all the steps here, but we need to proceed as usual to make changes into the model "src/templates/base.htlm.twig" and update the view "src/templates/festival/index.html.twig". We will update all relative path using "asset" twig function, and we will update also all "href" links using "path" and routes names, in order to have this "home" page:  
![image](https://user-images.githubusercontent.com/61125395/123349962-5123b680-d55a-11eb-9bce-4ec7fa748fdb.png)  

4. Commit into git  
```php
git add .
git commit -m 'home page fixed'
git push --set-upstream origin home
```

# Project:Users
1. If we look in details the given UML, We need first of all user management:  
![image](https://user-images.githubusercontent.com/61125395/123350955-5f72d200-d55c-11eb-8319-ed03cca063d6.png)  

Let's back to main branch and merge all changes done on branch "home", and create a new branch "user":  
```console
git checkout main
git merge home
git checkout -b user
```
   
And create user:  
```php
symfony console make:user
```
![image](https://user-images.githubusercontent.com/61125395/123351155-d4460c00-d55c-11eb-9991-3b6e28b2539d.png)  
We can see that 2 files("src/Entity/User.php" and "src/Repository/UserRepository.php") were created and updated. After checking the created files, we need to create entity into our database, so let's do a migration to create migration file which will be used to create the entity into our database.
```console
symfony console make:migration
symfony console doctrine:migrations:migrate
```
![image](https://user-images.githubusercontent.com/61125395/123351592-be851680-d55d-11eb-972c-683f0bd8b3c1.png)  
![image](https://user-images.githubusercontent.com/61125395/123351632-d492d700-d55d-11eb-86f6-bbaca4e41d8f.png)  

We need also authentication system to manage users: 
```console
symfony console make:auth
```
![image](https://user-images.githubusercontent.com/61125395/123353143-2d17a380-d561-11eb-93c6-8fd0b74b1890.png)  

We can see 3 files were created and one updated:
  - Into "src/Controller/SecurityController.php", we can see that routes to "login" and "logout" are defined, we don't need to change them, let's keep it as it is.
  - Into "config/packages/security.yaml", we can see some updates concerning "login" and "logout", no need to change anything.
  - Into "src/Security/UserAuthenticator.php", there is a part where you see a "TODO", here we need to change the route, to redirect to home after the login process  
  - Into "templates/security/login.html.twig", for the moment we are going to keep it like that, we can optimize the front view later

We need also registration process to add users:
```console
symfony console make:registration-form
```
![image](https://user-images.githubusercontent.com/61125395/123354592-49690f80-d564-11eb-8995-8ca2bda43fc7.png)  
![image](https://user-images.githubusercontent.com/61125395/123354653-5b4ab280-d564-11eb-8821-47fb538c1abd.png)  
We can see that entity "User" has been updated and some files were created, we can also notice that there are some guidlines for next steps.

We need to install a specific bundle to check the email:  
```console
composer require symfonycasts/verify-email-bundle
```
![image](https://user-images.githubusercontent.com/61125395/123354827-b7add200-d564-11eb-9871-883c23434669.png)  

Now the controller "RegistrationController", we need to update the redirection and customize message flash if necessary, here we are going just going to update the redirection after registration, to move user on "home" page, so we just need to change at the end of method "verifyUserEmail":  
```twig
return $this->redirectToRoute('home');
```








