# Attendance Management System for School Staff

Automatically manage student attendance.  
This is a personal project done in a day, so some things tend to be hardcoded (such as ID limit).

## Components  
- ~~QR Scanner~~ Does not work, potentially due to untrusted SSL certificates. I wasted hours only to realize browsers block camera requests without SSL certificate.   
- Registration and Login system. (made manually)  
- School Staff Dashboard. (also made manually)  
- Attendance Interface. (also made manually)  
- Applied some good cryptography practices. This is my best effort in cryptography in an hour or so.

## How to run
> **Note**  
> The working directory should be the root of this project.  
> This is only a README on how to run this project as intended.  

* **Requirements**  
  - Docker Engine
  - Docker Compose
  - npm or yarn

* **Install**  
  While inside the `ams2` repostory, `cd` into the `ams2` app:
  ```pwsh
  $ cd ams2
  ```
  Then install
  ```pwsh
  # npm
  $ npm install
  # yarn
  $ yarn install
  ```

* **Build and run**  
  ```pwsh
  $ docker compose up
  ```
  <sup> If rebuilding, use `--build` flag.

* **Open**  
  http://localhost:41062/www

* **Stop**  
  Use `CTRL-C` or `docker ps` to find the name, and `docker kill <name>`

* **Uninstall**  
  ```pwsh
  $ docker compose down
  ```
  Then, you may remove any unneeded images (or uninstall Docker) and delete the cloned repository.

## How to setup
> **Note**  
> This is for a testing environment case only. If there is a need, documentation on a production-ready site will be published.

* **To access phpMyAdmin**  
  https://localhost:41062/phpmyadmin  
  <sup>Here, you can set up the user privileges as well.

* **Create a database**  
  ```sql
  CREATE TABLE `ams2`.`users` (`id_num` INT NOT NULL , `frst_name` TEXT NOT NULL , `last_name` TEXT NOT NULL , `password` VARCHAR(128) NOT NULL ) ENGINE = InnoDB; 
  ```
  ```sql
  CREATE TABLE `ams2`.`students` (`id_num` INT NOT NULL , `first_name` TEXT NOT NULL , `last_name` TEXT NOT NULL ) ENGINE = InnoDB;
  ```